<?php
namespace Modules\User\Modul;

class Register
{
    public function registerUser(Formdata $form){
        //Валидация
        $resultValid = $this->validator($form);
        if(!$resultValid["status"]) return $resultValid;
        //создание пользователя
        $user = $this->createUser($form);
        //Сохранение в БД
        $this->saveToBD($user);
        //Логирование регистрации
        $this->addToLogs($user);
        $this->sandMail($user);
        return ["status" => true, "msg" => ""];
        
    }

    public function validator(Formdata $form)
    {
        $valid = new \Modules\User\Modul\Validator;

        if($valid->validateRegister($form)){
            return ["status"=>true, "msg"=>""];
        }else{
            return ["status"=>false, "msg"=>$form->getMsg()];
        }
    }
    public function createUser(Formdata $form)
    {
        $userModel = \Modules\User\Modul\User::createEmpty();
        $userModel->setUsername($form->getLogin())
            ->setEmail($form->getEmail())
            ->setPassword($form->getPassword())
            ->setPasswordHash(\Modules\User\Modul\Hash::make($form->getPassword()))
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
            ->setActive(false); 

        return $userModel;

    }

    public function saveToBD(\Modules\User\Modul\User $user): void
    {
        try {
            // Подключение к базе
            $pdo = \Modules\Core\Modul\Sql::connect();
            $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users';

            // Подготовка запроса INSERT
            $stmt = $pdo->prepare("
                INSERT INTO `{$tableName}` 
                    (username, email, password_hash, is_active, is_banned, ban_reason, ban_expiry_date, created_at, updated_at)
                VALUES 
                    (:username, :email, :password_hash, :is_active, :is_banned, :ban_reason, :ban_expiry_date, :created_at, :updated_at)
            ");

            // Преобразуем даты в формат для MySQL
            $createdAt = $user->getCreatedAt() ? $user->getCreatedAt()->format('Y-m-d H:i:s') : null;
            $updatedAt = $user->getUpdatedAt() ? $user->getUpdatedAt()->format('Y-m-d H:i:s') : null;
            $banExpiry = $user->getBanExpiryDate() ? $user->getBanExpiryDate()->format('Y-m-d H:i:s') : null;

            // Привязка параметров
            $stmt->bindValue(':username', $user->getUsername(), \PDO::PARAM_STR);
            $stmt->bindValue(':email', $user->getEmail(), \PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $user->getPasswordHash(), \PDO::PARAM_STR);
            $stmt->bindValue(':is_active', $user->isActive(), \PDO::PARAM_BOOL);
            $stmt->bindValue(':is_banned', $user->isBanned(), \PDO::PARAM_BOOL);
            $stmt->bindValue(':ban_reason', $user->getBanReason(), \PDO::PARAM_STR);
            $stmt->bindValue(':ban_expiry_date', $banExpiry, \PDO::PARAM_STR);
            $stmt->bindValue(':created_at', $createdAt, \PDO::PARAM_STR);
            $stmt->bindValue(':updated_at', $updatedAt, \PDO::PARAM_STR);

            // Выполнение запроса
            $stmt->execute();

            // Опционально: сохранить сгенерированный ID в объекте
            $user->setId((int)$pdo->lastInsertId());

        } catch (\PDOException $e) {
            // Логирование ошибки
            $logger = new \Modules\Core\Modul\Logs();
            $logger->loging('user', "Ошибка сохранения пользователя в БД: " . $e->getMessage());
            throw $e; // можно пробросить дальше или обработать
        }
    }

    public function addToLogs(\Modules\User\Modul\User $user): void
    {
        $message = sprintf(
            "Регистрация нового пользователя: username='%s', email='%s', active=%s, created_at=%s",
            $user->getUsername(),
            $user->getEmail(),
            $user->isActive() ? 'true' : 'false',
            $user->getCreatedAt() ? $user->getCreatedAt()->format('Y-m-d H:i:s') : 'null'
        );

        try {
            $logger = new \Modules\Core\Modul\Logs();
            $logger->loging('user', $message); // 'user' — модуль
        } catch (\Exception $e) {
            error_log('user Logger Fallback: ' . $message);
        }
    }

    public function sandMail(\Modules\User\Modul\User $user): void
    {
        try {

            $mailer = new \Modules\User\Modul\Mailer();
            $result = $mailer->createConfirmToken($user);

            if(!$result["success"]) {

                $logger = new \Modules\Core\Modul\Logs();
                $logger->loging(
                    'user',
                    "Ошибка отправки письма подтверждения пользователю ID={$user->getId()}: ".$result["message"]
                );

            }

        } catch (\Exception $e) {

            $logger = new \Modules\Core\Modul\Logs();
            $logger->loging(
                'user',
                "Исключение при отправке письма пользователю ID={$user->getId()}: ".$e->getMessage()
            );

        }
    }
}
