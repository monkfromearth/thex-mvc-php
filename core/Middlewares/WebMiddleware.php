<?php

class WebMiddleware extends Middleware {

	public $redirectTo = '/';
	
	public function handle(){	
		return true;
	}

}

?>