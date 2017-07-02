<?php

class Controller {

    public $middleware = 'web';

    public static function getInstance(){
        return new static;
    }
    
    public function middleware($middleware){
        $this->middleware = $middleware;
    }

    protected function model($model){
        require_once '../core/Models/'.$model.'.php';
        return new $model;
    }
    
    protected function view($view, $params = []){
        $twig = Twig::get();
        $loggedin = Session::isLoggedIn();
        $parameter = [ 
                        'loggedin'  => $loggedin, 
                        'integrity' => Repo::getToken(), 
                     ];
        $parameter += $params;
        try {
            if (file_exists('../core/Views/'.$view.'.twig')) {
                echo $twig->render($view.'.twig', $parameter);
                return true;
            } else {
                $parameter += ['code' => 404,'message' => Repo::getError(404)];
                echo $twig->render('error.twig', $parameter);
                return header("HTTP/1.1 404 Not Found");
            }
        } catch (Exception $e){
            if (Kernel::config('mvc.debug')){
                $message = $e->getMessage();
            } else {
                $message = 'There was an Error.';
            }
            $parameter += ['code' => 1530,'message' => $message];
            echo $twig->render('error.twig', $parameter);
            return header("HTTP/1.1 404 Not Found");
        }
    }
}

?>