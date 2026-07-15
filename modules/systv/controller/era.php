<?php

namespace Modules\Systv\Controller;

class Era extends \Modules\Abs\Controller
{


    public function index()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);
        
        $er = new \Modules\Systv\Modul\Service\Era;        
        $this->data_view["eracollection"] = $er->getEraCollection();

        $this->list_file[] = APP_ROOT . "/modules/systv/view/era.php";
        $this->show();
        $this->cashe_end();
    }

    public function open()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);
        
        $eraManager = new \Modules\Systv\Modul\Manager\Era;  
         $this->data_view["eraData"]= $eraManager->showInf(); 
        if($this->data_view["eraData"]->getId() >= 1){
            $this->list_file[] = APP_ROOT . "/modules/systv/view/eraopen.php";
        } else{
            $this->list_file[] = APP_ROOT . "/modules/systv/view/eraopenemp.php";
        }   

        $this->show();
        $this->cashe_end();
    }

}
