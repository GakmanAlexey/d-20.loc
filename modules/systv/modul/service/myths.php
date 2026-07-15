<?php

namespace Modules\Systv\Modul\Service;

class Myths
{    
    private $statusJobCollection = false;
    private $mythscollection;
    public function __construct()
    {
        $this->mythscollection = new \Modules\Systv\Modul\Entity\Mythcollection();
    }

    public function getEraID(int $id){
        
    }

    public function getMythsCollection(){
        if($this->statusJobCollection){
            return $this->mythscollection;
        }
        $this->statusJobCollection = true;
        $repository = new \Modules\Systv\Modul\Repository\Myths;
        $repMyths = $repository->getListMythsActive();
        while($esExemplare = $repMyths->fetch(\PDO::FETCH_ASSOC)){
            $myth = new \Modules\Systv\Modul\Entity\Myth;
            $myth->setId($esExemplare["id"])
                ->setEraId($esExemplare["era_id"])
                ->setTitle($esExemplare["title"])
                ->setSlug($esExemplare["slug"])
                ->setOrderNum($esExemplare["order_num"])
                ->setShortText($esExemplare["short_text"])
                ->setContent($esExemplare["content"])
                ->setStatus($esExemplare["status"])
                ->setCreatedAt($esExemplare["created_at"])
                ->setUpdatedAt($esExemplare["updated_at"]);
            
            $this->mythscollection->add($myth);
        };
        return $this->mythscollection;
    }

}