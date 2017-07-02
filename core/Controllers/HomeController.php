<?php

class HomeController extends Controller {
	
	public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		return $this->view('index');
	}

}

?>