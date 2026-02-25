<?php
namespace Modules\User\Modul;

class Formdata
{
    private $login = null;
    private $email = null;
    private $password = null;
    private $password_confirm = null;
    private $token = null;
    private $status = false;
    private $msg = [];

    public function setFromArray(array $data)
    {
        if (isset($data['login'])) $this->setLogin($data['login']);
        if (isset($data['email'])) $this->setEmail($data['email']);
        if (isset($data['password'])) $this->setPassword($data['password']);
        if (isset($data['password_confirm'])) $this->setPasswordConfirm($data['password_confirm']);
        if (isset($data['token'])) $this->setToken($data['token']);
        return $this;
    }

    public function setFromForma()
    {
        if (isset($_POST['login'])) $this->setLogin($_POST['login']);
        if (isset($_POST['email'])) $this->setEmail($_POST['email']);
        if (isset($_POST['password'])) $this->setPassword($_POST['password']);
        if (isset($_POST['password_confirm'])) $this->setPasswordConfirm($_POST['password_confirm']);
        if (isset($_POST['token'])) $this->setToken($_POST['token']);
        return $this;
    }

    /* ========== SETTERS ========== */

    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function setPasswordConfirm($password_confirm)
    {
        $this->password_confirm = $password_confirm;
        return $this;
    }

    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function setStatus(bool $status)
    {
        $this->status = $status;
        return $this;
    }

    public function setMsg(array $msg)
    {
        $this->msg = $msg;
        return $this;
    }

    public function addMsg(string $message)
    {
        $this->msg[] = $message;
        return $this;
    }

    /* ========== GETTERS ========== */

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getPasswordConfirm(): ?string
    {
        return $this->password_confirm;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getMsg(): array
    {
        return $this->msg;
    }
}