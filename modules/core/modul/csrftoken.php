<?php
namespace Modules\Core\Modul;

class Csrftoken
{
    private const SESSION_KEY = 'csrf_token';
    private const SESSION_TIME_KEY = 'csrf_token_time';
    private const TOKEN_LIFETIME = 86400; // 24 часа

    public static function getToken(): string
    {
        $now = time();

        if (
            empty($_SESSION[self::SESSION_KEY]) ||
            empty($_SESSION[self::SESSION_TIME_KEY]) ||
            ($_SESSION[self::SESSION_TIME_KEY] + self::TOKEN_LIFETIME) < $now
        ) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
            $_SESSION[self::SESSION_TIME_KEY] = $now;
        }

        return $_SESSION[self::SESSION_KEY];
    }

    public static function validateToken(?string $token): bool
    {
        return isset($_SESSION[self::SESSION_KEY]) && $token === $_SESSION[self::SESSION_KEY];
    }

    public static function resetToken(): void
    {
        unset($_SESSION[self::SESSION_KEY], $_SESSION[self::SESSION_TIME_KEY]);
    }
}