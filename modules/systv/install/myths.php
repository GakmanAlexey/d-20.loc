<?php

namespace Modules\Systv\Install;

class Myths  extends \Modules\Abs\Install{

    public function install_BD(){
        $table = []; 
         // Эпохи мира
        $table[] = '
            CREATE TABLE '.\Modules\Core\Modul\Env::get("DB_PREFIX").'myth_eras (
                id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                PRIMARY KEY(id),
                name VARCHAR(255) NOT NULL,
                start_year INT(11) DEFAULT 0,
                end_year INT(11) DEFAULT 0,
                description TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ';      
        //Мифы
        $table[] = '
            CREATE TABLE '.\Modules\Core\Modul\Env::get("DB_PREFIX").'myths (
                id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                PRIMARY KEY(id),
                era_id INT(11) UNSIGNED DEFAULT NULL,
                title VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL,
                order_num INT(11) DEFAULT 0,
                short_text TEXT,
                content LONGTEXT,
                status VARCHAR(20) DEFAULT "draft",
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ';
        

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