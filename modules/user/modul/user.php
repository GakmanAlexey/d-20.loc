<?php

namespace Modules\User\Entity;

class User
{
    private ?int $id = null;
    private string $username;
    private string $email;
    private string $password_hash;
    
    /** Оригинальный пароль (только в памяти, не для БД) */
    private ?string $password = null;

    private bool $is_active = true;
    private bool $is_banned = false;
    private ?string $ban_reason = null;
    private ?\DateTime $ban_expiry_date = null;
    private ?\DateTime $created_at = null;
    private ?\DateTime $updated_at = null;

    public static function createEmpty(): self
    {
        $user = new self();
        $user->username = '';
        $user->email = '';
        $user->password_hash = '';
        $user->password = null;
        $user->is_active = false;
        $user->is_banned = false;
        $user->ban_reason = null;
        $user->ban_expiry_date = null;
        $user->created_at = new \DateTime();
        $user->updated_at = new \DateTime();
        return $user;
    }

    /* ================= ID ================= */
    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    /* ================= USERNAME ================= */
    public function getUsername(): string { return $this->username; }
    public function setUsername(string $username): void { $this->username = $username; }

    /* ================= EMAIL ================= */
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }

    /* ================= PASSWORD HASH ================= */
    public function getPasswordHash(): string { return $this->password_hash; }
    public function setPasswordHash(string $hash): void { $this->password_hash = $hash; }

    /* ================= ORIGINAL PASSWORD ================= */
    public function getPassword(): ?string { return $this->password; }
    public function setPassword(?string $password): void { $this->password = $password; }

    /* ================= ACTIVE ================= */
    public function isActive(): bool { return $this->is_active; }
    public function setActive(bool $active): void { $this->is_active = $active; }

    /* ================= BANNED ================= */
    public function isBanned(): bool { return $this->is_banned; }
    public function setBanned(bool $banned): void { $this->is_banned = $banned; }
    public function getBanReason(): ?string { return $this->ban_reason; }
    public function setBanReason(?string $reason): void { $this->ban_reason = $reason; }
    public function getBanExpiryDate(): ?\DateTime { return $this->ban_expiry_date; }
    public function setBanExpiryDate(?\DateTime $date): void { $this->ban_expiry_date = $date; }

    /* ================= DATES ================= */
    public function getCreatedAt(): ?\DateTime { return $this->created_at; }
    public function setCreatedAt(\DateTime $date): void { $this->created_at = $date; }
    public function getUpdatedAt(): ?\DateTime { return $this->updated_at; }
    public function setUpdatedAt(\DateTime $date): void { $this->updated_at = $date; }

    /* ================= UTILITY ================= */
    public function ban(string $reason, ?\DateTime $expiry = null): void
    {
        $this->is_banned = true;
        $this->ban_reason = $reason;
        $this->ban_expiry_date = $expiry;
    }
}