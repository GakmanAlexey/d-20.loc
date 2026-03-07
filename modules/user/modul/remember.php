<?php

namespace Modules\User\Modul;

class Remember
{
    public $nameCookie = "tabaxiPlayer";
    public $dayAuth = 30;
    public function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    public function hashToken(string $token): string
    {
        return hash('sha256', $token);
    }

    public function verifyToken(string $token, string $hash): bool
    {
        return hash_equals($hash, hash('sha256', $token));
    }

    public function createTokenForUser(\Modules\User\Modul\Authuser $user){
        $token = $this->generateToken();
        $hashedToken = $this->hashToken($token);
        $this->setRememberCookie($token);
        $this->setRememberToken($hashedToken, $user);
        return true;
    }

    public function setRememberCookie(string $token): void
    {
        setcookie(
            $this->nameCookie, 
            $token, // незашифрованный токен, который будет использовать клиент
            time() + (86400 * $this->dayAuth),
            '/',
            '', // домен по необходимости
            isset($_SERVER['HTTPS']), // secure
            true // httponly
        );
    }

    public function setRememberToken(string $hashedToken, \Modules\User\Modul\Authuser $user): bool
    {
        $user_id = $user->getId();

        $pdo = \Modules\Core\Modul\Sql::connect();
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'user_sessions';
        $stmt = $pdo->prepare("
            INSERT INTO `{$tableName}`
            (user_id, session_token, ip_address, user_agent, expires_at)
            VALUES
            (:user_id, :session_token, :ip_address, :user_agent, :expires_at)
        ");

        $ip = \Modules\User\Modul\Userdata::getIp();
        $userAgent = \Modules\User\Modul\Userdata::getAgent();

        $expiresAt = date('Y-m-d H:i:s', time() + (86400 * $this->dayAuth)); 

        $stmt->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        $stmt->bindValue(':session_token', $hashedToken, \PDO::PARAM_STR);
        $stmt->bindValue(':ip_address', $ip, \PDO::PARAM_STR);
        $stmt->bindValue(':user_agent', $userAgent, \PDO::PARAM_STR);
        $stmt->bindValue(':expires_at', $expiresAt, \PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function authForCookie()
    {
        if (!isset($_COOKIE[$this->nameCookie])) return null;

        $token = $_COOKIE[$this->nameCookie];
        $hashedToken = $this->hashToken($token);
        $userAgent = \Modules\User\Modul\Userdata::getAgent();

        $pdo = \Modules\Core\Modul\Sql::connect();
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'user_sessions';

        $stmt = $pdo->prepare("
            SELECT user_id, expires_at, user_agent
            FROM `{$tableName}` 
            WHERE session_token = :session_token
            LIMIT 1
        ");
        $stmt->bindValue(':session_token', $hashedToken, \PDO::PARAM_STR);
        $stmt->execute();

        $session = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$session) return null;

        // Проверка срока действия
        if ($session['expires_at'] && strtotime($session['expires_at']) < time()) return null;

        // Проверка user_agent
        if ($session['user_agent'] !== $userAgent) return null;

        // Восстанавливаем сессию
        $_SESSION['user_id'] = $session['user_id'];

        // Обновляем токен и куки
        $this->updateToken($hashedToken);

        // Возвращаем объект пользователя
        return $session['user_id'];
    }

    public function updateToken(string $hashedToken): void
    {
        $pdo = \Modules\Core\Modul\Sql::connect();
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'user_sessions';

        // Новый токен и хеш
        $token = $this->generateToken();
        $newHashedToken = $this->hashToken($token);
        $expiresAt = date('Y-m-d H:i:s', time() + (86400 * $this->dayAuth));

        // Обновляем запись в базе
        $stmt = $pdo->prepare("
            UPDATE `{$tableName}`
            SET expires_at = :expires_at, session_token = :session_token
            WHERE session_token = :old_token
        ");
        $stmt->bindValue(':expires_at', $expiresAt, \PDO::PARAM_STR);
        $stmt->bindValue(':session_token', $newHashedToken, \PDO::PARAM_STR);
        $stmt->bindValue(':old_token', $hashedToken, \PDO::PARAM_STR);
        $stmt->execute();

        // Сохраняем новый токен в куки
        $this->setRememberCookie($token);
    }


    
}