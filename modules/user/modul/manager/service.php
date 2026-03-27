<?php

namespace Modules\User\Modul\Manager;

class Service
{
    public function changePassword(){    
        if (\Modules\User\User::getStatus()){//после тестов инвертировать
            return ["code" => "code_0"];
        }

        $massages = new \Modules\User\Modul\Support\Messenger;
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[\Modules\User\Modul\Support\Config::get("form.change.button")])){
           
            return ["code" => "code_2", "status" => true, "message" => $massages];
        }
      
        return ["code" => "code_1", "message" => $massages];
    }
   
}