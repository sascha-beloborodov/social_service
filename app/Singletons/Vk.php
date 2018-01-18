<?php

namespace App\Singletons;

// Singleton, Register etc... Class-keeper instagram sdk
// Usually initiates in VKAuthorize middleware
use ATehnix\VkClient\Client;

class Vk {

	private static $instance;

	private function __constructor() {}

	public static function getInstance()
	{
		if (self::$instance) {
			return self::$instance;
		}
		self::$instance = new Client();
		return self::$instance;
	}

	public static function request($method, $parameters = [], $token = [])
	{
		return self::getInstance()->request($method, $parameters, $token);
	}
}