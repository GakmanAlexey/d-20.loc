<?php
namespace Modules\User\Modul\Support;

class Mailer
{
    public function createToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    public function hashToken(string $token): string
    {
        return password_hash($token, PASSWORD_DEFAULT);
    }

    public function verifyToken(string $token, string $hash): bool
    {
        return password_verify($token, $hash);
    }
    public function createConfirmToken(\Modules\User\Modul\Entity\User $user){
        $token = $this->createToken();
        $hash = $this->hashToken($token);
        $reposetory = new \Modules\User\Modul\Repository\Mailer;
        $reposetory->saveConfirmToken($user->getId(), $hash);

        return $this->sand($user, $token);
    }

    public function sand(\Modules\User\Modul\Entity\User $user, string $token){
        $email = $user->getEmail();
        $link = \Modules\Core\Modul\Env::get("APP_URL").\Modules\User\Modul\Support\Config::get("link.registerComplete") . urlencode($token);
        $subject = "Подтверждение email";
        $body = "
            <h2>Подтверждение регистрации</h2>
            <p>Уважаемый(-ая) {$user->getUsername()}!</p>
            <p>Чтобы активировать аккаунт, перейдите по ссылке:</p>
            <p><a href='{$link}'>Подтвердить email</a></p>
            <br>
            <p>Если вы не регистрировались — просто проигнорируйте это письмо.</p>
        ";
        
        return \Modules\Mail\Modul\Mail::send($email, $subject, $body);

    }
}