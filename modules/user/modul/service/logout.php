<?php

namespace Modules\User\Modul\Service;

class Logout
{    
    public function createEntityLogout(\Modules\User\Modul\Form\Logout $form): \Modules\User\Modul\Entity\Logout
    {
        $entityLogout = new \Modules\User\Modul\Entity\Logout;
        $rememberToken = new \Modules\User\Modul\Support\Remembertoken;
        $hashToken = $rememberToken->hashToken($_COOKIE[\Modules\User\Modul\Support\Config::get("remember.nameCoockie")]);

        $logOutRepository = new \Modules\User\Modul\Repository\Logout;
        $entityLogout->setCookie(\Modules\User\Modul\Support\Config::get("remember.nameCoockie"))
            ->setSessionToken($_COOKIE[\Modules\User\Modul\Support\Config::get("remember.nameCoockie")])            
            ->setUserID(\Modules\User\User::getUserID())
            ->setSessionIdInBaseData(($logOutRepository->takeSoloSession($hashToken))["id"]);

        return $entityLogout;
    }

    
    public function killSoloSession(\Modules\User\Modul\Entity\Logout $entityLogout)
    {
        $session = new \Modules\User\Modul\Support\Sessionauth;
        $session->clearSession();
    }

    public function killCookie(\Modules\User\Modul\Entity\Logout $entityLogout)
    {
        if (isset($_COOKIE[$entityLogout->getCookie()])) {
            unset($_COOKIE[$entityLogout->getCookie()]);
        }

        setcookie(
            $entityLogout->getCookie(),
            '',
            time() - 3600,
            '/',
            '',
            isset($_SERVER['HTTPS']),
            true
        );
    }

    public function killBaseData(\Modules\User\Modul\Entity\Logout $entityLogout)
    {
        
        $logOutRepository = new \Modules\User\Modul\Repository\Logout;
        $logOutRepository->killSoloSession($entityLogout->getSessionIdInBaseData());
    }
}