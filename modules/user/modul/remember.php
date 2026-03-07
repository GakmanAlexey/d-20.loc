<?php

namespace Modules\User\Modul;

class Remember
{
    function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    function hashToken(string $token): string
    {
        return hash('sha256', $token);
    }

    function verifyToken(string $token, string $hash): bool
    {
        return hash_equals($hash, hash('sha256', $token));
    }
}