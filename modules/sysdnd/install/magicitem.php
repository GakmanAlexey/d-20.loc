<?php

namespace Modules\Sysdnd\Install;

class MagicItem  extends \Modules\Abs\Install{

    public function install_BD(){
        $table = []; 
        $table[] = '
            CREATE TABLE '.\Modules\Core\Modul\Env::get("DB_PREFIX").'dnd_magic_items (
                id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                PRIMARY KEY(id),

                name_ru VARCHAR(255) NOT NULL,
                name VARCHAR(255) NOT NULL,
                source VARCHAR(255) DEFAULT NULL,
                type VARCHAR(100) DEFAULT NULL,
                rarity VARCHAR(100) DEFAULT NULL,
                attunement TINYINT(1) NOT NULL DEFAULT 0,
                attunement_special VARCHAR(255) DEFAULT NULL,
                cost_from INT(11) UNSIGNED DEFAULT NULL,
                cost_to INT(11) UNSIGNED DEFAULT NULL,
                id_img INT(11) UNSIGNED DEFAULT NULL,
                description TEXT,
                status VARCHAR(50) DEFAULT "public",
                date_create DATETIME DEFAULT CURRENT_TIMESTAMP,
                date_update DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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