<?php

namespace Modules\Router\Modul;

class Errorhandler{    

    public static function e500($context = []){

        if (!is_array($context)) {
            $context = [
                'error_message' => (string) $context
            ];
        }

        http_response_code(500);
        header('Content-Type: text/html; charset=utf-8');

        Router::dispatch('core/e500', $context);
        exit;
    }

    public static function e404(){
        http_response_code(404);
        header('Content-Type: text/html; charset=utf-8');

        Router::dispatch('core/e404');
        exit;
    }

    public static function e401(){
        http_response_code(401);
        header('Content-Type: text/html; charset=utf-8');

        Router::dispatch('core/e401');
        exit;
    }
}
