<?php

namespace Modules\User\Modul\Entity;

class Logout
{
    private $cookie;
    private $userID;
    private $sessionIdInBaseData;
    private $sessionToken;

    //Сетеры
    public function setCookie($cookie): self
    {
        $this->cookie = $cookie;
        return $this;
    }
    public function setUserID($userID): self
    {
        $this->userID = $userID;
        return $this;
    }
    public function setSessionIdInBaseData($sessionIdInBaseData): self
    {
        $this->sessionIdInBaseData = $sessionIdInBaseData;
        return $this;
    }
    public function setSessionToken($sessionToken): self
    {
        $this->sessionToken = $sessionToken;
        return $this;
    }
        
    //Гетеры
    public function getCookie()
    {
        return $this->cookie;
    }
    public function getUserID()
    {
        return $this->userID;
    }
    public function getSessionIdInBaseData()
    {
        return $this->sessionIdInBaseData;
    }
    public function getSessionToken()
    {
        return $this->sessionToken;
    }
}