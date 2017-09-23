<?php

class HomeController extends Controller {
	
	public function __construct(){
		$this->middleware('auth');
	}

	public function home(){
		return $this->view('index');
	}

}

?>