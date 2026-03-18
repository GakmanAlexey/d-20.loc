<?php
namespace Modules\User\Modul;

use Modules\Mail\Modul\Mail;

class Mailer
{
    /**
     * Создает случайный токен
     */
    public function createToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    /**
     * Хеширует токен
     */
    public function hashToken(string $token): string
    {
        return password_hash($token, PASSWORD_DEFAULT);
    }

    /**
     * Проверяет токен
     */
    public function verifyToken(string $token, string $hash): bool
    {
        return password_verify($token, $hash);
    }

    /**
     * Создание токена подтверждения и отправка письма
     */
    public function createConfirmToken(\Modules\User\Modul\User $user): array
    {
        try {
            $token = $this->createToken();
            $hash = $this->hashToken($token);
            
            $pdo = \Modules\Core\Modul\Sql::connect();
            $table = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users_mail_status';
            $expires = (new \DateTime('+24 hours'))->format('Y-m-d H:i:s');
            
            // ИСПРАВЛЕНО: Используем правильные названия полей из структуры БД
            $stmt = $pdo->prepare("
                INSERT INTO {$table} 
                (id_user, token_hash, type, expires_at, created_at) 
                VALUES 
                (:id_user, :token_hash, :type, :expires_at, NOW())
            ");
            
            $stmt->execute([
                'id_user' => $user->getId(),
                'token_hash' => $hash,      // было token, стало token_hash
                'type' => 'confirm_email',
                'expires_at' => $expires
            ]);
            
            // Отправляем письмо с сырым токеном (не хешированным)
            return $this->sendConfirmEmail($user->getEmail(), $token);
            
        } catch (\Exception $e) {
            $logger = new \Modules\Core\Modul\Logs();
            $logger->loging('user', "Ошибка создания токена подтверждения: " . $e->getMessage());
            
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    /**
     * Отправка письма подтверждения
     */
    public function sendConfirmEmail(string $email, string $token): array
    {
        $link = \Modules\Core\Modul\Env::get("APP_URL")."/user/register/success/?token=" . urlencode($token);
        $subject = "Подтверждение email";
        $body = "
            <h2>Подтверждение регистрации</h2>
            <p>Чтобы активировать аккаунт, перейдите по ссылке:</p>
            <p><a href='{$link}'>Подтвердить email</a></p>
            <br>
            <p>Если вы не регистрировались — просто проигнорируйте это письмо.</p>
        ";
        
        return \Modules\Mail\Modul\Mail::send($email, $subject, $body);

        
    }

    /**
     * Проверка валидности токена подтверждения
     */
    public function validateConfirmToken(string $token): ?array
    {
        try {
            $pdo = \Modules\Core\Modul\Sql::connect();
            $table = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users_mail_status';
            
            // Ищем неиспользованные токены с типом confirm_email
            $stmt = $pdo->prepare("
                SELECT * FROM {$table} 
                WHERE type = 'confirm_email' 
                AND used_at IS NULL 
                AND expires_at > NOW()
                ORDER BY created_at DESC 
                LIMIT 10
            ");
            $stmt->execute();
            $tokens = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            // Ищем среди них тот, который подходит
            foreach ($tokens as $row) {
                if ($this->verifyToken($token, $row['token_hash'])) {
                    $this->activeUser($row["id_user"]);
                    $this->markTokenAsUsed($row['id']);
                    return $row;
                }
            }
            
            return null;
            
        } catch (\Exception $e) {
            $logger = new \Modules\Core\Modul\Logs();
            $logger->loging('user', "Ошибка проверки токена: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Пометить токен как использованный
     */
    public function markTokenAsUsed(int $tokenId): bool
    {
        try {
            $pdo = \Modules\Core\Modul\Sql::connect();
            $table = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users_mail_status';
            
            $stmt = $pdo->prepare("
                UPDATE {$table} 
                SET used_at = NOW() 
                WHERE id = :id
            ");
            
            return $stmt->execute(['id' => $tokenId]);
            
        } catch (\Exception $e) {
            return false;
        }
    }

    public function activeUser($idUser){
        $pdo = \Modules\Core\Modul\Sql::connect();
        $table = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'users';

        $stmt = $pdo->prepare("
            UPDATE {$table}
            SET is_active = 1
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $idUser
        ]);
    }
}