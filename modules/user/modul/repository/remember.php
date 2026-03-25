<?php

namespace Modules\User\Modul\Repository;

class Remember
{
   public function addNewToken($userID,$hashToken,$ip,$userAgent,$expiresAt){
        $pdo = \Modules\Core\Modul\Sql::connect();
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'user_sessions';

        $stmt = $pdo->prepare("
            INSERT INTO `{$tableName}`
            (user_id, session_token, ip_address, user_agent, expires_at)
            VALUES
            (:user_id, :session_token, :ip_address, :user_agent, :expires_at)
        ");

        $stmt->bindValue(':user_id', $userID, \PDO::PARAM_INT);
        $stmt->bindValue(':session_token', $hashToken, \PDO::PARAM_STR);
        $stmt->bindValue(':ip_address', $ip, \PDO::PARAM_STR);
        $stmt->bindValue(':user_agent', $userAgent, \PDO::PARAM_STR);
        $stmt->bindValue(':expires_at', $expiresAt, \PDO::PARAM_STR);

        return $stmt->execute();
   }

   public function takeToken($hashToken){
        $pdo = \Modules\Core\Modul\Sql::connect();
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'user_sessions';

        $stmt = $pdo->prepare("
            SELECT user_id, expires_at, user_agent
            FROM `{$tableName}` 
            WHERE session_token = :session_token
            LIMIT 1
        ");
        $stmt->bindValue(':session_token', $hashToken, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
   }

   public function update($hashedTokenOld,$hashToken,$expiresAt){
        $pdo = \Modules\Core\Modul\Sql::connect();
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'user_sessions';

        // Обновляем запись в базе
        $stmt = $pdo->prepare("
            UPDATE `{$tableName}`
            SET expires_at = :expires_at, session_token = :session_token
            WHERE session_token = :old_token
        ");
        $stmt->bindValue(':expires_at', $expiresAt, \PDO::PARAM_STR);
        $stmt->bindValue(':session_token', $hashToken, \PDO::PARAM_STR);
        $stmt->bindValue(':old_token', $hashedTokenOld, \PDO::PARAM_STR);
        $stmt->execute();
   }
}