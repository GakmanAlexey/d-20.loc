<?php

namespace Modules\User\Modul\Repository;

class Mailer
{
    public function saveConfirmToken($userId, $hash){
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
                'id_user' => $userId,
                'token_hash' => $hash,      // было token, стало token_hash
                'type' => 'confirm_email',
                'expires_at' => $expires
            ]);
        
        
    }
}