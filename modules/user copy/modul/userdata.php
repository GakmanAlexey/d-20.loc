<?php

namespace Modules\User\Modul;

//  \Modules\User\Modul\Userdata::$getIp();
//  \Modules\User\Modul\Userdata::$getAgent();
class Userdata
{
    private static ?string $ip = null;
    private static ?string $agent = null;

    public static function init(): void
    {
        self::$ip = self::getUserIP();
        self::$agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
    }

    public static function getIp(): ?string
    {
        if(self::$ip === null) {
            self::$ip = self::getUserIP();
        }
        return self::$ip;
    }

    public static function getAgent(): ?string
    {
        if(self::$agent === null) {
            self::$agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        }
        return self::$agent;
    }

    public static function setIp(string $ip): void
    {
        self::$ip = $ip;
    }

    public static function setAgent(string $agent): void
    {
        self::$agent = $agent;
    }

    /**
     * Получение реального IP пользователя
     */
    private static function getUserIP(): string
    {
        $ipKeys = [
            'HTTP_CF_CONNECTING_IP',
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($ipKeys as $key) {

            if (!empty($_SERVER[$key] ?? null)) {

                $ips = explode(',', (string)$_SERVER[$key]);

                foreach ($ips as $ip) {

                    $ip = trim($ip);

                    if (filter_var(
                        $ip,
                        FILTER_VALIDATE_IP,
                        FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
                    )) {
                        return $ip;
                    }

                }
            }
        }

        return $_SERVER['REMOTE_ADDR'] ?? '';
    }
}