<?php

namespace Modules\Sysdnd\Modul\Service;

class Source
{    
    private $statusJobCollection = false;
    private $sourceCollection;
    public function __construct()
    {
        $this->sourceCollection = new \Modules\Sysdnd\Modul\Entity\Sourcecollection();
    }

    public function getSourceID(int $id){
        
    }

    public function getSourceCollection(){
        if($this->statusJobCollection){
            return $this->sourceCollection;
        }
        $this->statusJobCollection = true;
        $repository = new \Modules\Sysdnd\Modul\Repository\Source;
        $repSource = $repository->getListSource();
        while($esExemplare = $repSource->fetch(\PDO::FETCH_ASSOC)){
            $source = new \Modules\Sysdnd\Modul\Entity\Source;
            $source->setId($esExemplare["id"])
                ->setNameRu($esExemplare["name_ru"])
                ->setName($esExemplare["name"])
                ->setSlug($esExemplare["slug"])
                ->setMicroLabel($esExemplare["micro_label"])
                ->setDescription($esExemplare["description"])
                ->setStatus($esExemplare["status"])
                ->setIdIMG($esExemplare["id_img"])
                ->setDatePublisher($esExemplare["date_publisher"])
                ->setStudio($esExemplare["studio"])
                ->setDateCreate($esExemplare["date_create"])
                ->setDateUpdate($esExemplare["date_update"]);
            
            $this->sourceCollection->add($source);
        };
        return $this->sourceCollection;
    }

}