<?php
namespace Modules\Systv\Modul\Support;

class Era
// \Modules\Systv\Modul\Support\Era::loadAllEra();
{
    public static $isLoad = false;
    public static $eraCollection;
    public static function getNameFromId(int $idEra){
        if(!self::$isLoad){self::loadAllEra();}
        $findEra = self::$eraCollection->findById($idEra);
        if($findEra == NULL){return "Эра не найдена";}
        return $findEra->getName();
        
        
    }
    public static function startCollection(){
        $repository = new \Modules\Systv\Modul\Repository\Era;
        $repEra = $repository->getListEra();
        while($esExemplare = $repEra->fetch(\PDO::FETCH_ASSOC)){
            $era = new \Modules\Systv\Modul\Entity\Era;
            $era->setId($esExemplare["id"])
                ->setName($esExemplare["name"])
                ->setStartYear($esExemplare["start_year"])
                ->setEndYear($esExemplare["end_year"])
                ->setDescription($esExemplare["description"])
                ->setCreatedAt($esExemplare["created_at"]);
            
            self::$eraCollection->add($era);
        };
        return self::$eraCollection;

    }
    public static function loadAllEra(){
        self::$eraCollection = new \Modules\Systv\Modul\Entity\Eracollection;
        self::startCollection();

    }
}
