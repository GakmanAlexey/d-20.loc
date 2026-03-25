<?php

namespace Modules\User\Modul\Service;

class Remember
{   public $tokenSupport;
    public function createCoockie($form){
        $this->tokenSupport = new \Modules\User\Modul\Support\Remembertoken;
        $token = $this->tokenSupport->generateToken();
        $hashToken = $this->tokenSupport->hashToken($token);

        $this->addToCoockie($hashToken);
        $this->addToBD($token,\Modules\User\User::getUserID());
    }

    public function addToCoockie($token){
        $this->tokenSupport->setRememberCookie($token);
    }

    public function addToBD($token,$userID){
        $supportIp = new \Modules\User\Modul\Support\Userip;
            $ip = $supportIp->takeIP();
        $supportUserAgent = new \Modules\User\Modul\Support\Agent;
            $userAgent = json_encode($supportUserAgent->takeAgent());  
        $expiresAt = date('Y-m-d H:i:s', time() + (86400 * $this->tokenSupport->dayAuth));

        $reposetoryRemember = new \Modules\User\Modul\Repository\Remember;
        $reposetoryRemember->addNewToken($userID,$token,$ip,$userAgent,$expiresAt); //44412322
    }
    
}