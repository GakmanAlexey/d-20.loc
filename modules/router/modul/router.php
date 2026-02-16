<?php

namespace Modules\Router\Modul;

class Router{
    // \Modules\Router\Modul\Router::start();
    public static $url;
    public static $need300 =  false;
    public static function start(){
        self::get_url_page();
        self::need_redirect300();
        \Modules\Router\Modul\Loader::load_default_routes();
        self::go();
    }
    public static function go(){
        $currentPath = self::$url["d_line"] ?? '/';

        $route = \Modules\Router\Modul\Collector::get_route($currentPath);

        if ($route === null) {
            Errorhandler::e404();
            return;
        }

        $class  = $route['class'];
        $method = $route['function'];

        if (!class_exists($class)) {
            Errorhandler::e500([
                'error_message' => "Controller not found: $class"
            ]);
            return;
        }

        $controller = new $class;

        if (!method_exists($controller, $method)) {
            Errorhandler::e500([
                'error_message' => "Method $method not found in $class"
            ]);
            return;
        }

        try {
            $controller->$method();
        } catch (\Throwable $e) {
            Errorhandler::e500([
                'error_message' => $e->getMessage(),
                'exception'     => $e
            ]);
        }
    }


    public static function need_redirect300(){
        if(self::$need300){
            $url = self::$url['d_line'];
            if(isset(self::$url["get_in_line"]) and self::$url["d_of_get_line"] != ""){
                $url = $url."?".self::$url["d_of_get_line"];
            }
            header("Location: $url", true, 301);
            die();
        }
        return;
    }

    public static function get_url_page(){
        self::$url = [];
        self::$url['all'] = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        self::$url['protocol'] = (!empty($_SERVER['HTTPS'])) ? 'https' : 'http';
        self::$url['domen'] = $_SERVER['HTTP_HOST'] ;
        
        $dir = explode('?', $_SERVER['REQUEST_URI']);        
        if(substr($dir[0], -1) != "/") {
            $dir[0].= "/";
            self::$need300 = true;
        }

        self::$url['d_line'] = $dir[0];
        if(isset($dir[1])){
            self::$url['d_of_get_line'] = $dir[1];
        }else{
            self::$url['d_of_get_line'] = "";
        }
        self::$url['d_array'] = explode('/', self::$url['d_line']);
        self::$url['direct_size'] = count(self::$url['d_array']) - 2;

        self::take_get();
        self::take_post();
    }

    public static function take_get(){
        if(!empty($_GET)){
            self::$url['get'] = $_GET;  
        }      
    }

    public static function take_post(){
        if(!empty($_POST)){
            self::$url['post'] = $_POST;
        };
    }

    public static function dispatch(string $route, array $context = []){
        [$module, $controller] = explode('/', $route);

        $class = '\\Modules\\'.ucfirst($module).'\\Controller\\'.ucfirst($controller);

        if (!class_exists($class)) {
            echo "Controller not found: $class";
            exit;
        }

        $obj = new $class;

        if (!method_exists($obj, 'index')) {
            echo "Method index() not found in $class";
            exit;
        }

        $obj->index($context);
    }

}