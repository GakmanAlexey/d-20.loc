<?php
namespace Modules\User\Modul;

class User
{
    private int $id;
    private string $username;
    private string $email;
    private string $password_hash;
    private string $password;
    private string $token;
    private bool $is_active;
    private bool $is_ban;
    private string $reason_ban;
    private string $expiry_ban;

    /* =========================
     * ID
     * ========================= */

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /* =========================
     * Username
     * ========================= */

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /* =========================
     * Email
     * ========================= */

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /* =========================
     * Password Hash
     * ========================= */

    public function getPasswordHash(): string
    {
        return $this->password_hash;
    }

    public function setPasswordHash(string $password_hash): self
    {
        $this->password_hash = $password_hash;
        return $this;
    }

    /* =========================
     * Raw Password (временное хранение)
     * ========================= */

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /* =========================
     * Token
     * ========================= */

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    /* =========================
     * Active Status
     * ========================= */

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;
        return $this;
    }

    /* =========================
     * Ban Status
     * ========================= */

    public function isBanned(): bool
    {
        return $this->is_ban;
    }

    public function setIsBan(bool $is_ban): self
    {
        $this->is_ban = $is_ban;
        return $this;
    }

    public function getReasonBan(): string
    {
        return $this->reason_ban;
    }

    public function setReasonBan(string $reason_ban): self
    {
        $this->reason_ban = $reason_ban;
        return $this;
    }

    public function getExpiryBan(): ?string
    {
        return $this->expiry_ban;
    }

    public function setExpiryBan(?string $expiry_ban): self
    {
        $this->expiry_ban = $expiry_ban;
        return $this;
    }
}
