<?php
namespace Modules\User\Modul\Support;

class Sessionauth
{    
    private static $name = "user_id";

    public static function setSession($userID){
        $_SESSION[self::$name] = $userID;
    }

    public static function getSession(){
        return $_SESSION[self::$name] ?? null;
    }
    public static function clearSession(){
        unset($_SESSION[self::$name]);
    }
    
    public static function isAuthorized(): bool
    {
        return self::getSession() !== null;
    }
}