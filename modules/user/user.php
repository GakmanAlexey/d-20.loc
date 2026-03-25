<?php

namespace Modules\User;

class User
{
    /*
    Статический класс авторизованых пользователей.
    */
    private static $username;
    private static $userID;
    private static $status;
    
    private static $flag;

    public function __construct()
    {
        self::$status = false;
        self::$flag = false;
    }

    public static function setUser($userID, $username, $status){
        self::$userID = $userID; 
        self::$username = $username;
        self::$status = $status;
        self::$flag = true;
    }
    public static function setFlag($flag){
        self::$flag = $flag;
    }
    public static function setID($userID){
        self::$userID = $userID;
    }
    public static function setName($username){
        self::$username = $username;
    }
    public static function setStatus($status){
        self::$status = $status;
    }

    public static function getUserID(){
        if(!self::$flag){self::sessionAuth();}
        return self::$userID;
    }
    public static function getUsername(){
        if(!self::$flag){self::sessionAuth();}
        return self::$username;
    }
    public static function getStatus(){
        if(!self::$flag){self::sessionAuth();}  
        return self::$status;
    }
    public static function getFlag(){
        return self::$flag;
    }

    public static function clearUser(){ 
        self::$userID = null;
        self::$username = null;
        self::$status = false;
        self::$flag = false;
    }

    public static function sessionAuth(){  
        if(\Modules\User\Modul\Support\Sessionauth::isAuthorized()){            
           $auth = new \Modules\User\Modul\Manager\Auth();
           $user = $auth->getUserById(\Modules\User\Modul\Support\Sessionauth::getSession());
           if($user){
               self::setUser($user->getID(), $user->getUsername(), true);
           }
        }
    }
}