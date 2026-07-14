<?php

namespace Modules\Systv\Install;

class Nexus  extends \Modules\Abs\Install{

    public function install_BD(){
        $table = [];       
        
        $table[] = '
            INSERT IGNORE INTO '.\Modules\Core\Modul\Env::get("DB_PREFIX").'nexus_base 
            (name_ru, barcode, name_system, url, is_active, id_img) 
            VALUES 
            ("Таверна Миров", "systv", "system_name", "systv", TRUE, NULL)
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