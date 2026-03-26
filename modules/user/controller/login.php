<?php

namespace Modules\User\Controller;

class Login extends \Modules\Abs\Controller
{
      public function login()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);
        $start = new \Modules\User\Modul\Manager\Login();
        $resultJob = $start->start();
        if($resultJob["code"] == "code_1"){
                header('Location: ' . \Modules\User\Modul\Support\Config::get("page.personalCabinet"));
                exit;
        }
        
        if($resultJob["code"] == "code_0"){
            //логика авторизации еще нет, просто показываем форму
            $this->data_view["messages"] = $resultJob ["message"]->getErrors() ?? '';
            $this->list_file[] = APP_ROOT . "/modules/user/view/login.php";
            $this->show();
            $this->cashe_end();
            return;
        }
        if($resultJob["code"] == "code_2"){            
            if($resultJob["status"]){
                header('Location: ' . \Modules\User\Modul\Support\Config::get("page.authComplete"));
                exit;
            }
        }

        $this->data_view["messages"] = $resultJob ["message"]->getErrors() ?? '';
        $this->list_file[] = APP_ROOT . "/modules/user/view/login.php";
        $this->show();
        $this->cashe_end();
    }

    public function logout()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);

        $logout = new \Modules\User\Modul\Manager\Logout;
        $logout->Out();

        $this->list_file[] = APP_ROOT . "/modules/user/view/logout.php";
        $this->show();
        $this->cashe_end();
    }

}
