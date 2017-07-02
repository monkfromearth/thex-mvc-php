<?php

class GuestMiddleware extends Middleware {

	public $redirectTo = '/home';

	public function handle(){
		if (!Session::isLoggedIn()){
			return true;
		}
		return Repo::redirect($this->redirectTo);
	}
	
}

?>