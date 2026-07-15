<?php

namespace Modules\Systv\Modul\Manager;

class Era
{
    public function showInf(){    
        if(isset($_GET["era"])){
            $era_id = (int)$_GET["era"];
        }else{
            $era_id = 1;
        }

        $eraReposetory =  new \Modules\Systv\Modul\Repository\Era;
        $eraRes = $eraReposetory->getEra($era_id);
        $eraMent = $eraRes->fetch(\PDO::FETCH_ASSOC);

        $era = new \Modules\Systv\Modul\Entity\Era;
        if(isset($eraMent["id"]) and ($eraMent["id"] >= 1)){
        $era->setId($eraMent["id"])
            ->setName($eraMent["name"])
            ->setStartYear($eraMent["start_year"])
            ->setEndYear($eraMent["end_year"])
            ->setDescription($eraMent["description"])
            ->setCreatedAt($eraMent["created_at"]);
        }else{
        $era->setId(0)
            ->setName("")
            ->setStartYear(0)
            ->setEndYear(0)
            ->setDescription("")
            ->setCreatedAt("");

        }

        return $era ;


    }
   
}