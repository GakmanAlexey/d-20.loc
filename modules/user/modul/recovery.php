<?php
namespace Modules\User\Modul;

class Recovery
{
    public function start(){
        //Проверка от атаки        
        if (!\Modules\Core\Modul\Csrftoken::validateToken($_POST["token"])) {
            die();
            return false;
        }
        //Проверка наличия логина
        
        $user = new \Modules\User\Modul\User;
        $user->createEmpty();
        $user->setUsername($_POST["login"]);
        $gUser = $this->gateUset($user);
        //Отправка письма
        if(!$gUser["status"]){
            return $gUser;
        }
        $this->sendMailcreateTokem($gUser);
        return $gUser;
    }

    public function gateUset(\Modules\User\Modul\User $user){

        $pdo = \Modules\Core\Modul\Sql::connect();        
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users';
        
        $stmt = $pdo->prepare("
            SELECT * FROM `{$tableName}` WHERE username = :username ");
        
        $username = $user->getUsername();
        $stmt->bindValue(':username', $username, \PDO::PARAM_STR);
        $stmt->execute();
        
        $userData = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$userData) {            
            return ["status" => false, "msg" => ["Пользователь не найден"]];
        }
        return ["status" => true, "msg" => ["Проверьте свою почту, письмо для востановление выслано"], "user" => $userData];

    }

    public function sendMailcreateTokem($gUser){
        $mailer = new \Modules\User\Modul\Mailer;
            $token = $mailer->createToken();
            $hash = $mailer->hashToken($token);

            $pdo = \Modules\Core\Modul\Sql::connect();
            $table = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users_mail_status';
            $expires = (new \DateTime('+24 hours'))->format('Y-m-d H:i:s');
            
            $stmt = $pdo->prepare("
                INSERT INTO {$table} 
                (id_user, token_hash, type, expires_at, created_at) 
                VALUES 
                (:id_user, :token_hash, :type, :expires_at, NOW())
            ");
            $stmt->execute([
                'id_user' => $gUser["user"]["id"],
                'token_hash' => $hash,      
                'type' => 'swapPassword',
                'expires_at' => $expires
            ]);

            return $this->sendConfirmEmail($gUser["user"]["email"], $token);

    }

    public function sendConfirmEmail($email,$token){
        $link = \Modules\Core\Modul\Env::get("APP_URL")."/user/recovery/step2/?token=" . urlencode($token);
        $subject = "Востановление доступа к аккаунту";
        $body = "
            <h2>Востановление доступа к аккаунту</h2>
            <p>Чтобы востановить аккаунт, перейдите по ссылке:</p>
            <p><a href='{$link}'>Востановить</a></p>
            <br>
            <p>Если вы не запускали востановление — просто проигнорируйте это письмо.</p>
        ";
        
        return \Modules\Mail\Modul\Mail::send($email, $subject, $body);

    }

    
}
