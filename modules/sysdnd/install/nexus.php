<?php

namespace Modules\Sysdnd\Install;

class Nexus  extends \Modules\Abs\Install{

    public function install_BD(){
        $table = [];

        $table[] = '
            INSERT IGNORE INTO '.\Modules\Core\Modul\Env::get("DB_PREFIX").'nexus_base 
            (name_ru, barcode, name_system, url, is_active, id_img) 
            VALUES 
            ("Подземелье и драконы", "sysdnd", "sysdnd5e", "sysdnd", TRUE, NULL)
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