<?php
namespace Modules\User\Modul;

class Recoveryservice
{
    public function start(){
        if(!isset($_POST["password"]) or !isset($_POST["password2"])){
            return ["status"=>false,"msg"=>"Пароли не совпадают"];
        }
        if($_POST["password"] !== $_POST["password2"]){
            return ["status"=>false,"msg"=>"Пароли не совпадают"];
        }
        if (!\Modules\Core\Modul\Csrftoken::validateToken($_POST["token"])) {
            return ["status"=>false,"msg"=>"Ошибка работы сервиса"];
        }
        if(!isset($_POST["tokenmail"])){
            return ["status"=>false,"msg"=>"Ошибка работы сервиса"];
        }

        return $this->seachUser();
    }    

    public function seachUser(){
        $pdo = \Modules\Core\Modul\Sql::connect();
        $table = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users_mail_status';

        $stmt = $pdo->prepare("SELECT * FROM {$table} WHERE token_hash = :token_hash AND type = 'swapPassword' AND expires_at > NOW()");
        $mailer = new \Modules\User\Modul\Mailer;
        $tokenHash = $mailer->hashToken($_POST["tokenmail"]);
        var_dump($tokenHash);
        $stmt->bindValue(':token_hash', $tokenHash, \PDO::PARAM_STR);
        $stmt->execute();
        $mailStatus = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$mailStatus) {
            return ["status"=>false,"msg"=>"Ошибка работы сервиса"];
        }
        //Обновляем статус токена
        $updateStmt = $pdo->prepare("UPDATE {$table} SET used_at = NOW() WHERE id = :id");
        $updateStmt->bindValue(':id', $mailStatus["id"], \PDO::PARAM_INT);
        $updateStmt->execute();
        return $this->updatePassword($mailStatus["id_user"]);
    }

    public function updatePassword($id_user){
        $pdo = \Modules\Core\Modul\Sql::connect();
        $table = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users';
        $passwordHash = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE {$table} SET password_hash = :password_hash WHERE id = :id_user");
        $stmt->bindValue(':password_hash', $passwordHash, \PDO::PARAM_STR);
        $stmt->bindValue(':id_user', $id_user, \PDO::PARAM_INT);
        $stmt->execute();

        return ["status"=>true,"msg"=>"Пароль успешно изменен"];
    }
}
