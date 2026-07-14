<?php

namespace Modules\Systv\Install;

class Region  extends \Modules\Abs\Install{

    public function install_BD(){
        $table = []; 
         // Эпохи мира
        $table[] = '
            CREATE TABLE '.\Modules\Core\Modul\Env::get("DB_PREFIX").'regions (
                id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                PRIMARY KEY(id),

                title VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL,

                short_text TEXT,
                content LONGTEXT,

                order_num INT(11) DEFAULT 0,

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