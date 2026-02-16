<?php
namespace Modules\User\Modul;

use Modules\Core\Modul\Sql;

class Service
{
    public bool $status = false;
    public string $msg = '';
    public string $type = 'error'; // 'success' или 'error'
    private Manager $manager;
    private Validator $validator;
    private Auth $auth;

    public function __construct()
    {
        $this->manager = new Manager();
        $this->validator = new Validator();
        $this->auth = new Auth();
    }

    /* =========================
     * Authentication
     * ========================= */

    /**
     * Обработка авторизации
     */
    public function auth(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['auth_button'])) {
            $this->msg = 'Некорректный запрос';
            return false;
        }

        $formData = new Formdata();
        $formData->fillFromArray($_POST);

        $email = $formData->getEmail() ?? '';
        $password = $formData->getPassword() ?? '';

        // Валидация
        if (empty($email)) {
            $this->msg = 'Email не может быть пустым';
            $this->type = 'error';
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->msg = 'Email имеет неверный формат';
            $this->type = 'error';
            return false;
        }

        if (empty($password)) {
            $this->msg = 'Пароль не может быть пустым';
            $this->type = 'error';
            return false;
        }

        // Поиск пользователя по email
        $db = Sql::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $userData = $stmt->fetch();

        if (!$userData) {
            $this->msg = 'Пользователь не найден';
            $this->type = 'error';
            return false;
        }

        // Проверка бана
        if ((bool)$userData['is_ban']) {
            $expiryBan = $userData['expiry_ban'];
            if ($expiryBan === null || strtotime($expiryBan) > time()) {
                $this->msg = 'Ваш аккаунт заблокирован';
                if ($userData['reason_ban']) {
                    $this->msg .= '. Причина: ' . htmlspecialchars($userData['reason_ban']);
                }
                $this->type = 'error';
                return false;
            }
        }

        // Проверка активности
        if (!(bool)$userData['is_active']) {
            $this->msg = 'Ваш аккаунт не активирован';
            $this->type = 'error';
            return false;
        }

        // Проверка пароля
        if (!Hash::verify($password, $userData['password_hash'])) {
            $this->msg = 'Неверный пароль';
            $this->type = 'error';
            return false;
        }

        // Успешная авторизация
        $_SESSION['id'] = $userData['id'];
        $_SESSION['email'] = $userData['email'];
        $_SESSION['username'] = $userData['login'];

        $this->msg = 'Вы успешно вошли в систему';
        $this->type = 'success';
        $this->status = true;

        return true;
    }

    /* =========================
     * Registration
     * ========================= */

    /**
     * Обработка регистрации
     */
    public function register(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['reg_button'])) {
            $this->msg = 'Некорректный запрос';
            return false;
        }

        $formData = new Formdata();
        $formData->fillFromArray($_POST);

        // Валидация
        $errors = $this->validator->validateRegistration([
            'username' => $formData->getLogin() ?? '',
            'email' => $formData->getEmail() ?? '',
            'password' => $formData->getPassword() ?? '',
            'password_confirm' => $formData->getPasswordConfirm() ?? ''
        ]);

        if (!empty($errors)) {
            $this->msg = implode('<br>', $errors);
            $this->type = 'error';
            return false;
        }

        $email = $formData->getEmail();
        $username = $formData->getLogin();
        $password = $formData->getPassword();

        // Проверка, есть ли пользователь с таким email
        $db = Sql::connect();
        $stmt = $db->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            $this->msg = 'Пользователь с таким email уже существует';
            $this->type = 'error';
            return false;
        }

        // Проверка, есть ли пользователь с таким username
        if (!empty($username)) {
            $stmt = $db->prepare("SELECT id FROM users WHERE login = :login LIMIT 1");
            $stmt->execute(['login' => $username]);
            if ($stmt->fetch()) {
                $this->msg = 'Имя пользователя уже занято';
                $this->type = 'error';
                return false;
            }
        }

        // Создание нового пользователя
        $this->manager->create();
        $user = $this->manager->getUser();
        $user->setUsername($username ?? '');
        $user->setEmail($email);
        $user->setPasswordHash(Hash::password($password));
        $user->setIsActive(true);
        $user->setIsBan(false);
        $user->setReasonBan('');
        $user->setToken(Hash::random(32));

        // Сохранение
        if ($this->manager->save()) {
            $this->msg = 'Регистрация прошла успешно! Вы можете войти.';
            $this->type = 'success';
            $this->status = true;
            return true;
        } else {
            $this->msg = 'Ошибка сервера. Попробуйте позже.';
            $this->type = 'error';
            return false;
        }
    }

    /* =========================
     * Password Change
     * ========================= */

    /**
     * Смена пароля авторизованного пользователя
     */
    public function changePassword(): bool
    {
        if (!isset($_SESSION['id']) || $_SESSION['id'] < 1) {
            $this->msg = 'Вы не авторизованы';
            $this->type = 'error';
            return false;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['change_pass_button'])) {
            $this->msg = 'Некорректный запрос';
            return false;
        }

        $formData = new Formdata();
        $formData->fillFromArray($_POST);

        $oldPassword = $formData->getPassword() ?? '';
        $newPassword = $_POST['password_new'] ?? '';
        $newPasswordConfirm = $_POST['password_new_confirm'] ?? '';

        // Валидация
        if (empty($oldPassword)) {
            $this->msg = 'Текущий пароль не может быть пустым';
            $this->type = 'error';
            return false;
        }

        if (empty($newPassword)) {
            $this->msg = 'Новый пароль не может быть пустым';
            $this->type = 'error';
            return false;
        }

        if ($newPassword !== $newPasswordConfirm) {
            $this->msg = 'Пароли не совпадают';
            $this->type = 'error';
            return false;
        }

        if (strlen($newPassword) < 6) {
            $this->msg = 'Пароль должен быть не менее 6 символов';
            $this->type = 'error';
            return false;
        }

        // Загрузка текущего пользователя
        $this->manager->loadById($_SESSION['id']);
        $user = $this->manager->getUser();

        // Проверка старого пароля
        if (!Hash::verify($oldPassword, $user->getPasswordHash())) {
            $this->msg = 'Текущий пароль введен неверно';
            $this->type = 'error';
            return false;
        }

        // Обновление пароля
        $user->setPasswordHash(Hash::password($newPassword));

        if ($this->manager->save()) {
            $this->msg = 'Пароль успешно изменен';
            $this->type = 'success';
            $this->status = true;
            return true;
        } else {
            $this->msg = 'Ошибка при сохранении пароля';
            $this->type = 'error';
            return false;
        }
    }

    /* =========================
     * Logout
     * ========================= */

    /**
     * Выход из системы
     */
    public function logout(): void
    {
        session_start();
        $_SESSION = [];
        session_destroy();
        header('Location: /');
        exit;
    }

    /* =========================
     * Verification
     * ========================= */

    /**
     * Верификация пользователя по токену
     */
    public function verification(): bool
    {
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            $this->msg = 'Токен верификации отсутствует';
            return false;
        }

        $db = Sql::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE token = :token LIMIT 1");
        $stmt->execute(['token' => $token]);
        $userData = $stmt->fetch();

        if (!$userData) {
            $this->msg = 'Неверный токен верификации';
            return false;
        }

        // Обновляем активность пользователя
        $stmt = $db->prepare("UPDATE users SET is_active = 1 WHERE id = :id");
        if ($stmt->execute(['id' => $userData['id']])) {
            $this->msg = 'Ваш аккаунт успешно активирован';
            $this->type = 'success';
            $this->status = true;
            return true;
        }

        $this->msg = 'Ошибка при активации аккаунта';
        return false;
    }
}
