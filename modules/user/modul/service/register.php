<?php

namespace Modules\User\Modul\Service;

class Register
{    
    private array $lang;

    public function __construct()
    {
        $language = \Modules\Core\Modul\Env::get('APP_LANGUAGE') ?: 'ru_RU';
        $langPath = APP_ROOT . DS . "modules" . DS . "user" . DS . "modul" . DS .  "support" . DS . "lang" . DS . $language . ".json";
        $this->lang = json_decode(file_get_contents($langPath), true) ?? [];
    }

    public function register(\Modules\User\Modul\Entity\User $user, \Modules\User\Modul\Support\Messenger  $massages){
        //создать хеш пароля
        $user->setPasswordHash(\Modules\User\Modul\Support\Hash::make($user->getPassword()));
        $repository = new \Modules\User\Modul\Repository\Register;
        $resultinsert = $repository->register($user);
        if ($resultinsert) {
            return ["status" => true, "id" => $resultinsert];
        }
        $massages->addError($this->lang["register"]['registration_error']);
        return ["status" => false, "message" => $massages]; 
    }

    public function issetUserName($username, \Modules\User\Modul\Support\Messenger $massages){
        $repository = new \Modules\User\Modul\Repository\Register;
        if ($repository->issetUserName($username)) {
            $massages->addError($this->lang["register"]['username_exists']);
            return ["status" => false, "message" => $massages];
        }
        return ["status" => true, "message" => $massages];
    }

    public function confirmEmail($token, \Modules\User\Modul\Support\Messenger $massages){
        $repository = new \Modules\User\Modul\Repository\Register;
        $tokens = $repository->validateConfirmToken($token);
        $mailer = new \Modules\User\Modul\Support\Mailer;
            foreach ($tokens as $row) {
                if ($mailer->verifyToken($token, $row['token_hash'])) {
                    $repository->activeUser($row["id_user"]);
                    $repository->markTokenAsUsed($row['id']);
                    return ["status" => true, "message" => $massages];
                }
            }  
        $massages->addError($this->lang["register"]['token_dont_isset']);
        return ["status" => false, "message" => $massages];
    }


   
}