<?php
namespace Modules\User\Modul\Support;

class Config
{
    private static $statusLoad = false;
    public static $config;

    public static function load()
    {
        $configPath = APP_ROOT . DS . "modules" . DS . "user" . DS . "modul" . DS .  "support" . DS ."config.json";
        self::$config = json_decode(file_get_contents($configPath), true);
        self::$statusLoad = true;
    }

    public static function takeFull(){
        if(!self::$statusLoad){
            self::load();
        }
        return self::$config;
    }

    /**
    * Получение значения по ключу с поддержкой вложенности через точку
    * Пример: get('limits.min_pass')
    * 
    */

    public static function get($key, $default = null)
    {
        $config = self::takeFull();
        
        if ($config === null) {
            return $default;
        }
        
        $keys = explode('.', $key);
        $value = $config;
        
        foreach ($keys as $segment) {
            if (!isset($value[$segment])) {
                return $default;
            }
            $value = $value[$segment];
        }
        
        return $value;
    }
}