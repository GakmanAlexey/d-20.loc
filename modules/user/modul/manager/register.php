<?php

namespace Modules\User\Modul\Manager;

class Register
{
    private $lang;
    public function cons()
    {
        $language = \Modules\Core\Modul\Env::get('APP_LANGUAGE') ?: 'ru_RU';
        $langPath = APP_ROOT . DS . "modules" . DS . "user" . DS . "modul" . DS .  "support" . DS . "lang" . DS . $language . ".json";
        $this->lang = json_decode(file_get_contents($langPath), true) ?? [];
    }
    public function Start(){
        if (\Modules\User\User::getStatus()){
            return ["code" => "code_1"];
        }
        $massages = new \Modules\User\Modul\Support\Messenger;
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[\Modules\User\Modul\Support\Config::get("form.register.button")])){
            $form = new \Modules\User\Modul\Form\Register;
            $result = $this->staticRegister($form);
            return $result;
        }
        return ["code" => "code_0", "message" => $massages];
    }

    public function staticRegister($form){
         $massages = new \Modules\User\Modul\Support\Messenger;
         //Проверка CSRF токена
         $this->cons();
        if (!\Modules\User\Modul\Support\Csrf::validate($form->getCsrftoken())) {
            $massages->addError($this->lang["login"]['invalid_csrf_token']);
            return ["status" => false, "code" => "code_2", "message" => $massages];
        }
         //Проверка на валидность данных из формы
         $validator = new \Modules\User\Modul\Support\Validator;
         $resultValidator = $validator->validateRegister($massages, $form);
         if(!$resultValidator["status"]){
            return ["status" => false, "code" => "code_2", "message" => $massages];
         }

        $serviceRegister = new \Modules\User\Modul\Service\Register;
         //Здесь будет проверка на существование пользователя с таким юзернейм
        $statusFreeName = $serviceRegister->issetUserName($form->getUsername(), $massages);
        if(!$statusFreeName["status"]){
            return ["status" => false, "code" => "code_2", "message" => $massages];
        }
        //подготовка пользователя.
        $user = \Modules\User\Modul\Entity\User::createEmpty();
            $user->setUsername($form->getUsername())
                ->setPassword($form->getPassword())
                ->setEmail($form->getEmail());
        //Здесь будет регистрация пользователя
        $statusRegister = $serviceRegister->register($user, $massages);
        if(!$statusRegister["status"]){
            return ["status" => false, "code" => "code_2", "message" => $massages];
        }
        $user->setId($statusRegister["id"]);
        //Здесь будет создание токена подтверждения и отправка письма
        $mailer = new \Modules\User\Modul\Support\Mailer;
        $statusMail = $mailer->createConfirmToken($user);   
        return ["status" => true, "code" => "code_3", "message" => $massages];
   }

   
}