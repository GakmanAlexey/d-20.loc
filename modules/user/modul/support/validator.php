<?php
namespace Modules\User\Modul\Support;

class Validator
{
    private array $config;
    private array $lang;

    public function __construct()
    {
        $configPath = APP_ROOT . DS . "modules" . DS . "user" . DS . "modul" . DS .  "support" . DS ."config.json";
        $this->config = json_decode(file_get_contents($configPath), true);

        $language = \Modules\Core\Modul\Env::get('APP_LANGUAGE') ?: 'ru_RU';
        $langPath = APP_ROOT . DS . "modules" . DS . "user" . DS . "modul" . DS .  "support" . DS . "lang" . DS . $language . ".json";
        $this->lang = json_decode(file_get_contents($langPath), true) ?? [];
    }

    /* ==================== PUBLIC ==================== */

    public function validateAuth(\Modules\User\Modul\Support\Messenger $massager, \Modules\User\Modul\Form\Auth $formAuth)
    {
        
        if(!$this->validateUsername($massager, $formAuth->getUsername())) {
                return ["status" => false, "message" => $massager];
        }
        if(!$this->validatePassword($massager, $formAuth->getPassword())) {
                return ["status" => false, "message" => $massager];
        }
        return ["status" => true];
    }

    



    public function validateUsername(\Modules\User\Modul\Support\Messenger $massager, $userName){
        $userName = trim($userName);
        $min = $this->config['limits']['min_username'] ?? 3;
        $max = $this->config['limits']['max_username'] ?? 20;

        if (empty($userName)) {
            $massager->addError($this->lang["login"]['login_required']);
            return false;
        }
        if (mb_strlen($userName) < $min) {
            $massager->addError(str_replace('{min_username}', $min, $this->lang["login"]['username_too_short']));
            return false;
        }
        if (mb_strlen($userName) > $max) {
            $massager->addError(str_replace('{max_username}', $max, $this->lang["login"]['username_too_long']));
            return false;
        }
        return true;
    }

    public function validatePassword(\Modules\User\Modul\Support\Messenger $massager, $password){
        
        $password = trim($password);
        $min = $this->config['limits']['min_pass'] ?? 6;
        $max = $this->config['limits']['max_pass'] ?? 255;

        if (empty($password)) {
            $massager->addError($this->lang["login"]['password_required']);
            return false;
        }
        if (mb_strlen($password) < $min) {
            $massager->addError(str_replace('{min_pass}', $min, $this->lang["login"]['password_too_short']));
            return false;
        }
        if (mb_strlen($password) > $max) {
            $massager->addError(str_replace('{max_pass}', $max, $this->lang["login"]['password_too_long']));
            return false;
        }
        return true;
    }
}