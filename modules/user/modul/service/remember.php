<?php

namespace Modules\User\Modul\Service;

class Remember
{   public $tokenSupport;
    public function createCoockie($form){
        $this->tokenSupport = new \Modules\User\Modul\Support\Remembertoken;
        $token = $this->tokenSupport->generateToken();
        $hashToken = $this->tokenSupport->hashToken($token);

        $this->addToCoockie($token);
        $this->addToBD($hashToken,\Modules\User\User::getUserID());
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
    public function authFromCoockie(\Modules\User\Modul\Support\Remembertoken $remSup){
        $this->tokenSupport = new \Modules\User\Modul\Support\Remembertoken; 
        $hashToken = $this->tokenSupport->hashToken($_COOKIE[$remSup->nameCookie]) ;   
        $supportUserAgent = new \Modules\User\Modul\Support\Agent;
            $userAgent = json_encode($supportUserAgent->takeAgent());  

        $repos = new \Modules\User\Modul\Repository\Remember;
        $dataBD = $repos->takeToken($hashToken);
        if (!$dataBD) return null;
        if ($dataBD['expires_at'] && strtotime($dataBD['expires_at']) < time()) return null;
        if ($dataBD['user_agent'] !== $userAgent) return null; 
        $authRep =  new \Modules\User\Modul\Repository\Auth;
        $serData = $authRep->getUserById($dataBD['user_id']);
        if(!$serData) return null;
        \Modules\User\User::setUser($serData["id"], $serData["username"], true);
        
        $this->updateToken($hashToken); 
        return;
    }

    public function updateToken($hashedTokenOld){
        $this->tokenSupport = new \Modules\User\Modul\Support\Remembertoken;
        $token = $this->tokenSupport->generateToken();
        $hashToken = $this->tokenSupport->hashToken($token);
        $expiresAt = date('Y-m-d H:i:s', time() + (86400 * $this->tokenSupport->dayAuth));

        $repos = new \Modules\User\Modul\Repository\Remember;
        $repos->update($hashedTokenOld,$hashToken,$expiresAt);
        
        $this->tokenSupport->setRememberCookie($token);

    }
    
}