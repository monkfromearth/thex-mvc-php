<?php

class AuthMiddleware extends Middleware {

	public $redirectTo = '/login';

	public function handle($next = null, $request = null){	

		/*if (Session::isLoggedIn()){
			return true;
		} else {
			return Repo::redirect($this->redirectTo);
		}*/
		
		return true;

	}
	
}

?>