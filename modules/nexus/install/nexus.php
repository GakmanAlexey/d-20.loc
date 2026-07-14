<?php

namespace Modules\Nexus\Install;

class Nexus  extends \Modules\Abs\Install{

    public function install_BD(){
        $table = [];
        
        $table[] = '
            CREATE TABLE '.\Modules\Core\Modul\Env::get("DB_PREFIX").'nexus_base (
            id INT(12) PRIMARY KEY AUTO_INCREMENT,
            name_ru VARCHAR(50) UNIQUE NOT NULL, 
            barcode VARCHAR(50) UNIQUE NOT NULL,
            name_system VARCHAR(100) NOT NULL,          
            url VARCHAR(255) NOT NULL,
            is_active BOOLEAN DEFAULT TRUE,          
            id_img INT(12),           
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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