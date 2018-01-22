<?php

namespace App\Http\Controllers\API;

use App\Defines\Fields;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\InstagramSendDirectImage;
use App\Http\Requests\InstagramSendDirectMessage;
use App\Singletons\Instagram;
use Illuminate\Http\Request;
use InstagramAPI\Response\Model\DirectThread;

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
    public function getHistoryMessages(Request $request)
    {
        $responseMessages = [];
        $threads = Instagram::getInstance()->direct->getInbox()->inbox->getThreads();
        foreach ($threads as $thread) {
            $inbox = Instagram::getInstance()->direct->getThread($thread->getThreadId())->getThread();
            $messages = $inbox->getItems();
            dd($thread);
            if (empty($messages)) {
                continue;
            }
            $cursor = null;

            do {
                if (empty($messages)) {
                    break;
                }
                foreach ($messages as $message) {
                    $responseMessages[$message['user_id']][] = [
                        'attachments' => $message['item_type'] == 'media' && !empty($message['media']) ? json_encode($message['media']) : '',
                        'message' => $message['text'] ?? '',
                        'time' => intval($message['timestamp'] / 1000000),
                        'from' => $message['user_id'],
                        'is_read' => 0,
                        'is_client' => $message['user_id'] == Instagram::getInstance()->account_id ? 1 : 0,
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
    }
}
