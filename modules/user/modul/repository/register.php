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
}