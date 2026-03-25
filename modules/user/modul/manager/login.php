<?php

namespace Modules\User\Modul\Manager;

class login
{
   private $lang;
   public function cons()
   {
      $language = \Modules\Core\Modul\Env::get('APP_LANGUAGE') ?: 'ru_RU';
      $langPath = APP_ROOT . DS . "modules" . DS . "user" . DS . "modul" . DS .  "support" . DS . "lang" . DS . $language . ".json";
      $this->lang = json_decode(file_get_contents($langPath), true) ?? [];
   }

   public function start(){      
      if (\Modules\User\User::getStatus()){
         return ["code" => "code_1"];
      }
      
      $massages = new \Modules\User\Modul\Support\Messenger;
      if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[\Modules\User\Modul\Support\Config::get("form.auth.button")])){
         $form = new \Modules\User\Modul\Form\Auth;
         $result = $this->staticAuth($form);
         if ($result["status"]) {
             return ["code" => "code_2", "status" => true, "message" => $result["message"] ?? ''];
         }      
         return ["code" => "code_2", "status" => false, "message" => $result["message"]];
      }
      
      return ["code" => "code_0", "message" => $massages];
   }

   public function staticAuth($form){
         $massages = new \Modules\User\Modul\Support\Messenger;
         //Проверка CSRF токена
         $this->cons();
         if (!\Modules\User\Modul\Support\Csrf::validate($form->getCsrftoken())) {
            $massages->addError($this->lang["login"]['invalid_csrf_token']);
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
         $resultAuth = $auth->getAuth($user, $massages);
         if($resultAuth["status"]){
            $this->successfulAuth($resultAuth["user"]);
            return ["status" => true, "code" => "code_2"];
         }

         return ["status" => false, "code" => "code_2", "message" => $massages];
   }
   //функция успещной аторизации, которая устанавливает сессию и куки
   public function successfulAuth($user){
      \Modules\User\User::setUser($user->getID(), $user->getUsername(), true);
      \Modules\User\Modul\Support\Sessionauth::setSession($user->getID());
   }
}