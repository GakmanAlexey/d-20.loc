<?php

namespace Modules\Sysdnd\Install;

class Source  extends \Modules\Abs\Install{

    public function install_BD(){
        $table = []; 
        $table[] = '
            CREATE TABLE '.\Modules\Core\Modul\Env::get("DB_PREFIX").'dnd_sources (
                id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                PRIMARY KEY(id),
                name_ru VARCHAR(255) NOT NULL,
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL,
                micro_label VARCHAR(255) DEFAULT NULL,
                description TEXT,
                status VARCHAR(50) DEFAULT "public",
                id_img INT(11) UNSIGNED DEFAULT NULL,
                date_publisher DATE DEFAULT NULL,
                studio VARCHAR(255) DEFAULT NULL,
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