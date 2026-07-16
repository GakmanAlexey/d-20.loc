<?php

namespace Modules\Sysdnd\Modul\Repository;

class Source
{
    public function getListSource(){

        $pdo = \Modules\Core\Modul\Sql::connect();        
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'dnd_sources';
        
        $stmt = $pdo->prepare("SELECT * FROM `{$tableName}`");        
        $stmt->execute();        
        return $stmt;

    }

    public function getSource($sourceID){

        $pdo = \Modules\Core\Modul\Sql::connect();        
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'dnd_sources';
        
        $stmt = $pdo->prepare("SELECT * FROM `{$tableName}` WHERE `id` = :sourceID");  
        
        $stmt->bindValue(':sourceID', $sourceID, \PDO::PARAM_INT);
        $stmt->execute();         
        return $stmt;

    }


}