<?php

namespace Modules\User\Controller;

class Register extends \Modules\Abs\Controller
{
    public function register()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);

        $start = new \Modules\User\Modul\Manager\Register();
        $resultJob = $start->start();
        
        $this->list_file[] = APP_ROOT . "/modules/user/view/register.php";
        $this->show();
        $this->cashe_end();
    }

    public function back()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);

        $this->list_file[] = APP_ROOT . "/modules/user/view/logout.php";
        $this->show();
        $this->cashe_end();
    }

}
