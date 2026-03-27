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
        if($resultJob["code"] == "code_1"){
                header('Location: ' . \Modules\User\Modul\Support\Config::get("page.personalCabinet"));
                exit;
        }elseif($resultJob["code"] == "code_2"){
            $this->data_view["messages"] = $resultJob ["message"]->getErrors() ?? '';
            $this->list_file[] = APP_ROOT . "/modules/user/view/register.php";
            $this->show();
            $this->cashe_end();
        }elseif($resultJob["code"] == "code_3"){
            //регистрация прошла успешно            
            $this->data_view["messages"] = $resultJob ["message"]->getErrors() ?? '';
            $this->list_file[] = APP_ROOT . "/modules/user/view/register_success.php";
            $this->show();
            $this->cashe_end();
        }else{
            $this->data_view["messages"] = $resultJob ["message"]->getErrors() ?? '';
            $this->list_file[] = APP_ROOT . "/modules/user/view/register.php";
            $this->show();
            $this->cashe_end();
        }

    }

    public function emailConfirm()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);

        $start = new \Modules\User\Modul\Manager\Register();
        $resultJob = $start->confirmEmail();
        if($resultJob["status"]){
            $this->list_file[] = APP_ROOT . "/modules/user/view/register_success_mailsend.php";
        }else{
            $this->list_file[] = APP_ROOT . "/modules/user/view/register_success_mailsend_error.php";
        }
        $this->show();
        $this->cashe_end();
    }

}
