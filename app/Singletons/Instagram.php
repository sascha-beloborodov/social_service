<?php

namespace App\Singletons;

// Singleton, Register etc... Class-keeper instagram sdk
// Usually initiates in InstagramAuthorize middleware
class Instagram {

	private static $instance;

	private function __constructor() {}

	public static function getInstance()
	{
		if (self::$instance) {
			return self::$instance;
		}
		self::$instance = new \InstagramAPI\Instagram();
		return self::$instance;
	}

	public static function getMediaID($url)
    {
        if (!isset($url) || !$url) {
            throw new \Exception("Error: Empty params passed");
        }
        $mediaResponse = file_get_contents("https://api.instagram.com/oembed?url=$url");
        $mediaResponseAsArray = json_decode($mediaResponse, true);
        if (empty($mediaResponseAsArray['media_id'])) {
            throw new \Exception("Cannot get media id");
        }
        return $mediaResponseAsArray['media_id'];
    }
}