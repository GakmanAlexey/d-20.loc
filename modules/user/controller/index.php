<?php

namespace Modules\User\Controller;

class Index extends \Modules\Abs\Controller
{
    public string $messages = '';

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

        // Инициализируем переменные для представления
        $messages = '';
        $errors = [];
        $formData = [];
        $success = false;
        // Обработка POST-запроса
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['auth_button'])) {
            
            // Создаем объект Formdata из POST данных
            $form = new \Modules\User\Modul\Formdata();
            $form->setFromForma();
            // Сохраняем введенный логин для отображения в форме
            $formData = [
                'login' => $form->getLogin()
            ];
            // Создаем экземпляр Login и пробуем авторизоваться
            $login = new \Modules\User\Modul\Login();
            $result = $login->authUser($form);
            
            if ($result["status"]) {
                // Успешная авторизация - редирект в личный кабинет
                header('Location: /user/profile/');
                exit;
            } else {
                // Ошибки авторизации
                $errors = $result["msg"];
                // Формируем сообщение об ошибках
                $messages = '<div class="ga_user_error">';
                foreach ($errors as $error) {
                    $messages .= '<p>' . htmlspecialchars($error) . '</p>';
                }
                $messages .= '</div>';
            }
        }

        // Передаем переменные в представление
        $this->data_view["messages"] = $messages;
        $this->data_view["errors"] = $errors;
        $this->data_view["formData"] = $formData;
        
        $this->list_file[] = APP_ROOT . "/modules/user/view/login.php";
        $this->show();
        $this->cashe_end();
    }

    public function logout()
    {
        // Запускаем сессию
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Очищаем сессию
        $_SESSION = array();
        
        // Уничтожаем куки сессии
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Уничтожаем сессию
        session_destroy();
        
        // Редирект на главную или страницу входа
        header('Location: /user/login/');
        exit;
    }

   public function register()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;

        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);

        // Инициализируем переменные для представления
        $messages = '';
        $errors = [];
        $formData = [];
        $success = false;

        // Обработка POST-запроса
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reg_button'])) {
            
            // Запускаем сессию для CSRF если еще не запущена
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            // Создаем объект Formdata из POST данных
            $form = new \Modules\User\Modul\Formdata();
            $form->setFromForma();
            
            // Сохраняем введенные данные для отображения в форме
            $formData = [
                'email' => $form->getEmail()
            ];
            
            // Создаем регистратор и пробуем зарегистрировать
            $register = new \Modules\User\Modul\Register();
            $result = $register->registerUser($form);
            
            if ($result["status"]) {
                // Успешная регистрация
                $success = true;
                // Показываем страницу успеха вместо формы
                $this->list_file[] = APP_ROOT . "/modules/user/view/register_success.php";
            } else {
                // Ошибки валидации
                $errors = $result["msg"];
                // Формируем сообщение об ошибках
                $messages = '<div class="ga_user_error">';
                foreach ($errors as $error) {
                    $messages .= '<p>' . htmlspecialchars($error) . '</p>';
                }
                $messages .= '</div>';
                // Показываем форму снова
                $this->list_file[] = APP_ROOT . "/modules/user/view/register.php";
            }
        } else {
            // Просто показываем форму
            $this->list_file[] = APP_ROOT . "/modules/user/view/register.php";
        }

        // ===== ВАЖНО: Передаем переменные через data_view =====
        $this->data_view["messages"] = $messages;
        $this->data_view["errors"] = $errors;
        $this->data_view["formData"] = $formData;
        $this->data_view["success"] = $success;
        
        // ИЛИ можно так, если хочешь короче:
        // $this->data_view = array_merge($this->data_view, compact('messages', 'errors', 'formData', 'success'));

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

    
    public function register_success()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;
        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);
        $this->list_file[] = APP_ROOT . "/modules/user/view/register_success_mailsend.php";
        $this->show();
        $this->cashe_end();
    }

    public function profile()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;



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

    

    public function password_recovery()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;
        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);
        $this->list_file[] = APP_ROOT . "/modules/user/view/passwordrecovery.php";
        $this->show();
        $this->cashe_end();
    } 

    public function password_recovery_2step()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;
        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);
        $this->list_file[] = APP_ROOT . "/modules/user/view/passwordrecovery2step.php";
        $this->show();
        $this->cashe_end();
    }

    public function password_recovery_success()
    {
        $this->cashe_start();
        if ($this->cache_isset) return;
        \Modules\Core\Modul\Head::load();
        $this->type_show = "default";
        \Modules\Core\Modul\Resource::load_conf($this->type_show);
        $this->list_file[] = APP_ROOT . "/modules/user/view/passwordrecoverysuccess.php";
        $this->show();
        $this->cashe_end();
    }
}
