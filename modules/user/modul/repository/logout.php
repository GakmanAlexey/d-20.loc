<?php

namespace Modules\User\Modul\Repository;

class Logout
{
    public function takeSoloSession($hashToken)
    {        
        $pdo = \Modules\Core\Modul\Sql::connect();        
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'user_sessions';

        $stmt = $pdo->prepare("
            SELECT * FROM `{$tableName}` WHERE session_token  = :token ");
        
        $stmt->bindValue(':token', $hashToken, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function killSoloSession($sessionId)
    {
        $pdo = \Modules\Core\Modul\Sql::connect();        
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'user_sessions';

        $stmt = $pdo->prepare("
            DELETE FROM `{$tableName}` WHERE id  = :id ");
        
        $stmt->bindValue(':id', $sessionId, \PDO::PARAM_INT);
        $stmt->execute();
    }
   
}