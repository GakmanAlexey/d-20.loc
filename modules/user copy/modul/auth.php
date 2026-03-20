<?php

namespace Modules\User\Modul;

class Auth
{
    private static ?int $id = null;
    private static ?string $username = null;
    private static ?string $email = null;
    private static ?string $role = null;
    private static ?string $avatar = null;

    private static bool $isAuth = false;
    private static bool $remember = false;

    private static ?string $ip = null;
    private static ?string $userAgent = null;

    public static function init(): void
    {
        self::$ip = \Modules\User\Modul\Userdata::getIp();
        self::$userAgent = \Modules\User\Modul\Userdata::getAgent();

        if (isset($_SESSION['user_id'])) {
            self::loadUserById($_SESSION['user_id']);
        } elseif (isset($_COOKIE['remember_token'])) {
            self::loginFromCookie($_COOKIE['remember_token']);
        }
    }

    // -------------------------------------------------
    // Загрузка данных пользователя по ID
    // -------------------------------------------------
    private static function loadUserById(int $userId): void
    {
        $user = User::find($userId); // метод твоей модели User

        if ($user) {
            self::$id = $user->id;
            self::$username = $user->username;
            self::$email = $user->email;
            self::$role = $user->role ?? null;
            self::$avatar = $user->avatar ?? null;

            self::$isAuth = true;
        }
    }

    // -------------------------------------------------
    // Логин по токену cookie (remember me)
    // -------------------------------------------------
    private static function loginFromCookie(string $token): void
    {
        $row = User::getByRememberToken($token); // твой метод поиска токена в БД
        if ($row) {
            $_SESSION['user_id'] = $row['user_id'];
            self::loadUserById($row['user_id']);
        }
    }

    // -------------------------------------------------
    // Проверка авторизации
    // -------------------------------------------------
    public static function check(): bool
    {
        return self::$isAuth;
    }

    public static function guest(): bool
    {
        return !self::$isAuth;
    }

    // -------------------------------------------------
    // Геттеры
    // -------------------------------------------------
    public static function id(): ?int
    {
        return self::$id;
    }

    public static function username(): ?string
    {
        return self::$username;
    }

    public static function email(): ?string
    {
        return self::$email;
    }

    public static function role(): ?string
    {
        return self::$role;
    }

    public static function avatar(): ?string
    {
        return self::$avatar;
    }

    public static function ip(): ?string
    {
        return self::$ip;
    }

    public static function userAgent(): ?string
    {
        return self::$userAgent;
    }

    // -------------------------------------------------
    // Сеттеры (если нужно менять данные вручную)
    // -------------------------------------------------
    public static function setUsername(string $username): void
    {
        self::$username = $username;
    }

    public static function setEmail(string $email): void
    {
        self::$email = $email;
    }

    public static function setRole(string $role): void
    {
        self::$role = $role;
    }

    // -------------------------------------------------
    // Logout
    // -------------------------------------------------
    public static function logout(): void
    {
        session_destroy();
        self::$id = null;
        self::$username = null;
        self::$email = null;
        self::$role = null;
        self::$avatar = null;
        self::$isAuth = false;
        self::$remember = false;
    }
}