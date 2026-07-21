<?php

namespace Modules\Sysdnd\Modul\Manager;

class Source
{
    //тут все переделать
    public function showInf(){    
        if(isset($_GET["source"])){
            $source_id = (int)$_GET["source"];
        }else{
            $source_id = 1;
        }

        $sourceReposetory =  new \Modules\Sysdnd\Modul\Repository\Source;
        $sourceRes = $sourceReposetory->getSource($source_id);
        $sourceMent = $sourceRes->fetch(\PDO::FETCH_ASSOC);

        $source = new \Modules\Sysdnd\Modul\Entity\Source;
        if(isset($sourceMent["id"]) and ($sourceMent["id"] >= 1)){            
            $source->setId($sourceMent["id"])
                ->setNameRu($sourceMent["name_ru"])
                ->setName($sourceMent["name"])
                ->setSlug($sourceMent["slug"])
                ->setMicroLabel($sourceMent["micro_label"])
                ->setDescription($sourceMent["description"])
                ->setStatus($sourceMent["status"])
                ->setIdIMG($sourceMent["id_img"])
                ->setDatePublisher($sourceMent["date_publisher"])
                ->setStudio($sourceMent["studio"])
                ->setDateCreate($sourceMent["date_create"])
                ->setDateUpdate($sourceMent["date_update"]);
        }else{
             $source->setId(0)
                ->setNameRu("")
                ->setName("")
                ->setSlug("")
                ->setMicroLabel("")
                ->setDescription("")
                ->setStatus("")
                ->setIdIMG(0)
                ->setDatePublisher("")
                ->setStudio("")
                ->setDateCreate("")
                ->setDateUpdate("");

        }

        return $source ;


    }
   
}