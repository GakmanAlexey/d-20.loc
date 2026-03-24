<?php

namespace Modules\User\Modul\Manager;

class Auth
{
    public function getUserById($userID){    

        $reposetor = new \Modules\User\Modul\Repository\Auth();
        $result = $reposetor->getUserById($userID);
        \Modules\User\User::setUser($result["id"], $result["username"], true);
        
    }
   
}