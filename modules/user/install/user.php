<?php
namespace Modules\User\Modul;

class User
{
    private int $id;
    private string $login;
    private string $email;
    private string $password_hash;
    private string $token;
    private bool $is_active;
    private bool $is_ban;
    private ?string $reason_ban;
    private ?string $expiry_ban;
    private string $status;
    private ?string $created_at;
    private ?string $updated_at;

    public function __construct()
    {
        $this->id = 0;
        $this->login = '';
        $this->email = '';
        $this->password_hash = '';
        $this->token = '';
        $this->is_active = false;
        $this->is_ban = false;
        $this->reason_ban = null;
        $this->expiry_ban = null;
        $this->status = 'active';
        $this->created_at = null;
        $this->updated_at = null;
    }

    /* =========================
     * ID
     * ========================= */
    public function getId(): int { return $this->id; }
    public function setId(int $id): self { $this->id = $id; return $this; }

    /* =========================
     * Login
     * ========================= */
    public function getLogin(): string { return $this->login; }
    public function setLogin(string $login): self { $this->login = $login; return $this; }

    /* =========================
     * Email
     * ========================= */
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    /* =========================
     * Password Hash
     * ========================= */
    public function getPasswordHash(): string { return $this->password_hash; }
    public function setPasswordHash(string $password_hash): self { $this->password_hash = $password_hash; return $this; }

    /* =========================
     * Token
     * ========================= */
    public function getToken(): string { return $this->token; }
    public function setToken(string $token): self { $this->token = $token; return $this; }

    /* =========================
     * Active Status
     * ========================= */
    public function isActive(): bool { return $this->is_active; }
    public function setIsActive(bool $is_active): self { $this->is_active = $is_active; return $this; }

    /* =========================
     * Ban Status
     * ========================= */
    public function isBanned(): bool { return $this->is_ban; }
    public function setIsBan(bool $is_ban): self { $this->is_ban = $is_ban; return $this; }

    public function getReasonBan(): ?string { return $this->reason_ban; }
    public function setReasonBan(?string $reason_ban): self { $this->reason_ban = $reason_ban; return $this; }

    public function getExpiryBan(): ?string { return $this->expiry_ban; }
    public function setExpiryBan(?string $expiry_ban): self { $this->expiry_ban = $expiry_ban; return $this; }

    /* =========================
     * Status
     * ========================= */
    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }

    /* =========================
     * Created / Updated
     * ========================= */
    public function getCreatedAt(): ?string { return $this->created_at; }
    public function setCreatedAt(?string $created_at): self { $this->created_at = $created_at; return $this; }

    public function getUpdatedAt(): ?string { return $this->updated_at; }
    public function setUpdatedAt(?string $updated_at): self { $this->updated_at = $updated_at; return $this; }
}
