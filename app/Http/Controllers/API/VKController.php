<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\VKGetDialogs;
use App\Http\Requests\VKGetFriends;
use App\Http\Requests\VKGetGroup;
use App\Http\Requests\VKGetGroups;
use App\Http\Requests\VKGetHistoryMessages;
use App\Http\Requests\VKGetMessages;
use App\Http\Requests\VKGetUsers;
use App\Http\Requests\VKSendMessage;
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
		    return $this->sendResponse($dialogs['response'], 'Messages are fetched successfully');
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
		    return $this->sendResponse($groups['response'], 'Messages are fetched successfully');
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
		    return $this->sendResponse($groups['response'], 'Messages are fetched successfully');
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
		    return $this->sendResponse($friends['response'], 'Messages are fetched successfully');
	    } catch (\Exception $e) {
		    // log
		    return $this->sendError($e->getMessage(), 400);
	    }
    }

}
