<div class="ga_user_container">
    <h1 class="ga_user_title">Смена пароля</h1>
    <div class="ga_user_messages"><?php if(isset($messages)) echo $messages; ?></div>
    <form method="post" class="ga_user_form">
        <label class="ga_user_label">Текущий пароль
            <input type="password" name="current_password" class="ga_user_input" required>
        </label>
        <label class="ga_user_label">Новый пароль
            <input type="password" name="new_password" class="ga_user_input" required>
        </label>
        <label class="ga_user_label">Повтор нового пароля
            <input type="password" name="new_password_confirm" class="ga_user_input" required>
        </label>
        <div class="ga_user_actions">
            <button type="submit" name="change_pass_button" class="ga_user_button">Сохранить</button>
            <a class="ga_user_link" href="/user/profile/">Отмена</a>
        </div>
    </form>
</div>
