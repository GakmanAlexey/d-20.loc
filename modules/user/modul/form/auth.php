<?php

namespace Modules\User\Modul\Form;

class Auth
{
    private string $username;
    private string $password;
    private bool $remember;
    private ?string $csrftoken;
    public function __construct()
    {
        $this->username = $_POST['username'] ?? '';
        $this->password = $_POST['password'] ?? '';
        $this->remember = isset($_POST['remember']);
        $this->csrftoken = $_POST['csrf_token'] ?? null;
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
    public function setRemember(bool $remember): self
    {
        $this->remember = $remember;
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
    public function getRemember(): bool
    {
        return $this->remember;
    }
    public function getCsrftoken(): ?string
    {
        return $this->csrftoken;
    }
}