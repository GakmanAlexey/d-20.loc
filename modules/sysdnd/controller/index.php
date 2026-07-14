<?php

namespace Modules\Sysdnd\Controller;

class Index extends \Modules\Abs\Controller
{


    public function Nexus()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);

        //тут обработка

        $this->list_file[] = APP_ROOT . "/modules/sysdnd/view/index.php";
        $this->show();
        $this->cashe_end();
    }

}
