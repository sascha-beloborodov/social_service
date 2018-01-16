<?php

namespace App\Http\Controllers\API;

use App\Defines\Fields;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\InstagramSendDirectImage;
use App\Http\Requests\InstagramSendDirectMessage;
use Illuminate\Http\Request;
use InstagramAPI\Instagram;

class InstagramController extends AppBaseController
{

	/**
	 * Sends message to user.
	 * Notice!
	 * If user did not approve - hi doesn't see a message
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
	 * If user did not approve - hi doesn't see a message
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
}
