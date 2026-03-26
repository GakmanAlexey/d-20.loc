<?php

namespace Modules\User\Modul\Manager;

class Logout
{
   public function Out(){
      if(!\Modules\User\User::isAuth()){
         return false;
      }
      $form = new \Modules\User\Modul\Form\Logout;      
      if (!\Modules\User\Modul\Support\Csrf::validate($form->getCsrftoken())) {
            return true;
      }      
      if($form->getSolo()){$this->singlOut($form);}
      if($form->getMulti()){$this->multiOut($form);}

      return true;
   }
   public function singlOut(\Modules\User\Modul\Form\Logout $form)
   {
      $serviceLogout = new \Modules\User\Modul\Service\Logout;
      $entityLogout = $serviceLogout->createEntityLogout($form);
      
      $serviceLogout->killSoloSession($entityLogout);
      $serviceLogout->killCookie($entityLogout);
      $serviceLogout->killBaseData($entityLogout);

      header('Location: ' . \Modules\User\Modul\Support\Config::get("page.outCompleate"));
      exit;
   }

   public function multiOut(\Modules\User\Modul\Form\Logout $form)
   {      
      //Удалить все сессии и БД logout/
   }

   
}