<?php
namespace Modules\User\Modul;

class Hash
{
    /**
     * Хеширование пароля через Argon2id (с помощью libsodium)
     * @param string $password
     * @return string
     */
    public static function password(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2ID);
    }

    /**
     * Проверка пароля
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public static function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Генерация безопасного случайного токена
     * @param int $length - длина в байтах (по умолчанию 32 байта)
     * @return string - hex строка
     */
    public static function random(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    /**
     * Генерация ключа для HMAC
     * @param int $length
     * @return string
     */
    public static function hmacKey(int $length = 32): string
    {
        return random_bytes($length);
    }

    /**
     * HMAC хеш данных с безопасным ключом
     * @param string $data
     * @param string $key
     * @return string
     */
    public static function hmac(string $data, string $key): string
    {
        return hash_hmac('sha512', $data, $key, true); // raw binary
    }

    /**
     * Шифрование данных с использованием libsodium
     * @param string $data
     * @param string $key
     * @return string - base64
     */
    public static function encrypt(string $data, string $key): string
    {
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $cipher = sodium_crypto_secretbox($data, $nonce, $key);
        return base64_encode($nonce . $cipher);
    }

    /**
     * Расшифровка данных с использованием libsodium
     * @param string $cipherText - base64
     * @param string $key
     * @return string|false - false если не удалось расшифровать
     */
    public static function decrypt(string $cipherText, string $key)
    {
        $raw = base64_decode($cipherText);
        $nonce = mb_substr($raw, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
        $cipher = mb_substr($raw, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
        $decrypted = sodium_crypto_secretbox_open($cipher, $nonce, $key);
        return $decrypted === false ? false : $decrypted;
    }
}
