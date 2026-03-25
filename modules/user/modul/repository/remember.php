<?php

namespace Modules\User\Modul\Repository;

class Remember
{
   public function addNewToken($userID,$token,$ip,$userAgent,$expiresAt){
        $pdo = \Modules\Core\Modul\Sql::connect();
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'user_sessions';

        $stmt = $pdo->prepare("
            INSERT INTO `{$tableName}`
            (user_id, session_token, ip_address, user_agent, expires_at)
            VALUES
            (:user_id, :session_token, :ip_address, :user_agent, :expires_at)
        ");

        $stmt->bindValue(':user_id', $userID, \PDO::PARAM_INT);
        $stmt->bindValue(':session_token', $token, \PDO::PARAM_STR);
        $stmt->bindValue(':ip_address', $ip, \PDO::PARAM_STR);
        $stmt->bindValue(':user_agent', $userAgent, \PDO::PARAM_STR);
        $stmt->bindValue(':expires_at', $expiresAt, \PDO::PARAM_STR);

        return $stmt->execute();
   }
}