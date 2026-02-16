<?php
// Register view
?>
<div class="ga_user_container">
    <h1 class="ga_user_title">Регистрация</h1>
    <div class="ga_user_messages"><?php if(isset($messages)) echo $messages; ?></div>
    <form method="post" class="ga_user_form">
        <label class="ga_user_label">E-mail
            <input type="email" name="email" class="ga_user_input" required>
        </label>
        <label class="ga_user_label">Пароль
            <input type="password" name="password" class="ga_user_input" required>
        </label>
        <label class="ga_user_label">Повтор пароля
            <input type="password" name="password_confirm" class="ga_user_input" required>
        </label>
        <div class="ga_user_actions">
            <button type="submit" name="reg_button" class="ga_user_button">Зарегистрироваться</button>
            <a class="ga_user_link" href="/user/login/">Войти</a>
        </div>
    </form>
</div>
