<?php
// Login view
$messages = $this->data_view["messages"] ?? '';
$login ="";
?>
<div class="ga_user_container">
    <h1 class="ga_user_title">Вход в личный кабинет</h1>
    
    <?php if ($messages){
        echo '<div class="ga_user_error">';
        foreach ($messages as $error) {
            echo '<p>' . htmlspecialchars($error) . '</p>';
        }
        echo '</div>';
    } ?>
    <form method="post" class="ga_user_form">
        <label class="ga_user_label">Логин или E-mail
            <input 
                type="text" 
                name="username" 
                class="ga_user_input" 
                value="<?= htmlspecialchars($login) ?>"
                placeholder="Введите логин или email"
                required
            >
        </label>
        
        <label class="ga_user_label">Пароль
            <input 
                type="password" 
                name="password" 
                class="ga_user_input" 
                placeholder="Введите пароль"
                required
            >
        </label>
        <label class="ga_user_checkbox">
            <input type="checkbox" name="remember" value="1">
            Запомнить меня
        </label>
        
        <?php if (isset($_SESSION['csrf_token'])): ?>
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <?php endif; ?>
        
        <div class="ga_user_actions">
            <button type="submit" name="auth_button" class="ga_user_button">Войти</button>
            <a class="ga_user_link" href="/user/register/">Регистрация</a>
        </div>
        
        <div class="ga_user_links">
            <a class="ga_user_link" href="/user/forgot-password/">Забыли пароль?</a>
        </div>
    </form>
</div>

<style>
.ga_user_container {
    max-width: 400px;
    margin: 50px auto;
    padding: 30px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.ga_user_title {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
    font-size: 24px;
}

.ga_user_form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.ga_user_label {
    display: flex;
    flex-direction: column;
    gap: 5px;
    color: #555;
    font-size: 14px;
}

.ga_user_input {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.ga_user_input:focus {
    outline: none;
    border-color: #007bff;
}

.ga_user_actions {
    display: flex;
    gap: 15px;
    align-items: center;
    margin-top: 10px;
}

.ga_user_button {
    padding: 12px 24px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
}

.ga_user_button:hover {
    background: #0056b3;
}

.ga_user_link {
    color: #007bff;
    text-decoration: none;
    font-size: 14px;
}

.ga_user_link:hover {
    text-decoration: underline;
}

.ga_user_links {
    margin-top: 20px;
    text-align: center;
}

.ga_user_error {
    background: #f8d7da;
    color: #721c24;
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
    border: 1px solid #f5c6cb;
}

.ga_user_error p {
    margin: 5px 0;
}

.ga_user_error p:first-child {
    margin-top: 0;
}

.ga_user_error p:last-child {
    margin-bottom: 0;
}
</style>