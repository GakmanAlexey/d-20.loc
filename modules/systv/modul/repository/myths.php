<?php

namespace Modules\Systv\Modul\Repository;

class Myths
{
    public function getListMyths(){

        $pdo = \Modules\Core\Modul\Sql::connect();
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'myths';

        $stmt = $pdo->prepare("SELECT * FROM `{$tableName}`");
        $stmt->execute();

        return $stmt;
    }


    public function getListMythsActive(){

        $pdo = \Modules\Core\Modul\Sql::connect();
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'myths';

        $stmt = $pdo->prepare("SELECT * FROM `{$tableName}` WHERE `status` = 'public'");
        $stmt->execute();

        return $stmt;
    }


    public function getListMythsActiveEra(int $eraID){

        $pdo = \Modules\Core\Modul\Sql::connect();
        $tableName = \Modules\Core\Modul\Env::get("DB_PREFIX") . 'myths';

        $stmt = $pdo->prepare("
            SELECT * 
            FROM `{$tableName}` 
            WHERE `status` = 'public' 
            AND `era_id` = :eraid
        ");

        $stmt->bindValue(':eraid', $eraID, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }
}