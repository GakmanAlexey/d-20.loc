<?php
namespace Modules\User\Modul\Support;

class Logs
{
    private $userIP;
    private $userAgent;
    private $metadata;

    public function addLog(\Modules\User\Modul\Entity\User $user, string $message){
        //Логирование процесса авторизации, регистрации, восстановления пароля и т.д.
        $this->userDataInit();
        $this->metaDataInit($user->getUsername());
        $this->addToSQL($user, $message);
        $this->addToTXT($user, $message);
        return;
    }

    public function metaDataInit($username){
        $this->metadata = json_encode([
                'failed_attempt_time' => date('Y-m-d H:i:s'),
                'login_attempt' => $username,
                'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
                'request_method' => $_SERVER['REQUEST_METHOD'] ?? null
            ]);
    }

    public function userDataInit(){
        $userIP = new \Modules\User\Modul\Support\Userip; 
        $this->userIP = $userIP->takeIP();    

        $userAgent = new \Modules\User\Modul\Support\Agent;
        $this->userAgent = $userAgent->takeAgent();        
    }

    public function addToSQL(\Modules\User\Modul\Entity\User $user, string $message){
        //Логирование в базу данных
        $pdo = \Modules\Core\Modul\Sql::connect();
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'user_auth_log';
        $userAgentInfo = $this->userAgent;
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
                    NULL, 
                    'login_failed', 
                    0, 
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
                ':login' => $user->getUsername(),
                ':reason' => $reason,
                ':ip_address' => $this->userIP,
                ':user_agent' => $this->userAgent,
                ':device' => $userAgentInfo['device'],
                ':browser' => $userAgentInfo['browser'],
                ':os' => $userAgentInfo['os'],
                ':metadata' => $metadata
            ]);
    }

    public function addToTXT(\Modules\User\Modul\Entity\User $user, string $message){
         //Логирование в текстовый файл
        $logger = new \Modules\Core\Modul\Logs();
        $logger->loging('user', $message . " | User: " . $user->getUsername() . " | IP: " . $this->userIP . " | User Agent: " . $this->userAgent);
    }
}
