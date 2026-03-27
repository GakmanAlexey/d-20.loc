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
        $this->username = $_POST[\Modules\User\Modul\Support\Config::get("form.register.username")] ?? '';
        $this->password = $_POST[\Modules\User\Modul\Support\Config::get("form.register.password")] ?? '';
        $this->password_confirm = $_POST[\Modules\User\Modul\Support\Config::get("form.register.password_confirm")] ?? '';
        $this->email = $_POST[\Modules\User\Modul\Support\Config::get("form.register.email")] ?? '';
        $this->csrftoken = $_POST[\Modules\User\Modul\Support\Config::get("form.register.csft")] ?? null;
    }
    
//сетеры
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    public function setPasswordConfirm(string $password_confirm): self
    {
        $this->password_confirm = $password_confirm;
        return $this;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
    public function setCsrftoken(?string $csrftoken): self
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