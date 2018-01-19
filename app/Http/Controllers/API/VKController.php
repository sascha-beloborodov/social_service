<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\VKCreatePost;
use App\Http\Requests\VKCreatePostComment;
use App\Http\Requests\VKDeletePost;
use App\Http\Requests\VKDeletePostComment;
use App\Http\Requests\VKEditPost;
use App\Http\Requests\VKEditPostComment;
use App\Http\Requests\VKGetDialogs;
use App\Http\Requests\VKGetFriends;
use App\Http\Requests\VKGetGroup;
use App\Http\Requests\VKGetGroups;
use App\Http\Requests\VKGetHistoryMessages;
use App\Http\Requests\VKGetMessages;
use App\Http\Requests\VKGetPost;
use App\Http\Requests\VKGetPostComments;
use App\Http\Requests\VKGetPosts;
use App\Http\Requests\VKGetUsers;
use App\Http\Requests\VKSendMessage;
use App\Http\Requests\VKToLike;
use App\Singletons\Vk;
use ATehnix\VkClient\Auth;
use ATehnix\VkClient\Exceptions\AccessDeniedVkException;
use Illuminate\Http\Request;

class VKController extends AppBaseController
{
	const TOTAL_ATTEMPTS = 5;
	private static $attempts = 0;

	/**
	 * @param VKGetUsers $request
	 *
	 * @return mixed
	 */
    public function getUsersById(VKGetUsers $request)
    {
    	try {
		    $users = Vk::getInstance()->request('users.get', [
			    'user_ids' => $request->get('user_ids'),
			    'fields' => $request->get('fields')
		    ]);
		    if (empty($users['response'])) {
			    throw new \Exception("Error Processing Request: " . json_encode($users));
		    }
		    return $this->sendResponse($users['response'], 'Users are fetched successfully');
	    } catch (\Exception $e) {
    		// log
		    return $this->sendError($e->getMessage(), 400);
	    }
    }

	/**
	 * todo: pagination?
	 *
	 * Notice! Only standalone-permissions - messages
	 *
	 * @param VKGetMessages $request
	 *
	 * @return mixed
	 */
    public function getMessages(VKGetMessages $request)
    {
	    $params = [
		    'count' => 200,
		    'preview_length' => 0,
		    'last_message_id' => $request->get('last_message_id', 0),
	    ];
	    try {
		    $messages = Vk::getInstance()->request('messages.get', $params);

		    if (empty($messages['response'])) {
			    throw new \Exception("Error Processing Request: " . json_encode($messages));
		    }
		    return $this->sendResponse($messages['response'], 'Messages are fetched successfully');
	    } catch (\Exception $e) {
		    // log
		    return $this->sendError($e->getMessage(), 400);
	    }
    }


	/**
	 * Notice! Only standalone-permissions - messages
	 *
	 * @param VKSendMessage $request
	 *
	 * @return mixed
	 */
    public function sendMessage(VKSendMessage $request)
    {
	    try {
		    $messages = Vk::getInstance()->request('messages.send', [
		    	'peer_id' => $request->get('user_id'),
		    	'message' => $request->get('message'),
		    	'attachment' => $request->get('attachment'),
		    ]);

		    if (empty($messages['response'])) {
			    throw new \Exception("Error Processing Request: " . json_encode($messages));
		    }
		    // returns an id of is sent message
		    return $this->sendResponse($messages['response'], 'Message is sent successfully');
	    } catch (\Exception $e) {
		    // log
		    return $this->sendError($e->getMessage(), 400);
	    }
    }

	/**
	 * Notice! Only standalone-permissions - messages
	 *
	 * @param VKGetHistoryMessages $request
	 *
	 * @return mixed
	 */
    public function getHistoryMessages(VKGetHistoryMessages $request)
    {
	    $params = [
		    'user_id' => $request->get('user_id'),
		    'offset' => $request->get('offset', 0),
		    'count' => $request->get('count', 1),
	    ];
	    try {
		    $messages = Vk::getInstance()->request('messages.getHistory', $params);

		    if (empty($messages['response'])) {
			    throw new \Exception("Error Processing Request: " . json_encode($messages));
		    }
		    return $this->sendResponse($messages['response'], 'Messages are fetched successfully');
	    } catch (\Exception $e) {
		    // log
		    return $this->sendError($e->getMessage(), 400);
	    }
    }

	/**
	 * Notice! Only standalone-permissions - messages
	 *
	 * @param VKGetDialogs $request
	 *
	 * @return mixed
	 */
    public function getDialogs(VKGetDialogs $request)
    {
	    $params = [
	        'offset' => $request->get('offset', 0),
	        'count' => $request->get('count', 1),
	    ];
	    try {
		    $dialogs = Vk::getInstance()->request('messages.getDialogs', $params);

		    if (empty($dialogs['response'])) {
			    throw new \Exception("Error Processing Request: " . json_encode($dialogs));
		    }
		    return $this->sendResponse($dialogs['response'], 'Dialogs are fetched successfully');
	    } catch (\Exception $e) {
		    // log
		    return $this->sendError($e->getMessage(), 400);
	    }
    }

    public function getGroupById(VKGetGroup $request)
    {
	    $params = [
		    'extended' => 1,
	    ];
	    $isSeveralGroups = strpos( trim($request->get('group_ids'), ','), ',') !== false;

	    $field = $isSeveralGroups ? 'group_ids' : 'group_id';

	    $params[$field] = $request->get('group_ids');

	    try {
		    $groups = Vk::getInstance()->request('groups.getById', $params);

		    if (empty($groups['response'])) {
			    throw new \Exception("Error Processing Request: " . json_encode($groups));
		    }
		    return $this->sendResponse($groups['response'], 'Groups are fetched successfully');
	    } catch (\Exception $e) {
		    // log
		    return $this->sendError($e->getMessage(), 400);
	    }
    }



    public function getGroups(VKGetGroups $request)
    {
    	$params = [];

		if (!empty($request->get('user_id'))) {
			$params['user_id'] = $request->get('user_id', 0);
		}

		$params['fields'] = $request->get('fields', 'id,name,screen_name,photo_200') ;
		$params['extended'] = $request->get('extended', 0) ;

	    try {
		    $groups = Vk::getInstance()->request('groups.get', $params);

		    if (empty($groups['response'])) {
			    throw new \Exception("Error Processing Request: " . json_encode($groups));
		    }
		    return $this->sendResponse($groups['response'], 'Groups are fetched successfully');
	    } catch (\Exception $e) {
		    // log
		    return $this->sendError($e->getMessage(), 400);
	    }
    }


    public function getFriends(VKGetFriends $request)
    {
	    $params = [];

	    if (!empty($request->get('user_id'))) {
		    $params['user_id'] = $request->get('user_id', 0);
	    }

	    $params['fields'] = $request->get('fields', 'bdate,books,career,city,connections,contacts,counters,country,domain,education,last_seen') ;

	    try {
		    $friends = Vk::getInstance()->request('friends.get', $params);

		    if (empty($friends['response'])) {
			    throw new \Exception("Error Processing Request: " . json_encode($friends));
		    }
		    return $this->sendResponse($friends['response'], 'Friends are fetched successfully');
	    } catch (\Exception $e) {
		    // log
		    return $this->sendError($e->getMessage(), 400);
	    }
    }


    public function toLikeById(VKToLike $request)
    {
	    $params = [
		    'type' => $request->get('type'),
		    'owner_id' => $request->get('owner_id'),
		    'item_id' => $request->get('item_id'),
	    ];
	    try {
		    $liked = Vk::getInstance()->request('likes.add', $params);

		    if (empty($liked['response'])) {
			    throw new \Exception("Error Processing Request: " . json_encode($liked));
		    }
		    return $this->sendResponse($liked['response'], 'Like is added successfully');
	    } catch (\Exception $e) {
		    // log
		    return $this->sendError($e->getMessage(), 400);
	    }
    }


    public function getOnePost(VKGetPost $request)
    {
    	$params = [];
    	$postId = $request->get('post_id');
    	$ownerId = $request->get('owner_id');
	    $fields = $request->get('fields');

		if (is_int($postId)) {
			$params['posts'] = $ownerId . '_' . $postId;
		} else {
			$posts = join(',', array_map(function ($postId) use ($ownerId) {
				return $ownerId.'_'.$postId.',';
			}, $postId));
			$params['posts'] = substr($posts, 0, strlen($posts) - 1);
		}

	    if (!empty($fields)) {
		    $params['fields'] = $fields;
	    }

	    try {
		    $post = Vk::getInstance()->request('wall.getById', $params);

		    if (empty($post['response'])) {
			    throw new \Exception("Error Processing Request: " . json_encode($post));
		    }
		    return $this->sendResponse($post['response'], 'Post is fetched successfully');
	    } catch (\Exception $e) {
		    // log
		    return $this->sendError($e->getMessage(), 400);
	    }
    }


	public function getPosts(VKGetPosts $request)
	{
		$params = [
			'owner_id' => $request->get('owner_id', 0),
			'offset' => $request->get('offset', 0),
			'count' => $request->get('count', 1),
		];
		try {
			$posts = Vk::getInstance()->request('wall.get', $params);

			if (empty($posts['response'])) {
				throw new \Exception("Error Processing Request: " . json_encode($posts));
			}
			return $this->sendResponse($posts['response'], 'Posts are fetched successfully');
		} catch (\Exception $e) {
			// log
			return $this->sendError($e->getMessage(), 400);
		}
	}


	public function createPost(VKCreatePost $request)
	{
		$params = [
			'owner_id' => $request->get('owner_id'),
			'message' => $request->get('message'),
			'from_group' => $request->get('from_group', 0),
			'attachments' => $request->get('attachments', ''),
		];
		try {
			$created = Vk::getInstance()->request('wall.post', $params);

			if (empty($created['response'])) {
				throw new \Exception("Error Processing Request: " . json_encode($created));
			}
			return $this->sendResponse($created['response'], 'Post is added successfully');
		} catch (\Exception $e) {
			// log
			return $this->sendError($e->getMessage(), 400);
		}
	}


	public function editPost(VKEditPost $request)
	{
		$params = [
			'owner_id' => $request->get('owner_id'),
			'post_id' => $request->get('post_id'),
			'message' => $request->get('message'),
			'attachments' => $request->get('attachments'),
		];
		try {
			$edited = Vk::getInstance()->request('wall.edit', $params);

			if (empty($edited['response'])) {
				throw new \Exception("Error Processing Request: " . json_encode($edited));
			}
			return $this->sendResponse($edited['response'], 'Post is edited successfully');
		} catch (\Exception $e) {
			// log
			return $this->sendError($e->getMessage(), 400);
		}
	}


	public function deletePost(VKDeletePost $request)
	{
		$params = [
			'owner_id' => $request->get('owner_id'),
			'post_id' => $request->get('post_id'),
		];
		try {
			$deleted = Vk::getInstance()->request('wall.delete', $params);

			if (empty($deleted['response'])) {
				throw new \Exception("Error Processing Request: " . json_encode($deleted));
			}
			return $this->sendResponse($deleted['response'], 'Post is deleted successfully');
		} catch (\Exception $e) {
			// log
			return $this->sendError($e->getMessage(), 400);
		}
	}

	public function getComments(VKGetPostComments $request)
	{
		$params = [
			'owner_id' => $request->get('owner_id'),
			'post_id' => $request->get('post_id'),
			'offset' => $request->get('offset', 0),
			'count' => $request->get('count', 10),
		];
		if (!empty($request->get('extended'))) {
			$params['extended'] = $request->get('extended');
		}
		if (!empty($request->get('fields'))) {
			$params['fields'] = $request->get('fields');
		}
		try {
			$comments = Vk::getInstance()->request('wall.getComments', $params);

			if (empty($comments['response'])) {
				throw new \Exception("Error Processing Request: " . json_encode($comments));
			}
			return $this->sendResponse($comments['response'], 'Comments are fetched successfully');
		} catch (\Exception $e) {
			// log
			return $this->sendError($e->getMessage(), 400);
		}
	}


	public function createPostComment(VKCreatePostComment $request)
	{
		$params = [
			'owner_id' => $request->get('owner_id'),
			'post_id' => $request->get('post_id'),
			'message' => $request->get('message'),
		];
		if (!empty($request->get('attachments'))) {
			$params['attachments'] = $request->get('attachments');
		}
		try {
			$created = Vk::getInstance()->request('wall.createComment', $params);

			if (empty($created['response'])) {
				throw new \Exception("Error Processing Request: " . json_encode($created));
			}
			return $this->sendResponse($created['response'], 'Comment is added successfully');
		} catch (\Exception $e) {
			// log
			return $this->sendError($e->getMessage(), 400);
		}
	}

	public function editPostComment(VKEditPostComment $request)
	{
		$params = [
			'owner_id' => $request->get('owner_id'),
			'comment_id' => $request->get('comment_id'),
			'message' => $request->get('mesasge'),
		];
		if (!empty($request->get('attachments'))) {
			$params['attachments'] = $request->get('attachments');
		}
		try {
			$edited = Vk::getInstance()->request('wall.editComment', $params);

			if (empty($edited['response'])) {
				throw new \Exception("Error Processing Request: " . json_encode($edited));
			}
			return $this->sendResponse($edited['response'], 'Comment is edited successfully');
		} catch (\Exception $e) {
			// log
			return $this->sendError($e->getMessage(), 400);
		}
	}

	public function deletePostComment(VKDeletePostComment $request)
	{
		$params = [
			'owner_id' => $request->get('owner_id'),
			'comment_id' => $request->get('comment_id'),
		];
		try {
			$deleted = Vk::getInstance()->request('wall.deleteComment', $params);

			if (empty($deleted['response'])) {
				throw new \Exception("Error Processing Request: " . json_encode($deleted));
			}
			return $this->sendResponse($deleted['response'], 'Comment is edited successfully');
		} catch (\Exception $e) {
			// log
			return $this->sendError($e->getMessage(), 400);
		}
	}
}
