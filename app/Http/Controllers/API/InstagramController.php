<?php

namespace App\Http\Controllers\API;

use App\Defines\Fields;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\InstagramDeleteCommentPost;
use App\Http\Requests\InstagramGetCommentsPost;
use App\Http\Requests\InstagramGetUserById;
use App\Http\Requests\InstagramGetUserByUsername;
use App\Http\Requests\InstagramSendDirectImage;
use App\Http\Requests\InstagramSendDirectMessage;
use App\Http\Requests\InstagramToBanUser;
use App\Singletons\Instagram;
use Illuminate\Http\Request;
use InstagramAPI\Response\Model\Comment;
use InstagramAPI\Response\Model\DirectThread;
use InstagramAPI\Response\Model\DirectThreadItem;
use InstagramAPI\Response\Model\User;

class InstagramController extends AppBaseController
{

	/**
	 * Sends message to user.
	 * Notice!
	 * If user did not approve - he doesn't see a message
	 *
	 * @param InstagramSendDirectMessage $request
	 *
	 * @return mixed
	 */
	public function sendMessage(InstagramSendDirectMessage $request)
	{
		try {
			$userId = $request->get(Fields::USER_IDENTIFIER);
			$message = $request->get(Fields::MESSAGE);

			$sentMessageResponse = \App\Singletons\Instagram
				::getInstance()
				->direct
				->sendText(['users' => [$userId]], $message);

			return $this->sendResponse([
				'status' => $sentMessageResponse->getStatus()
			], 'Your message was sent');
		} catch (\Exception $e) {
			// log, notify
			return $this->sendError($e->getMessage(), 400);
		}
	}

	/**
	 * Sends image to user.
	 * Notice! Also as 'sendText' -
	 * If user did not approve - he doesn't see a message
	 *
	 * @param InstagramSendDirectImage $request
	 *
	 * @return mixed
	 */
	public function sendImage(InstagramSendDirectImage $request)
	{
		try {
			$userId = $request->get(Fields::USER_IDENTIFIER);
			$image = $request->file(Fields::IMAGE);

			$sentMessageResponse = \App\Singletons\Instagram
				::getInstance()
				->direct
				->sendPhoto(['users' => [$userId]], $image);

			return $this->sendResponse([
				'status' => $sentMessageResponse->getStatus()
			], 'Your message was sent');
		} catch (\Exception $e) {
			// log, notify
			return $this->sendError($e->getMessage(), 400);
		}
	}

    /**
     * Get threads of a current user. <br>
     * Pending threads will approve automatically
     *
     * @param Request $request
     * @return DirectThread[]
     */
	public function getThreads(Request $request)
    {
        // approve pending threads automatically if they exist
        try {
            $pendingThreads = \App\Singletons\Instagram
                ::getInstance()
                ->direct
                ->getPendingInbox()
                ->getInbox()
                ->getThreads();
            if (!empty($pendingThreads)) {
                $threadIds = array_map(function($thread) {
                    /** @var DirectThread @thread */
                    return $thread->getThreadId();
                }, $pendingThreads);
                Instagram::getInstance()->direct->approvePendingThreads($threadIds);
            }
            $inbox = Instagram::getInstance()->direct->getInbox()->inbox->getThreads();
            return $this->sendResponse($inbox, 'Threads are fetched successfully');
        } catch (\Exception $e) {
            // log
            return $this->sendError($e->getMessage(), 400);
        }
    }

    /**
     * Get history of all threads (all users). <br>
     * TODO: make separate methods - getHistoryByThread and getHistoryByUserId
     *
     * @param Request $request
     * @return mixed
     */
    public function getAllHistoryMessages(Request $request)
    {
        try {
            $responseMessages = [];
            $threads = Instagram::getInstance()->direct->getInbox()->inbox->getThreads();
            foreach ($threads as $thread) {
                $inbox = Instagram::getInstance()->direct->getThread($thread->getThreadId())->getThread();
                $messages = $inbox->getItems();

                if (empty($messages)) {
                    continue;
                }
                $cursor = null;
                do {
                    /** @var DirectThreadItem $message */
                    foreach ($messages as $message) {
                        $responseMessages[$message->getUserId()][] = [
                            'attachments' => $message->getItemType() == 'media' && !empty($message->getMedia()) ? json_encode($message->getMedia()) : '',
                            'message' => $message->getText() ?? '',
                            'time' => intval($message->getTimestamp() / 1000000),
                            'from' => $message->getUserId(),
                            'is_read' => 0,
                            'is_client' => $message->getUserId() == Instagram::getInstance()->account_id ? 1 : 0,
                        ];
                    }
                    // move cursor
                    $cursor = Instagram::getInstance()->direct->getThread($thread->getThreadId(), $cursor)->getThread()->getOldestCursor() ?? null;
                    if (empty($cursor)) {
                        break;
                    }
                    // get next messages by cursor
                    $messages = Instagram::getInstance()->direct->getThread($thread->getThreadId(), $cursor)->getThread()->getItems() ?? null;
                    if (empty($messages)) {
                        break;
                    }
                } while (true);
            }
            return $this->sendResponse($responseMessages, 'Messages are fetched successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }

    public function getCommentsPost(InstagramGetCommentsPost $request)
    {
        try {
            $commentsResponse = [];
            $mediaId = Instagram::getMediaID($request->get('post_url'));
            $comments = Instagram::getInstance()->media->getComments($mediaId)->getComments() ?? [];
            /** @var Comment $comment */
            foreach ($comments as $comment) {
                $commentsResponse[] = [
                    "message" => $comment->getText(),
                    "from" => $comment->getUserId(),
                    "time" => (int) $comment->getCreatedAtUtc(),
                    "is_read" => "0",
                    'is_client' => $comment->getUserId() == Instagram::getInstance()->account_id ? 1 : 0,
                ];
            }
            return $this->sendResponse($commentsResponse, 'Comments are fetched successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }

    public function deleteCommentPost(InstagramDeleteCommentPost $request)
    {
        try {
            $postId = Instagram::getMediaID($request->get('media_url'));
            $commentIds = array_map(function($id) {
                return trim($id);
            }, explode(',', $request->get('comment_ids')));
            $deletedCommentsResponse = Instagram::getInstance()->media->deleteComments($postId, $commentIds)->getStatus();
            return $this->sendResponse('Status - ' . $deletedCommentsResponse, 'Comment is deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }

    public function toBan(InstagramToBanUser $request)
    {
        try {
            $response = Instagram::getInstance()->people->block($request->get('user_id'))->getStatus();
            return $this->sendResponse('Status - ' . $response, 'User is banned successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }

    public function getUserById(InstagramGetUserById $request)
    {
        try {
            /** @var User $user */
            $user = Instagram::getInstance()->people->getInfoById($request->get('user_id'))->getUser();
            return $this->sendResponse([
                'id' => $user->getUserId(),
                "domain" => $user->getUsername(),
                "avatar" => $user->getProfilePicUrl(),
                "name" => $user->getUsername(),
                "city" => $user->getCityName(),
                "phone" => $user->getPhoneNumber(),
                "email" => $user->getEmail(),
                "followers_count" => $user->getFollowerCount()
            ], 'User is fetched successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }

    public function getByUserName(InstagramGetUserByUsername $request)
    {
        try {
            /** @var User $user */
            $user = Instagram::getInstance()->people->getInfoByName($request->get('username'))->getUser();
            return $this->sendResponse([
                'id' => $user->getUserId(),
                "domain" => $user->getUsername(),
                "avatar" => $user->getProfilePicUrl(),
                "name" => $user->getUsername(),
                "city" => $user->getCityName(),
                "phone" => $user->getPhoneNumber(),
                "email" => $user->getEmail(),
                "followers_count" => $user->getFollowerCount()
            ], 'User is fetched successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }
}
