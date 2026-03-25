<?php

namespace Modules\User\Modul\Manager;

class Remember
{    
    public function isPressFlag(\Modules\User\Modul\Form\Auth $form){
        if(!isset($_POST[\Modules\User\Modul\Support\Config::get("form.auth.remember")])){return;}
        $service = new \Modules\User\Modul\Service\Remember;
        $service->createCoockie($form);
        
    }
    Public function auto(){

    }
    
}