<?php
namespace Modules\User\Modul;

use Modules\Core\Modul\Sql;

class Manager
{
    private User $user;
    private Sql $db;

    public function __construct()
    {
        $this->db = Sql::connect();
    }

    /**
     * Создать нового пользователя
     */
    public function create(): self
    {
        $this->user = new User();
        return $this;
    }

    /**
     * Загрузить пользователя из БД по ID
     */
    public function loadById(int $id): self
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();

        if ($data) {
            $this->mapDataToUser($data);
        }

        return $this;
    }

    /**
     * Загрузить пользователя по логину
     */
    public function loadByLogin(string $login): self
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE login = :login LIMIT 1");
        $stmt->execute(['login' => $login]);
        $data = $stmt->fetch();

        if ($data) {
            $this->mapDataToUser($data);
        }

        return $this;
    }

    /**
     * Сохранить пользователя (insert или update)
     */
    public function save(): bool
    {
        if ($this->user->getId() > 0) {
            // Update
            $stmt = $this->db->prepare("
                UPDATE users SET
                    login = :login,
                    email = :email,
                    password_hash = :password_hash,
                    token = :token,
                    is_active = :is_active,
                    is_ban = :is_ban,
                    reason_ban = :reason_ban,
                    expiry_ban = :expiry_ban,
                    status = :status,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :id
            ");

            return $stmt->execute([
                'login' => $this->user->getUsername(),
                'email' => $this->user->getEmail(),
                'password_hash' => $this->user->getPasswordHash(),
                'token' => $this->user->getToken(),
                'is_active' => $this->user->isActive() ? 1 : 0,
                'is_ban' => $this->user->isBanned() ? 1 : 0,
                'reason_ban' => $this->user->getReasonBan(),
                'expiry_ban' => $this->user->getExpiryBan(),
                'status' => $this->user->getStatus(),
                'id' => $this->user->getId()
            ]);
        } else {
            // Insert
            $stmt = $this->db->prepare("
                INSERT INTO users (
                    login, email, password_hash, token, is_active, is_ban,
                    reason_ban, expiry_ban, status, created_at, updated_at
                ) VALUES (
                    :login, :email, :password_hash, :token, :is_active, :is_ban,
                    :reason_ban, :expiry_ban, :status, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
                )
            ");

            $result = $stmt->execute([
                'login' => $this->user->getUsername(),
                'email' => $this->user->getEmail(),
                'password_hash' => $this->user->getPasswordHash(),
                'token' => $this->user->getToken(),
                'is_active' => $this->user->isActive() ? 1 : 0,
                'is_ban' => $this->user->isBanned() ? 1 : 0,
                'reason_ban' => $this->user->getReasonBan(),
                'expiry_ban' => $this->user->getExpiryBan(),
                'status' => $this->user->getStatus()
            ]);

            if ($result) {
                $this->user->setId((int)$this->db->lastInsertId());
            }

            return $result;
        }
    }

    /**
     * Удалить пользователя
     */
    public function delete(): bool
    {
        if ($this->user->getId() <= 0) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $this->user->getId()]);
    }

    /**
     * Получить объект User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Вспомогательный метод для заполнения User данными из БД
     */
    private function mapDataToUser(array $data): void
    {
        $this->user = new User();
        $this->user->setId((int)$data['id']);
        $this->user->setUsername($data['login']);
        $this->user->setEmail($data['email']);
        $this->user->setPasswordHash($data['password_hash']);
        $this->user->setToken($data['token'] ?? '');
        $this->user->setIsActive((bool)$data['is_active']);
        $this->user->setIsBan((bool)$data['is_ban']);
        $this->user->setReasonBan($data['reason_ban'] ?? '');
        $this->user->setExpiryBan($data['expiry_ban'] ?? null);
        $this->user->setStatus($data['status']);
        $this->user->setCreatedAt($data['created_at'] ?? null);
        $this->user->setUpdatedAt($data['updated_at'] ?? null);
    }
}
