<?php

namespace Modules\Sysdnd\Controller;

class Source extends \Modules\Abs\Controller
{
    public function Main()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);

        
        $sourceCollection = new \Modules\Sysdnd\Modul\Service\Source;        
        $this->data_view["sourceCollection"] = $sourceCollection->getSourceCollection();

        $this->list_file[] = APP_ROOT . "/modules/sysdnd/view/source.php";
        $this->show();
        $this->cashe_end();
    }

    public function Open()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);

        $sourceManager = new \Modules\Sysdnd\Modul\Manager\Source;  
         $this->data_view["sourceData"]= $sourceManager->showInf(); 
        if($this->data_view["sourceData"]->getId() >= 1){
            $this->list_file[] = APP_ROOT . "/modules/sysdnd/view/sourceopen.php";
        } else{
            $this->list_file[] = APP_ROOT . "/modules/sysdnd/view/sourceopenemp.php";
        }   

        $this->show();
        $this->cashe_end();
    }

}
