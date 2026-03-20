<?php

namespace Modules\User\Modul;

class Logs
{
    /**
     * Логирование успешной авторизации
     */
    public function logSuccessAuth(\Modules\User\Modul\Authuser $user)
    {
        try {
            $pdo = \Modules\Core\Modul\Sql::connect();
            $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'user_auth_log';
            
            $userAgent = \Modules\User\Modul\Userdata::getAgent();
            $userAgentInfo = $this->parseUserAgent($userAgent);
            $ipAddress = $this->getClientIp();
            
            $metadata = json_encode([
                'login_method' => 'standard',
                'auth_time' => date('Y-m-d H:i:s'),
                'session_id' => session_id(),
                'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
                'request_method' => $_SERVER['REQUEST_METHOD'] ?? null
            ]);
            
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
                    'login_success', 
                    1, 
                    :login, 
                    NULL, 
                    :ip_address, 
                    :user_agent, 
                    :device, 
                    :browser, 
                    :os, 
                    :metadata
                )
            ");
            
            $stmt->execute([
                ':user_id' => $user->getId(),
                ':login' => $user->getUsername(),
                ':ip_address' => $ipAddress,
                ':user_agent' => $userAgent,
                ':device' => $userAgentInfo['device'],
                ':browser' => $userAgentInfo['browser'],
                ':os' => $userAgentInfo['os'],
                ':metadata' => $metadata
            ]);
            
        } catch (\PDOException $e) {
            $logger = new \Modules\Core\Modul\Logs();
            $logger->loging('user', "Ошибка при записи успешной авторизации: " . $e->getMessage());
        }
    }

    /**
     * Логирование неудачной попытки авторизации
     */
    public function logFailedAttempt($login, $reason = null)
    {
        try {
            $pdo = \Modules\Core\Modul\Sql::connect();
            $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'user_auth_log';
            
            $userAgent = \Modules\User\Modul\Userdata::getAgent();
            $userAgentInfo = $this->parseUserAgent($userAgent);
            $ipAddress = $this->getClientIp();
            
            $metadata = json_encode([
                'failed_attempt_time' => date('Y-m-d H:i:s'),
                'login_attempt' => $login,
                'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
                'request_method' => $_SERVER['REQUEST_METHOD'] ?? null
            ]);
            
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
                ':login' => $login,
                ':reason' => $reason,
                ':ip_address' => $ipAddress,
                ':user_agent' => $userAgent,
                ':device' => $userAgentInfo['device'],
                ':browser' => $userAgentInfo['browser'],
                ':os' => $userAgentInfo['os'],
                ':metadata' => $metadata
            ]);
            
        } catch (\PDOException $e) {
            $logger = new \Modules\Core\Modul\Logs();
            $logger->loging('user', "Ошибка при записи неудачной попытки авторизации: " . $e->getMessage());
        }
    }

    /**
     * Получение реального IP клиента с учетом прокси
     */
    private function getClientIp()
    {
        $ipAddress = '0.0.0.0';
        
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ipAddress = trim($ips[0]);
        } elseif (isset($_SERVER['HTTP_X_REAL_IP'])) {
            $ipAddress = $_SERVER['HTTP_X_REAL_IP'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        }
        
        if (strpos($ipAddress, ':') !== false) {
            $ipAddress = explode(':', $ipAddress)[0];
        }
        
        return $ipAddress;
    }

    /**
     * Парсинг User-Agent для определения устройства, браузера и ОС
     */
    private function parseUserAgent($userAgent)
    {
        $userAgent = strtolower($userAgent);
        
        $device = 'desktop';
        $browser = 'unknown';
        $os = 'unknown';
        
        // Определение устройства
        if (preg_match('/(android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini)/i', $userAgent)) {
            $device = 'mobile';
        } elseif (preg_match('/(tablet|ipad|playbook)/i', $userAgent)) {
            $device = 'tablet';
        } elseif (preg_match('/(tv|smarthub|bravia)/i', $userAgent)) {
            $device = 'tv';
        }
        
        // Определение браузера
        if (strpos($userAgent, 'chrome') !== false) {
            $browser = 'chrome';
        } elseif (strpos($userAgent, 'firefox') !== false) {
            $browser = 'firefox';
        } elseif (strpos($userAgent, 'safari') !== false) {
            $browser = 'safari';
        } elseif (strpos($userAgent, 'edge') !== false) {
            $browser = 'edge';
        } elseif (strpos($userAgent, 'msie') !== false || strpos($userAgent, 'trident') !== false) {
            $browser = 'internet explorer';
        } elseif (strpos($userAgent, 'opera') !== false) {
            $browser = 'opera';
        }
        
        // Определение операционной системы
        if (strpos($userAgent, 'windows') !== false) {
            $os = 'windows';
        } elseif (strpos($userAgent, 'mac') !== false) {
            $os = 'mac';
        } elseif (strpos($userAgent, 'linux') !== false) {
            $os = 'linux';
        } elseif (strpos($userAgent, 'android') !== false) {
            $os = 'android';
        } elseif (strpos($userAgent, 'ios') !== false || strpos($userAgent, 'iphone') !== false || strpos($userAgent, 'ipad') !== false) {
            $os = 'ios';
        } elseif (strpos($userAgent, 'freebsd') !== false) {
            $os = 'freebsd';
        }
        
        return [
            'device' => $device,
            'browser' => $browser,
            'os' => $os
        ];
    }
}