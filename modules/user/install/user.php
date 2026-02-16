<?php

namespace Modules\User\Install;

class User extends \Modules\Abs\Install
{
    public function install_BD()
    {
        $p = \Modules\Core\Modul\Env::get("DB_PREFIX");
        $table = [];

        $table[] = "
        CREATE TABLE IF NOT EXISTS {$p}users (
            id INT(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            `login` VARCHAR(100) UNIQUE NOT NULL,
            `email` VARCHAR(150) NOT NULL,
            `password_hash` VARCHAR(255) NOT NULL,
            `name` VARCHAR(255) DEFAULT NULL,
            `role` VARCHAR(50) DEFAULT 'user',
            `status` VARCHAR(20) DEFAULT 'active',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `last_login` DATETIME DEFAULT NULL,
            `avatar` VARCHAR(255) DEFAULT NULL,
            `browser_info` TEXT DEFAULT NULL,
            `device_info` TEXT DEFAULT NULL,
            `ip` VARCHAR(45) DEFAULT NULL,
            `permissions` TEXT DEFAULT NULL,
            `groups` TEXT DEFAULT NULL,
            `preferences` TEXT DEFAULT NULL,
            `api_tokens` TEXT DEFAULT NULL,
            `login_attempts` INT DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $table[] = "
        CREATE TABLE IF NOT EXISTS {$p}user_sessions (
            id INT(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            user_id INT(12) NOT NULL,
            token VARCHAR(255) NOT NULL,
            expires_at DATETIME DEFAULT NULL,
            ip_address VARCHAR(45) DEFAULT NULL,
            user_agent TEXT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX ({$p}user_id_idx) USING BTREE (user_id),
            FOREIGN KEY (user_id) REFERENCES {$p}users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $table[] = "
        CREATE TABLE IF NOT EXISTS {$p}password_reset_tokens (
            id INT(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            user_id INT(12) NOT NULL,
            token VARCHAR(255) NOT NULL,
            expires_at DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES {$p}users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $table[] = "
        CREATE TABLE IF NOT EXISTS {$p}user_register_tokens (
            id INT(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            user_id INT(12) NOT NULL,
            token VARCHAR(255) NOT NULL,
            expires_at DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES {$p}users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $table[] = "
        CREATE TABLE IF NOT EXISTS {$p}user_activity_logs (
            id INT(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            user_id INT(12) DEFAULT NULL,
            action TEXT NOT NULL,
            ip VARCHAR(45) DEFAULT NULL,
            user_agent TEXT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX (user_id),
            FOREIGN KEY (user_id) REFERENCES {$p}users(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        // Indexes
        $table[] = "CREATE INDEX IF NOT EXISTS idx_{$p}users_login ON {$p}users(`login`);";
        $table[] = "CREATE INDEX IF NOT EXISTS idx_{$p}users_email ON {$p}users(`email`);";
        $table[] = "CREATE INDEX IF NOT EXISTS idx_{$p}user_sessions_user_id ON {$p}user_sessions(user_id);";

        return $table;
    }

    public function install_Router()
    {
        $routes = [];

        return $routes;
    }

    public function install_Congif()
    {
        $conf = [];
        return $conf;
    }
}
