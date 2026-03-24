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
        $userAgentInfo = $this->userAgent;
        $reason = $message;
        if(isset($_SESSION["user_id"]) && $_SESSION["user_id"] >= 1) {$user_id = $_SESSION["user_id"];} else {$user_id = NULL;}
        
        $status = 'login_failed';
        $success = 0;
        $logsAuth = new \Modules\User\Modul\Repository\Logsauth;
        $logsAuth->auth(
                $user_id,
                $status,
                $user->getUsername(),
                $success,
                $reason,
                $this->userIP,
                json_encode($this->userAgent),
                $userAgentInfo['device'],
                $userAgentInfo['browser'],
                $userAgentInfo['os'],
                $this->metadata
            );        
    }

    public function addToTXT(\Modules\User\Modul\Entity\User $user, string $message){
         //Логирование в текстовый файл
        $logger = new \Modules\Core\Modul\Logs();
        $logger->loging('user', $message . " | User: " . $user->getUsername() . " | IP: " . $this->userIP . " | User Agent: " . json_encode($this->userAgent));
    }
}
