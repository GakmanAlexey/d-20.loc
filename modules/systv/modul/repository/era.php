<?php

namespace Modules\Systv\Modul\Repository;

class Era
{
    public function getListEra(){

        $pdo = \Modules\Core\Modul\Sql::connect();        
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'myth_eras';
        
        $stmt = $pdo->prepare("SELECT * FROM `{$tableName}`");        
        $stmt->execute();        
        return $stmt;

    }
}