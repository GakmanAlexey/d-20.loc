<?php

namespace Modules\User\Controller;

class Index extends \Modules\Abs\Controller
{
    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    public function login()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);

        if (isset($_SESSION['id']) && $_SESSION['id'] >= 1) {
            $this->redirect('/user/profile/');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['auth_button'])) {
            $auth = new \Modules\User\Modul\Service;
            $status = $auth->auth();
            \Modules\User\Modul\Msg::include($status, $auth->msg, $auth->type);
            if ($status) {
                $this->redirect('/user/login/success/');
            }
        }

        $this->list_file[] = APP_ROOT . "/modules/user/view/login.php";
        $this->show();
        $this->cashe_end();
    }

    public function logout()
    {
        $auth = new \Modules\User\Modul\Service;
        $auth->logout();
        $this->redirect('/');
    }

    public function register()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);

        if (isset($_SESSION['id']) && $_SESSION['id'] >= 1) {
            $e401 = new \Modules\Core\Controller\E401;
            $e401->index();
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reg_button'])) {
            $reg = new \Modules\User\Modul\Service;
            $status = $reg->register();
            \Modules\User\Modul\Msg::include($status, $reg->msg, $reg->type);
            if ($status) {
                $this->redirect('/user/register/success/');
            }
        }

        $this->list_file[] = APP_ROOT . "/modules/user/view/register.php";
        $this->show();
        $this->cashe_end();
    }

    public function register_success()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;
        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);
        $this->list_file[] = APP_ROOT . "/modules/user/view/register_success.php";
        $this->show();
        $this->cashe_end();
    }

    public function login_success()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;
        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);
        $this->list_file[] = APP_ROOT . "/modules/user/view/login_success.php";
        $this->show();
        $this->cashe_end();
    }

    public function profile()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        if (!isset($_SESSION['id']) || $_SESSION['id'] < 1) {
            $this->redirect('/user/login/');
        }

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);

        $this->list_file[] = APP_ROOT . "/modules/user/view/profile.php";
        $this->show();
        $this->cashe_end();
    }

    public function change_password()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        if (!isset($_SESSION['id']) || $_SESSION['id'] < 1) {
            $this->redirect('/user/login/');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_pass_button'])) {
            $svc = new \Modules\User\Modul\Service;
            $status = $svc->changePassword();
            \Modules\User\Modul\Msg::include($status, $svc->msg, $svc->type);
            if ($status) {
                $this->redirect('/user/profile/');
            }
        }

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);
        $this->list_file[] = APP_ROOT . "/modules/user/view/changepassword.php";
        $this->show();
        $this->cashe_end();
    }

    public function verify_id()
    {
        $svc = new \Modules\User\Modul\Service;
        $status = $svc->verification();
        if ($status) {
            $this->verify_success();
        } else {
            $this->verify_failure();
        }
    }

    public function verify_success()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;
        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);
        $this->list_file[] = APP_ROOT . "/modules/user/view/verifysuccess.php";
        $this->show();
        $this->cashe_end();
    }

    public function verify_failure()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;
        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);
        $this->list_file[] = APP_ROOT . "/modules/user/view/verifyfailure.php";
        $this->show();
        $this->cashe_end();
    }
}
