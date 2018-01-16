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
}