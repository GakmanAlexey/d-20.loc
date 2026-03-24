<?php

namespace Modules\User\Modul\Service;

class Auth
{    
    private array $lang;

    public function __construct()
    {
        $language = \Modules\Core\Modul\Env::get('APP_LANGUAGE') ?: 'ru_RU';
        $langPath = APP_ROOT . DS . "modules" . DS . "user" . DS . "modul" . DS .  "support" . DS . "lang" . DS . $language . ".json";
        $this->lang = json_decode(file_get_contents($langPath), true) ?? [];
    }

    public function getAuth(\Modules\User\Modul\Entity\User $user, \Modules\User\Modul\Support\Messenger $massages){
        //Добавить в лог процесс атовризации
        $logs = new \Modules\User\Modul\Support\Logs;
        $logs->addLog($user, "Попытка авторизации");
        //сам процесс автоизации
        $authRepository = new \Modules\User\Modul\Repository\Auth;
        $resultAuth = $authRepository->getAuth($user);
        if (!$resultAuth) {
            $logs->addLog($user, "Пользователь не найден");
            $massages->addError($this->lang["login"]['user_not_found']);
            return ["status" => false];
        }

        $passwordVerify = \Modules\User\Modul\Support\Hash::verify($user->getPassword(), $resultAuth['password_hash']);        
        if (!$passwordVerify) {
            $logs->addLog($user, "Неверный пароль");
            $massages->addError($this->lang["login"]['invalid_password']);
            return ["status" => false];
        }

        if (!$resultAuth['is_active']) {
            $logs->addLog($user, "Учетная запись не активирована");
            $massages->addError($this->lang["login"]['inactive_account']);
            return ["status" => false];
        }
        
        if ($resultAuth['is_banned']) {
            $banMsg = "Пользователь забанен";
            if ($resultAuth['ban_reason']) {
                $banMsg .= ". Причина: " . $resultAuth['ban_reason'];
            }
            if ($resultAuth['ban_expiry_date'] && strtotime($resultAuth['ban_expiry_date']) > time()) {
                $banMsg .= " до " . date('d.m.Y', strtotime($resultAuth['ban_expiry_date']));
            }
            $logs->addLog($user, "Пользователь забанен");
            $massages->addError($this->lang["login"]['user_banned'] . " " . $banMsg);
            return ["status" => false];
        }

        $user = $this->createUser($user, $resultAuth);

        //Запуск сессий
        \Modules\User\Modul\Support\Sessionauth::setSession($user->getId());        

        //Если авторизация прошла успешно, то добавить в лог успешную авторизацию
        $logs->addLog($user, "Попытка авторизации прошла успешно");
        
        return ["status" => true, "user" => $user];

    }

    public function createUser(\Modules\User\Modul\Entity\User $user,$resultAuth){
        $user->setId((int)$resultAuth['id'])
                    ->setUsername($resultAuth['username'])
                    ->setEmail($resultAuth['email'])
                    ->setPasswordHash($resultAuth['password_hash'])
                    ->setActive((bool)$resultAuth['is_active'])
                    ->setBanned((bool)$resultAuth['is_banned'])
                    ->setBanReason($resultAuth['ban_reason'])
                    ->setCreatedAt(new \DateTime($resultAuth['created_at']))
                    ->setUpdatedAt(new \DateTime($resultAuth['updated_at']));        
                if ($resultAuth['ban_expiry_date']) {
                    $user->setBanExpiryDate(new \DateTime($resultAuth['ban_expiry_date']));
                }
        return $user;
    }
    //////////////////
    public function jobToken(\Modules\User\Modul\Entity\User $user)
    {
        if (!empty($_POST['remember'])) {
            $remember = new \Modules\User\Modul\Support\Remember();
            $remember->createTokenForUser($user);
        }
    }
}