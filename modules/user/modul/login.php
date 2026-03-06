<?php

namespace Modules\User\Modul;

class Login
{
    public function authUser(Formdata $form){
        $resultValid = $this->validator($form);
        if(!$resultValid["status"]) return $resultValid;
        //перобразование формы в модель пользователя
        $user = $this->formToUser($form);

        $resultAuth = $this->getAuth($user);
    }

    public function validator(Formdata $form)
    {
        if(isset($_SESSION["user_id"])){
            return ["status"=>false, "msg"=>["Вы уже авторизованы"]];
        }
        $valid = new \Modules\User\Modul\Validator;
        if($valid->validateLogin($form)){
            return ["status"=>true, "msg"=>""];
        }else{
            return ["status"=>false, "msg"=>$form->getMsg()];
        }
    }

    public function formToUser(Formdata $form){
        $user = new \Modules\User\Modul\Authuser;
        $user->setUsername($form->getLogin())
            ->setPassword($form->getPassword());
        return $user;
    }

    public function getAuth(\Modules\User\Modul\Authuser $user)
    {
        try {
            // Подключение к базе
            $pdo = \Modules\Core\Modul\Sql::connect();
            $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users';
            
            // Поиск пользователя по username или email
            $stmt = $pdo->prepare("
                SELECT * FROM `{$tableName}` 
                WHERE username = :username OR email = :username
            ");
            
            $username = $user->getUsername();
            $stmt->bindValue(':username', $username, \PDO::PARAM_STR);
            $stmt->execute();
            
            $userData = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            // Проверяем, найден ли пользователь
            if (!$userData) {
                return ["status" => false, "msg" => ["Пользователь не найден"]];
            }
            
            // Проверяем пароль с помощью класса Hash
            if (!\Modules\User\Modul\Hash::verify($user->getPassword(), $userData['password_hash'])) {
                return ["status" => false, "msg" => ["Неверный пароль"]];
            }
            
            // Проверяем, активен ли пользователь
            if (!$userData['is_active']) {
                return ["status" => false, "msg" => ["Учетная запись не активирована"]];
            }
            
            // Проверяем, забанен ли пользователь
            if ($userData['is_banned']) {
                $banMsg = "Пользователь забанен";
                if ($userData['ban_reason']) {
                    $banMsg .= ". Причина: " . $userData['ban_reason'];
                }
                if ($userData['ban_expiry_date'] && strtotime($userData['ban_expiry_date']) > time()) {
                    $banMsg .= " до " . date('d.m.Y', strtotime($userData['ban_expiry_date']));
                }
                return ["status" => false, "msg" => [$banMsg]];
            }
            
            // Заполняем объект Authuser данными из БД
            $user->setId((int)$userData['id'])
                ->setUsername($userData['username'])
                ->setEmail($userData['email'])
                ->setPasswordHash($userData['password_hash'])
                ->setActive((bool)$userData['is_active'])
                ->setBanned((bool)$userData['is_banned'])
                ->setBanReason($userData['ban_reason'])
                ->setCreatedAt(new \DateTime($userData['created_at']))
                ->setUpdatedAt(new \DateTime($userData['updated_at']));
            
            if ($userData['ban_expiry_date']) {
                $user->setBanExpiryDate(new \DateTime($userData['ban_expiry_date']));
            }
            
            // Получаем IP пользователя
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            
            // Выполняем вход (устанавливает session_id, authenticated и last_login данные в объекте)
            $user->login($ip);
            
            // Сохраняем ID пользователя в сессии
            $_SESSION['user_id'] = $user->getId();
            
            return ["status" => true, "msg" => ""];
            
        } catch (\PDOException $e) {
            // Логирование ошибки
            $logger = new \Modules\Core\Modul\Logs();
            $logger->loging('user', "Ошибка авторизации: " . $e->getMessage());
            
            return ["status" => false, "msg" => ["Ошибка сервера при авторизации"]];
        }
    }
}