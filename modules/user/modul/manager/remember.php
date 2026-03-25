<?php

namespace Modules\User\Modul\Manager;

class Remember
{    
    public function isPressFlag(\Modules\User\Modul\Form\Auth $form){
        if(!isset($_POST[\Modules\User\Modul\Support\Config::get("form.auth.remember")])){return;}
        $service = new \Modules\User\Modul\Service\Remember;
        $service->createCoockie($form);
        
    }
    // $authToken = new \Modules\User\Modul\Manager\Remember;
    // $authToken->autoAuth();
    public function autoAuth(){
        if(\Modules\User\User::getUserID() >= 1) return NULL;
        $remSup = new \Modules\User\Modul\Support\Remembertoken;
        if (!isset($_COOKIE[$remSup->nameCookie])) return null;
    
        $service = new \Modules\User\Modul\Service\Remember;
        $service->authFromCoockie($remSup);
        
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    
}