<?php

namespace Modules\Systv\Modul\Service;

class Era
{    
    private $statusJobCollection = false;
    private $eracollection;
    public function __construct()
    {
        $this->eracollection = new \Modules\Systv\Modul\Entity\Eracollection();
    }

    public function getEraID(int $id){
        
    }

    public function getEraCollection(){
        if($this->statusJobCollection){
            return $this->eracollection;
        }
        $this->statusJobCollection = true;
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
            
            $this->eracollection->add($era);
        };
        return $this->eracollection;
    }

}