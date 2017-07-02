<?php

class Route {

	protected static $path = '/';
    protected static $builder = 'HomeController:home';
	protected static $controller = 'HomeController';
	protected static $method = 'home';
	protected static $parameter = [];
	protected static $middleware = null;


    /**
    *
    *@var $url from .htaccess
    * Parses URL into Chunks and combines into Array
    */

    protected static function parseURL($url){
        if (isset($url) && !empty($url)){
           return $url = explode('/',filter_var(trim($url, '/'), FILTER_SANITIZE_URL));
        }
    }

    /**
    *
    *@var array $path
    * Gets All Variables in a Given Path
    */

    protected static function getVar(array $path){
        $var = [];
        for ($i = 0; $i < count($path); $i++){
            if (empty(strip_tags($path[$i]))){
                $var[$i] = $path[$i];
            }
        }
        return $var;
    }

	/**
	*
	*@var $path, $controller, $method
	* Checks for Variables and Non-variables
	*/

	public static function get($path, $builder = 'HomeController:home', $middleware = null){
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            self::start($path, $builder, $middleware);
        } 
        return null;
	}

    public static function post($path, $builder = 'HomeController:home', $middleware = null){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            self::start($path, $builder, $middleware);
        } 
        return null;
    }

    /**
    *
    * Parses URL and Starts Rendering
    */

    public static function start($path, $builder = 'HomeController:home', $middleware = null){

        if (isset($_GET['url']) && !empty($_GET['url'])){

            $url = self::parseURL(htmlentities(strtolower($_GET['url'])));
            $path = self::parseURL($path);

            if (count(array_intersect_assoc($url, $path)) != 0) {

                if (count($url) - count($path) == 0){

                    if ( count(array_intersect_assoc($url, $path)) == (count($path) - count(self::getVar($path))) ){

                        $parameter = $url ? array_diff_assoc($url, $path) : [];
                        self::$parameter = $parameter;
                        self::$middleware = $middleware;      
                        self::$builder = $builder;
                        self::parse();
                        if (self::middleware()){
                            return self::render();
                        }
                    }
                }
            }
            return null;
        }

        self::parse();
        if (self::middleware()){
            return self::render();
        }

    }

    /**
    *
    * Parses the Builder into Controller and Method, and Instantiates
    */

    protected static function parse(){

        $builder = explode(':', self::$builder);
        $method = array_get($builder, 1, 'home');
        $controller = array_get($builder, 0, 'HomeController');

        if (file_exists('../core/Controllers/'.$controller.'.php')){
            self::$controller = $controller;
        }

        require_once '../core/Controllers/'.self::$controller.'.php';

        self::$controller = new self::$controller;

        if (!empty($method)){
            if (method_exists(self::$controller, $method)){
                self::$method = $method;
            }
        }
        
    }

    /**
    *
    * Checks for the Middleware
    */

    protected static function middleware(){

        if (self::$middleware == null){
            self::$middleware = self::$controller->middleware;
        }

        return Kernel::middleware(self::$middleware)->handle();
        
    }

    /**
    *
	*@var array $controller
    * Calls the Given Function of a Controller
    */

    protected static function render(){

        call_user_func_array([self::$controller, self::$method], self::$parameter); die();

    }

    /**
    *
    * Aborts the page with an Error Code
    */

    public static function abort($code = 404){
    	switch ($code){
    		case 403: header("HTTP/1.1 403 Unauthorized"); 
    			break;
    		case 404: 
    		default:  header("HTTP/1.1 404 Not Found");
    			break;
    	}
        self::$builder = 'ErrorController:error';
    	self::$parameter = [$code];
        self::parse();
        if (self::middleware()){
            return self::render();
        }
    }

}

?>