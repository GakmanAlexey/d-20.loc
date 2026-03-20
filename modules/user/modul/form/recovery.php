<?php

namespace Modules\User\Modul\Form;

class Recovery
{
    private string $username;
    private ?string $csrftoken;
    public function __construct()
    {
        $this->username = $_POST['username'] ?? '';
        $this->csrftoken = $_POST['csrftoken'] ?? null;
    }
    
//сетеры
    public function setUsername(string $username): void
    {
        $this->username = $username;
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
    public function getCsrftoken(): ?string
    {
        return $this->csrftoken;
    }
}