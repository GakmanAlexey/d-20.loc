<?php

namespace Modules\User\Modul\Repository;

class Logsauth
{
    public function auth(
            $user_id,
            $status,
            $login,
            $success,
            $reason,
            $ip_address,
            $user_agent,
            $device,
            $browser,
            $os,
            $metadata
        ){
        $pdo = \Modules\Core\Modul\Sql::connect();
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'user_auth_log';
        $stmt = $pdo->prepare("
                INSERT INTO `{$tableName}` (
                    user_id, 
                    event, 
                    success, 
                    login, 
                    reason, 
                    ip_address, 
                    user_agent, 
                    device, 
                    browser, 
                    os, 
                    metadata
                ) VALUES (
                    :user_id, 
                    :status, 
                    :success, 
                    :login, 
                    :reason, 
                    :ip_address, 
                    :user_agent, 
                    :device, 
                    :browser, 
                    :os, 
                    :metadata
                )
            ");
            
            $stmt->execute([
                ':user_id' => $user_id,
                ':status' => $status,
                ':login' => $login,
                ':success' => $success,
                ':reason' => $reason,
                ':ip_address' => $ip_address,
                ':user_agent' => $user_agent,
                ':device' => $device,
                ':browser' => $browser,
                ':os' => $os,
                ':metadata' => $metadata
            ]);
    }
   
}