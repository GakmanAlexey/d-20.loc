<?php

namespace Modules\User\Modul\Repository;

class Auth
{
    public function getAuth(\Modules\User\Modul\Entity\User $user){

        $pdo = \Modules\Core\Modul\Sql::connect();        
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users';
        
        $stmt = $pdo->prepare("
            SELECT * FROM `{$tableName}` WHERE username = :username ");
        
        $username = $user->getUsername();
        $stmt->bindValue(':username', $username, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

    public function getUserById($userID){
        $pdo = \Modules\Core\Modul\Sql::connect();        
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users';
        
        $stmt = $pdo->prepare("
            SELECT * FROM `{$tableName}` WHERE id = :id ");
        
        $stmt->bindValue(':id', $userID, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}