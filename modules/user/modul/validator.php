<?php
namespace Modules\User\Modul;

use Modules\Core\Modul\Env;

class Validator
{
    private array $limits;
    private array $messages;
    private string $langPath;

    public function __construct()
    {
        // Загружаем лимиты из config.json
        $configPath = __DIR__ . '/config.json';
        if (file_exists($configPath)) {
            $config = json_decode(file_get_contents($configPath), true);
            $this->limits = $config['limits'] ?? [];
        } else {
            $this->limits = [];
        }

        // Загружаем сообщения для выбранного языка
        $langCode = Env::get('APP_LANGUAGE', 'ru_RU');
        $this->langPath = __DIR__ . "/lang/{$langCode}.json";

        if (file_exists($this->langPath)) {
            $langData = json_decode(file_get_contents($this->langPath), true);
            $this->messages = $langData['messages'] ?? [];
        } else {
            $this->messages = [];
        }
    }

    /**
     * Проверка регистрационной формы
     * @param array $data ['username'=>..., 'email'=>..., 'password'=>..., 'password_confirm'=>...]
     * @return array массив ошибок
     */
    public function validateRegistration(array $data): array
    {
        $errors = [];

        // username
        $username = trim($data['username'] ?? '');
        if ($username === '') {
            $errors['username'] = $this->getMessage('common_required');
        } else {
            if (isset($this->limits['min_username']) && mb_strlen($username) < $this->limits['min_username']) {
                $errors['username'] = $this->replacePlaceholders(
                    $this->getMessage('username_too_short'),
                    ['min_username' => $this->limits['min_username']]
                );
            }
            if (isset($this->limits['max_username']) && mb_strlen($username) > $this->limits['max_username']) {
                $errors['username'] = $this->replacePlaceholders(
                    $this->getMessage('username_too_long'),
                    ['max_username' => $this->limits['max_username']]
                );
            }
        }

        // email
        $email = trim($data['email'] ?? '');
        if ($email === '') {
            $errors['email'] = $this->getMessage('common_required');
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = $this->getMessage('email_invalid');
        }

        // password
        $password = $data['password'] ?? '';
        $passwordConfirm = $data['password_confirm'] ?? '';
        if ($password === '') {
            $errors['password'] = $this->getMessage('common_required');
        } else {
            if (isset($this->limits['min_pass']) && mb_strlen($password) < $this->limits['min_pass']) {
                $errors['password'] = $this->replacePlaceholders(
                    $this->getMessage('password_too_short'),
                    ['min_pass' => $this->limits['min_pass']]
                );
            }
            if (isset($this->limits['max_pass']) && mb_strlen($password) > $this->limits['max_pass']) {
                $errors['password'] = $this->replacePlaceholders(
                    $this->getMessage('password_too_long'),
                    ['max_pass' => $this->limits['max_pass']]
                );
            }

            if ($password !== $passwordConfirm) {
                $errors['password_confirm'] = $this->getMessage('passwords_dont_match');
            }
        }

        return $errors;
    }

    /**
     * Получить сообщение из lang
     */
    private function getMessage(string $key): string
    {
        return $this->messages[$key] ?? $key;
    }

    /**
     * Подставить плейсхолдеры {min_pass}, {max_username} и т.д.
     */
    private function replacePlaceholders(string $message, array $replacements): string
    {
        foreach ($replacements as $key => $value) {
            $message = str_replace("{" . $key . "}", (string)$value, $message);
        }
        return $message;
    }
}
