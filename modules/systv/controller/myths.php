<?php

namespace Modules\Systv\Controller;

class Myths extends \Modules\Abs\Controller
{


    public function index()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);
        
        $myths = new \Modules\Systv\Modul\Service\Myths;        
        $this->data_view["mythscollection"] = $myths->getMythsCollection();

        $this->list_file[] = APP_ROOT . "/modules/systv/view/myths.php";
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
        
        $mythsManager = new \Modules\Systv\Modul\Manager\Myths;  
         $this->data_view["mythsData"]= $mythsManager->showInf(); 
        if($this->data_view["mythsData"]->getId() >= 1){
            $this->list_file[] = APP_ROOT . "/modules/systv/view/mythsopen.php";
        } else{
            $this->list_file[] = APP_ROOT . "/modules/systv/view/mythsopenemp.php";
        }   

        $this->show();
        $this->cashe_end();
    }


}
