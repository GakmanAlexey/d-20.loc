<?php

namespace Modules\User\Modul\Form;

class Recoverypassword
{
    private string $password;
    private string $password_confirm;  
    private ?string $csrftoken;
    public function __construct()
    {
        $this->password = $_POST['password'] ?? '';
        $this->password_confirm = $_POST['password_confirm'] ?? '';
        $this->csrftoken = $_POST['csrftoken'] ?? null;
    }
    
//сетеры
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
    public function setCsrftoken(?string $csrftoken): void
    {
        $this->csrftoken = $csrftoken;
        return $this;
    }

//гетеры
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getPasswordConfirm(): string
    {
        return $this->password_confirm;
    }
    public function getCsrftoken(): ?string
    {
        return $this->csrftoken;
    }
}