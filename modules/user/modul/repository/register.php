<?php

namespace Modules\User\Modul\Repository;

class Register
{
   public function issetUserName($username){
        
        $pdo = \Modules\Core\Modul\Sql::connect();
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users';

        $query = "SELECT COUNT(*) as count FROM `{$tableName}` WHERE username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':username', $username, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public function register(\Modules\User\Modul\Entity\User $user){
        $pdo = \Modules\Core\Modul\Sql::connect();
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users';

        $query = "INSERT INTO `{$tableName}` (username, password_hash, email, is_active) VALUES (:username, :password_hash, :email, :is_active)";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':username', $user->getUsername(), \PDO::PARAM_STR);
        $stmt->bindValue(':password_hash', $user->getPasswordHash(), \PDO::PARAM_STR);
        $stmt->bindValue(':email', $user->getEmail(), \PDO::PARAM_STR);
        $stmt->bindValue(':is_active', 0, \PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $pdo->lastInsertId();
        }

        return false;
    }

    public function validateConfirmToken($token){
        $pdo = \Modules\Core\Modul\Sql::connect();
        $table = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users_mail_status';
            
            // Ищем неиспользованные токены с типом confirm_email
        $stmt = $pdo->prepare("
                SELECT * FROM {$table} 
                WHERE type = 'confirm_email' 
                AND used_at IS NULL 
                AND expires_at > NOW()
                ORDER BY created_at DESC 
                LIMIT 1000
        ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function activeUser($id_user){
        
        $repository = new \Modules\User\Modul\Repository\Register;
        $pdo = \Modules\Core\Modul\Sql::connect();
        $table = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users';

        $stmt = $pdo->prepare("
            UPDATE {$table}
            SET is_active = 1
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $id_user
        ]);
    }

    public function markTokenAsUsed($id_row){
        try {
            $pdo = \Modules\Core\Modul\Sql::connect();
            $table = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users_mail_status';
            
            $stmt = $pdo->prepare("
                UPDATE {$table} 
                SET used_at = NOW() 
                WHERE id = :id
            ");
            
            return $stmt->execute(['id' => $id_row]);
            
        } catch (\Exception $e) {
            return false;
        }
    }
}