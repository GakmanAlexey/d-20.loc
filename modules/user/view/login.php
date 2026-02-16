<?php
// Login view
?>
<div class="ga_user_container">
    <h1 class="ga_user_title">Вход в личный кабинет</h1>
    <div class="ga_user_messages"><?php if(isset($messages)) echo $messages; ?></div>
    <form method="post" class="ga_user_form">
        <label class="ga_user_label">E-mail
            <input type="email" name="email" class="ga_user_input" required>
        </label>
        <label class="ga_user_label">Пароль
            <input type="password" name="password" class="ga_user_input" required>
        </label>
        <div class="ga_user_actions">
            <button type="submit" name="auth_button" class="ga_user_button">Войти</button>
            <a class="ga_user_link" href="/user/register/">Регистрация</a>
        </div>
    </form>
</div>
