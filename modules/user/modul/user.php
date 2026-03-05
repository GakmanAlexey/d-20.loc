<?php

namespace Modules\User\Modul;

class User
{
    private ?int $id = null;
    private string $username;
    private string $email;
    private string $password_hash;
    private ?string $password = null; // оригинальный пароль в памяти
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
    public function setId(int $id): self { $this->id = $id; return $this; }

    /* ================= USERNAME ================= */
    public function getUsername(): string { return $this->username; }
    public function setUsername(string $username): self { $this->username = $username; return $this; }

    /* ================= EMAIL ================= */
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    /* ================= PASSWORD HASH ================= */
    public function getPasswordHash(): string { return $this->password_hash; }
    public function setPasswordHash(string $hash): self { $this->password_hash = $hash; return $this; }

    /* ================= ORIGINAL PASSWORD ================= */
    public function getPassword(): ?string { return $this->password; }
    public function setPassword(?string $password): self { $this->password = $password; return $this; }

    /* ================= ACTIVE ================= */
    public function isActive(): bool { return $this->is_active; }
    public function setActive(bool $active): self { $this->is_active = $active; return $this; }

    /* ================= BANNED ================= */
    public function isBanned(): bool { return $this->is_banned; }
    public function setBanned(bool $banned): self { $this->is_banned = $banned; return $this; }
    public function getBanReason(): ?string { return $this->ban_reason; }
    public function setBanReason(?string $reason): self { $this->ban_reason = $reason; return $this; }
    public function getBanExpiryDate(): ?\DateTime { return $this->ban_expiry_date; }
    public function setBanExpiryDate(?\DateTime $date): self { $this->ban_expiry_date = $date; return $this; }

    /* ================= DATES ================= */
    public function getCreatedAt(): ?\DateTime { return $this->created_at; }
    public function setCreatedAt(\DateTime $date): self { $this->created_at = $date; return $this; }
    public function getUpdatedAt(): ?\DateTime { return $this->updated_at; }
    public function setUpdatedAt(\DateTime $date): self { $this->updated_at = $date; return $this; }

    /* ================= UTILITY ================= */
    public function ban(string $reason, ?\DateTime $expiry = null): self
    {
        $this->is_banned = true;
        $this->ban_reason = $reason;
        $this->ban_expiry_date = $expiry;
        return $this;
    }
}