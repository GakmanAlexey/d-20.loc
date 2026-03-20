<?php

namespace Modules\User\Modul\Manager;

class login
{
   public function start(){
      echo "тут будет логика проверки авторизации, если пользователь уже авторизован, то редирект в личный кабинет";
      if (false){//тут будет логика проверки авторизации, если пользователь уже авторизован, то редирект в личный кабинет
         return ["code" => "code_1"];
      }
      if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['auth_button'])){
         $form = new Modules\User\Modul\Form\Auth;
         $result = $this->staticAuth($form);
         if ($result["status"]) {
             return $result;
         }         
      }
      
      return ["code" => "code_0"];
   }

   public function staticAuth($form){
         $massages = new \Modules\User\Modul\Support\Massager;
         //Проверка CSRF токена
         if (!Modules\User\Modul\Support\Csrf::validate($form->getCsrftoken())) {
            $massages->addError($this->lang["common"]['invalid_csrf_token']);
            return ["status" => false, "code" => "code_2", "message" => $massages];
         }
         //Проверка на валидность данных из формы
         $validator = new \Modules\User\Modul\Support\Validator;
         $resultValidator = $validator->validateAuth($massages, $form);
         if(!$resultValidator["status"]){
            return ["status" => false, "code" => "code_2", "message" => $massages];
         }
         //Здесь будет логика проверки данных из формы, если данные не совпали, то ошибка авторизации
         $user =\Modules\User\Modul\Entity\User::createEmpty();
         $user->setUsername($form->getUsername())
            ->setPassword($form->getPassword());

         $auth = new \Modules\User\Modul\Service\Auth;
         $resultAuth = $auth->auth($user, $massages);
         if($resultAuth["status"]){
            return ["status" => true, "code" => "code_2"];
         }

         return ["status" => false, "code" => "code_2", "message" => $massages];
   }
}