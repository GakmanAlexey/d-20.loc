<?php
namespace Modules\User\Modul\Support;

class Hash
{
     /**
     * Получение соли приложения
     */
    private static function salt(): string
    {
        return \Modules\Core\Modul\Env::get("APP_SALT") ?? '';
    }

    /**
     * Подготовка пароля с солью
     */
    private static function prepare(string $password): string
    {
        return $password . self::salt();
    }

    /**
     * Хеширование пароля
     */
    public static function make(string $password): string
    {
        return password_hash(
            self::prepare($password),
            PASSWORD_DEFAULT
        );
    }

    /**
     * Проверка пароля
     */
    public static function verify(string $password, string $hash): bool
    {
        return password_verify(
            self::prepare($password),
            $hash
        );
    }
}
