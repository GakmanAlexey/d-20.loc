<?php

namespace Modules\Sysdnd\Modul\Manager;

class Source
{
    //тут все переделать
    public function showInf(){    
        if(isset($_GET["myths"])){
            $myths_id = (int)$_GET["myths"];
        }else{
            $myths_id = 1;
        }

        $mythsReposetory =  new \Modules\Systv\Modul\Repository\Myths;
        $mythsRes = $mythsReposetory->getMyth($myths_id);
        $mythsMent = $mythsRes->fetch(\PDO::FETCH_ASSOC);

        $myths = new \Modules\Systv\Modul\Entity\Myth;
        if(isset($mythsMent["id"]) and ($mythsMent["id"] >= 1)){            
            $myths->setId($mythsMent["id"])
                ->setEraId($mythsMent["era_id"])
                ->setTitle($mythsMent["title"])
                ->setSlug($mythsMent["slug"])
                ->setOrderNum($mythsMent["order_num"])
                ->setShortText($mythsMent["short_text"])
                ->setContent($mythsMent["content"])
                ->setStatus($mythsMent["status"])
                ->setCreatedAt($mythsMent["created_at"])
                ->setUpdatedAt($mythsMent["updated_at"]);
        }else{
            $myths->setId(0)
                ->setEraId(0)
                ->setTitle("")
                ->setSlug("")
                ->setOrderNum(0)
                ->setShortText("")
                ->setContent("")
                ->setStatus("")
                ->setCreatedAt("")
                ->setUpdatedAt("");

        }

        return $myths ;


    }
   
}