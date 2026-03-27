<?php

namespace Modules\User\Controller;

class Services extends \Modules\Abs\Controller
{
    public function passwordChange()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);

        $service = new \Modules\User\Modul\Manager\Service();
        $resultJob = $service->changePassword();

        if($resultJob["code"] == "code_0"){
            //Пользователь неавторизован
            header('Location: ' . \Modules\User\Modul\Support\Config::get("page.personalCabinet"));
            exit;
        }elseif($resultJob["code"] == "code_1"){
            //Показывает форму
            $this->data_view["messages"] = $resultJob ["message"]->getErrors() ?? '';
            $this->list_file[] = APP_ROOT . "/modules/user/view/changepassword.php";
            $this->show();
            $this->cashe_end();
            return;
        }else{    
            //Успешная смена пароля        
            $this->data_view["messages"] = $resultJob ["message"]->getErrors() ?? '';
            $this->list_file[] = APP_ROOT . "/modules/user/view/changepasswordsuspend.php";
            $this->show();
            $this->cashe_end();
            return;
        }      
    }
}
