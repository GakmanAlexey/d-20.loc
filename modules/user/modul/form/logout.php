<?php

namespace Modules\User\Modul\Form;

class Logout
{
    private bool $solo;
    private bool $multi;
    private ?string $csrftoken;
    public function __construct()
    {
        $this->solo = isset($_POST[\Modules\User\Modul\Support\Config::get("form.logout.solo")]);
        $this->multi = isset($_POST[\Modules\User\Modul\Support\Config::get("form.logout.multi")]);
        $this->csrftoken = $_POST[\Modules\User\Modul\Support\Config::get("form.logout.csft")] ?? null;
    }
    
//сетеры
    public function setSolo(bool $status): self
    {
        $this->solo = $status;
        return $this;
    }
    public function setMulti(bool $status): self
    {
        $this->multi = $status;
        return $this;
    }
    public function setCsrftoken(?string $csrftoken): self
    {
        $this->csrftoken = $csrftoken;
        return $this;
    }

//гетеры
    public function getSolo(): bool
    {
        return $this->solo;
    }
    public function getMulti(): bool
    {
        return $this->multi;
    }
    public function getCsrftoken(): ?string
    {
        return $this->csrftoken;
    }
}