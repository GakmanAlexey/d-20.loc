<?php
namespace Modules\User\Modul\Support;

class Remembertoken
{
    public $nameCookie;
    public $dayAuth;
    
    public function __construct()
    {
        $this->nameCookie = \Modules\User\Modul\Support\Config::get("remember.nameCoockie");
        $this->dayAuth = \Modules\User\Modul\Support\Config::get("remember.dayAvible");
    }

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
}