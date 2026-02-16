<?php
namespace Modules\User\Modul;

use Modules\Core\Modul\Sql;

class Register
{
    private Manager $manager;
    private Validator $validator;
    private array $messages = [];

    public function __construct()
    {
        $this->manager = new Manager();
        $this->validator = new Validator();
    }

    /**
     * Обработка регистрации
     */
    public function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reg_button'])) {
            // Заполняем объект формы
            $formData = new Formdata();
            $formData->fillFromArray($_POST);

            // Валидация
            $errors = $this->validator->validateRegistration([
                'username' => $formData->getLogin() ?? '',
                'email' => $formData->getEmail(),
                'password' => $formData->getPassword(),
                'password_confirm' => $formData->getPasswordConfirm()
            ]);

            if (!empty($errors)) {
                $this->messages = $errors;
                return;
            }

            // Проверка, есть ли пользователь с таким email
            $db = Sql::connect();
            $stmt = $db->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $formData->getEmail()]);
            if ($stmt->fetch()) {
                $this->messages['email'] = 'Пользователь с таким email уже существует';
                return;
            }

            // Проверка, есть ли пользователь с таким username
            if (!empty($formData->getLogin())) {
                $stmt = $db->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
                $stmt->execute(['username' => $formData->getLogin()]);
                if ($stmt->fetch()) {
                    $this->messages['username'] = 'Имя пользователя уже занято';
                    return;
                }
            }

            // Создаём нового пользователя через Manager
            $this->manager->create();
            $user = $this->manager->getUser();
            $user->setUsername($formData->getLogin() ?? '');
            $user->setEmail($formData->getEmail());

            // Крипто-хеширование пароля
            $hashedPassword = Hash::password($formData->getPassword());
            $user->setPasswordHash($hashedPassword);

            $user->setIsActive(true); // по умолчанию активен
            $user->setIsBan(false);

            // Генерация токена для пользователя
            $user->setToken(Hash::random(32));

            // Сохраняем пользователя
            if ($this->manager->save()) {
                $this->messages['success'] = 'Регистрация прошла успешно! Вы можете войти.';
            } else {
                $this->messages['error'] = 'Ошибка сервера. Попробуйте позже.';
            }
        }
    }

    /**
     * Получить сообщения для вывода в форму
     */
    public function getMessages(): string
    {
        if (empty($this->messages)) return '';

        $html = '<ul class="ga_user_error_list">';
        foreach ($this->messages as $msg) {
            $html .= '<li>' . htmlspecialchars($msg) . '</li>';
        }
        $html .= '</ul>';

        return $html;
    }
}
