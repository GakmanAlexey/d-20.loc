<?php
namespace Modules\User\Modul;

class Formdata
{
    // Основные поля формы
    private ?string $login = null;
    private ?string $email = null;
    private ?string $password = null;
    private ?string $password_confirm = null;
    private ?string $token = null;

    // Дополнительно для восстановления, редактирования и т.д.
    private ?string $status = null;
    private ?string $reason_ban = null;

    // Геттеры и сеттеры
    public function getLogin(): ?string { return $this->login; }
    public function setLogin(?string $login): self { $this->login = trim($login); return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(?string $email): self { $this->email = trim($email); return $this; }

    public function getPassword(): ?string { return $this->password; }
    public function setPassword(?string $password): self { $this->password = $password; return $this; }

    public function getPasswordConfirm(): ?string { return $this->password_confirm; }
    public function setPasswordConfirm(?string $password_confirm): self { $this->password_confirm = $password_confirm; return $this; }

    public function getToken(): ?string { return $this->token; }
    public function setToken(?string $token): self { $this->token = $token; return $this; }

    public function getStatus(): ?string { return $this->status; }
    public function setStatus(?string $status): self { $this->status = $status; return $this; }

    public function getReasonBan(): ?string { return $this->reason_ban; }
    public function setReasonBan(?string $reason_ban): self { $this->reason_ban = $reason_ban; return $this; }

    /**
     * Заполнить объект данными из массива ($_POST или $_GET)
     */
    public function fillFromArray(array $data): self
    {
        if (isset($data['login'])) $this->setLogin($data['login']);
        if (isset($data['email'])) $this->setEmail($data['email']);
        if (isset($data['password'])) $this->setPassword($data['password']);
        if (isset($data['password_confirm'])) $this->setPasswordConfirm($data['password_confirm']);
        if (isset($data['token'])) $this->setToken($data['token']);
        if (isset($data['status'])) $this->setStatus($data['status']);
        if (isset($data['reason_ban'])) $this->setReasonBan($data['reason_ban']);

        return $this;
    }
}
