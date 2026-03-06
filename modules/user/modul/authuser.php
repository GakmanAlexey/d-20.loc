<?php

namespace Modules\User\Modul;

class Authuser extends User
{
    private ?string $session_id = null;
    private ?string $remember_token = null;

    private ?string $last_login_ip = null;
    private ?\DateTime $last_login_at = null;

    private bool $authenticated = false;

    /* ================= SESSION ================= */

    public function getSessionId(): ?string
    {
        return $this->session_id;
    }

    public function setSessionId(string $sessionId): self
    {
        $this->session_id = $sessionId;
        return $this;
    }

    /* ================= REMEMBER TOKEN ================= */

    public function getRememberToken(): ?string
    {
        return $this->remember_token;
    }

    public function setRememberToken(?string $token): self
    {
        $this->remember_token = $token;
        return $this;
    }

    public function generateRememberToken(): self
    {
        $this->remember_token = bin2hex(random_bytes(32));
        return $this;
    }

    /* ================= LOGIN INFO ================= */

    public function getLastLoginIp(): ?string
    {
        return $this->last_login_ip;
    }

    public function getLastLoginAt(): ?\DateTime
    {
        return $this->last_login_at;
    }

    public function updateLastLogin(string $ip): self
    {
        $this->last_login_ip = $ip;
        $this->last_login_at = new \DateTime();
        return $this;
    }

    /* ================= AUTH ================= */

    public function isAuthenticated(): bool
    {
        return $this->authenticated;
    }

    public function login(string $ip): self
    {
        $this->session_id = session_id();
        $this->authenticated = true;

        $this->updateLastLogin($ip);

        return $this;
    }

    public function logout(): self
    {
        $this->session_id = null;
        $this->remember_token = null;
        $this->authenticated = false;

        return $this;
    }

    /* ================= PASSWORD ================= */

    public function checkPassword(string $password): bool
    {
        return Hash::verify($password, $this->getPasswordHash());
    }
}