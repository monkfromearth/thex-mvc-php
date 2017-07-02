<?php

class Request {

	public static function has($input = null){

		if (isset($_REQUEST[$input]) && !empty($_REQUEST[$input])){
			return true;
		}
		return false;

	}

	public static function e($input = null){
		return htmlentities($input);
	}

	public static function get($input = null){
		if (self::has($input)){
			return self::e($_REQUEST[$input]);
		} 
		return null;
	}

	public static function getInstance(){
		return new static;
	}

	public function __get($input){
		return Request::get($input);
	}

	public static function flush(){

		$keys = array_keys($_REQUEST);

		for ($i = 0; $i < count($keys); $i++){
			unset($_REQUEST[$keys[$i]]);
		}

	}
	
}

?>