<?php

namespace Modules\Core\Controller;

class E500 extends \Modules\Abs\Controller{

    public function index(array $context = []){  

        $this->data["error_msg"] = $context;

        \Modules\Core\Modul\Head::load();
        \Modules\Core\Modul\Resource::load_conf('errors');

        $this->type_show = "errors";
        $this->list_file[] = APP_ROOT."/modules/core/view/e500.php";

        $this->show();
    }
}
