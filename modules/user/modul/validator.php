<?php
namespace Modules\User\Modul;

class Validator
{
    private array $config;
    private array $lang;

    public function __construct()
    {
        $configPath = APP_ROOT . DS . "modules" . DS . "user" . DS . "modul" . DS . "config.json";
        $this->config = json_decode(file_get_contents($configPath), true);

        $language = \Modules\Core\Modul\Env::get('APP_LANGUAGE') ?: 'ru_RU';
        $langPath = APP_ROOT . DS . "modules" . DS . "user" . DS . "modul" . DS . "lang" . DS . $language . ".json";
        $this->lang = json_decode(file_get_contents($langPath), true)['messages'] ?? [];
    }

    /* ==================== PUBLIC ==================== */

    public function validateLogin(Formdata $form): bool
    {
        $login = trim($form->getLogin());
        $min = $this->config['limits']['min_username'] ?? 3;
        $max = $this->config['limits']['max_username'] ?? 20;

        if (empty($login)) {
            $form->addMsg($this->lang['common_required']);
            return false;
        }

        if (mb_strlen($login) < $min) {
            $form->addMsg(str_replace('{min_username}', $min, $this->lang['username_too_short']));
            return false;
        }

        if (mb_strlen($login) > $max) {
            $form->addMsg(str_replace('{max_username}', $max, $this->lang['username_too_long']));
            return false;
        }

        if (!$this->isUsernameAvailable($login)) {
            $form->addMsg($this->lang['username_taken']);
            return false;
        }

        return true;
    }

    public function validateEmail(Formdata $form): bool
    {
        $email = trim($form->getEmail());

        if (empty($email)) {
            $form->addMsg($this->lang['common_required']);
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $form->addMsg($this->lang['email_invalid']);
            return false;
        }

        return true;
    }

    public function validatePassword(Formdata $form): bool
    {
        $password = $form->getPassword();
        $min = $this->config['limits']['min_pass'] ?? 8;
        $max = $this->config['limits']['max_pass'] ?? 32;

        if (empty($password)) {
            $form->addMsg($this->lang['common_required']);
            return false;
        }

        if (mb_strlen($password) < $min) {
            $form->addMsg(str_replace('{min_pass}', $min, $this->lang['password_too_short']));
            return false;
        }

        if (mb_strlen($password) > $max) {
            $form->addMsg(str_replace('{max_pass}', $max, $this->lang['password_too_long']));
            return false;
        }

        return true;
    }

    public function validatePasswordConfirm(Formdata $form): bool
    {
        if ($form->getPassword() !== $form->getPasswordConfirm()) {
            $form->addMsg($this->lang['passwords_dont_match']);
            return false;
        }

        return true;
    }

    public function validateCsrf(Formdata $form): bool
    {
        if (!\Modules\Core\Modul\Csrftoken::validateToken($form->getToken())) {
            $form->addMsg($this->lang['server_error']);
            return false;
        }

        return true;
    }

    /* ==================== GROUP VALIDATORS ==================== */

    public function validateAuth(Formdata $form): bool
    {
        if (!$this->validateCsrf($form)) return false;
        if (!$this->validateLogin($form)) return false;
        if (!$this->validatePassword($form)) return false;

        return true;
    }

    public function validateRegister(Formdata $form): bool
    {
        if (!$this->validateCsrf($form)) return false;
        if (!$this->validateLogin($form)) return false;
        if (!$this->validateEmail($form)) return false;
        if (!$this->validatePassword($form)) return false;
        if (!$this->validatePasswordConfirm($form)) return false;

        return true;
    }

    /* ==================== PRIVATE ==================== */

    private function isUsernameAvailable(string $login): bool
    {
        $pdo = \Modules\Core\Modul\Sql::connect();

        try {
            $stmt = $pdo->prepare("
                SELECT 1 
                FROM ".\Modules\Core\Modul\Env::get("DB_PREFIX")."users 
                WHERE username = :username 
                LIMIT 1
            ");

            $stmt->execute([
                ':username' => $login
            ]);

            return !((bool) $stmt->fetchColumn());

        } catch (\PDOException $e) {
            error_log("Username check error: " . $e->getMessage());
            return false; // в случае ошибки безопаснее считать, что логин занят
        }
    }
}