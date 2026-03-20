<?php

namespace Modules\User\Install;

class User  extends \Modules\Abs\Install{

    public function install_BD(){
        $table = [];
        $table[] = '
            CREATE TABLE '.\Modules\Core\Modul\Env::get("DB_PREFIX").'users (
            id INT(12) PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50) UNIQUE NOT NULL, 
            email VARCHAR(100) NOT NULL,          
            password_hash VARCHAR(255) NOT NULL,
            is_active BOOLEAN DEFAULT TRUE,
            `is_banned` BOOLEAN DEFAULT FALSE,
            `ban_reason` VARCHAR(255) DEFAULT NULL,
            `ban_expiry_date` DATETIME DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )            
        ';
        $table[] = '
            CREATE TABLE '.\Modules\Core\Modul\Env::get("DB_PREFIX").'users_mail_status (
            id INT(12) PRIMARY KEY AUTO_INCREMENT,
            id_user INT(12) NOT NULL, 
            token_hash VARCHAR(255) NOT NULL, 
            type VARCHAR(50) NOT NULL, 
            expires_at DATETIME NOT NULL, 
            used_at DATETIME DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )            
        ';

        $table[] = '
        CREATE TABLE '.\Modules\Core\Modul\Env::get("DB_PREFIX").'user_auth_log (
            id INT(12) PRIMARY KEY AUTO_INCREMENT,
            user_id INT(12) DEFAULT NULL,
            event VARCHAR(50) NOT NULL,
            success BOOLEAN NOT NULL DEFAULT FALSE,
            login VARCHAR(255) DEFAULT NULL,
            reason VARCHAR(255) DEFAULT NULL,
            ip_address VARCHAR(45) DEFAULT NULL,
            user_agent TEXT DEFAULT NULL,
            device VARCHAR(255) DEFAULT NULL,
            browser VARCHAR(100) DEFAULT NULL,
            os VARCHAR(100) DEFAULT NULL,
            metadata JSON DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES '.\Modules\Core\Modul\Env::get("DB_PREFIX").'users(id) ON DELETE SET NULL,
            INDEX idx_user (user_id),
            INDEX idx_event (event),
            INDEX idx_created (created_at),
            INDEX idx_ip (ip_address)
        )';

        $table[] = '
        CREATE TABLE '.\Modules\Core\Modul\Env::get("DB_PREFIX").'user_sessions (
            id INT(12) PRIMARY KEY AUTO_INCREMENT,
            user_id INT(12) NOT NULL,
            session_token VARCHAR(255) NOT NULL,
            ip_address VARCHAR(45) DEFAULT NULL,
            user_agent TEXT DEFAULT NULL,
            last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            expires_at TIMESTAMP DEFAULT NULL,
            FOREIGN KEY (user_id) REFERENCES '.\Modules\Core\Modul\Env::get("DB_PREFIX").'users(id) ON DELETE CASCADE,
            INDEX idx_user (user_id),
            INDEX idx_session_token (session_token)
        )';

        return $table;
    }

    public function install_Router(){
        $table = [];



        return $table;
    }

    public function install_Congif(){
        $table = [];

        return $table;
    }
    
}