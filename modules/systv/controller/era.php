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

}
