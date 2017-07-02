<?php

class Kernel {

	protected static $config;
	protected static $config_default = null;

	public static function middleware($name){

		$middlewares = [
			'web'	=>	WebMiddleware::getInstance(),
			'auth'	=>	AuthMiddleware::getInstance(),
			'guest'	=>	GuestMiddleware::getInstance(),
		];

		return array_get($middlewares, $name, $middlewares['web']);
	}

	public static function loadConfig(){
		self::$config = require_once('../config.php');
	}

	public static function config($key, $default = null){

		self::$config_default = $default;
		$config = self::$config;
		$gets = explode('.', $key);

		foreach ($gets as $get){

			if (isset($config[$get])){

				$config = $config[$get];

			} else {

				$config = self::$config_default;
				break;

			}

		}

		return $config;
	}


}

?>