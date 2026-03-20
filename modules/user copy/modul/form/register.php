<?php

namespace Modules\User\Modul\Form;

class Register
{
    private string $username;
    private string $password;
    private string $password_confirm;
    private string $email;
    private ?string $csrftoken;
    public function __construct()
    {
        $this->username = $_POST['username'] ?? '';
        $this->password = $_POST['password'] ?? '';
        $this->password_confirm = $_POST['password_confirm'] ?? '';
        $this->email = $_POST['email'] ?? '';
        $this->csrftoken = $_POST['csrftoken'] ?? null;
    }
    
//сетеры
    public function setUsername(string $username): void
    {
        $this->username = $username;
        return $this;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
        return $this;
    }
    public function setPasswordConfirm(string $password_confirm): void
    {
        $this->password_confirm = $password_confirm;
        return $this;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
        return $this;
    }
    public function setCsrftoken(?string $csrftoken): void
    {
        $this->csrftoken = $csrftoken;
        return $this;
    }

//гетеры
    public function getUsername(): string
    {
        return $this->username;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getPasswordConfirm(): string
    {
        return $this->password_confirm;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getCsrftoken(): ?string
    {
        return $this->csrftoken;
    }
}