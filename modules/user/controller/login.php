<?php

namespace Modules\User\Controller;

class Index extends \Modules\Abs\Controller
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
           //тут надо будет добавить ошибку 401
        }
        
        if($resultJob["code"] == "code_0"){
            //логика авторизации еще нет, просто показываем форму
            $massages = new \Modules\User\Modul\Support\Massager;
            $this->data_view["messages"] = $massages->getErrors();
            $this->list_file[] = APP_ROOT . "/modules/user/view/login.php";
            $this->show();
            $this->cashe_end();
        }
        

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

}
