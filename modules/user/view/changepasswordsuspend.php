<?php
$messages = $this->data_view["messages"] ?? '';
?>
<div class="ga_user_container">
    <h1 class="ga_user_title">Смена пароля</h1>
    <form method="post" class="ga_user_form">
        пароль успешно изменен
        <div class="ga_user_actions">
            <button type="submit" name="<?php echo \Modules\User\Modul\Support\Config::get("form.change.button");?>" class="ga_user_button">Сохранить</button>
            <a class="ga_user_link" href="/user/profile/">В личный кабинет</a>
        </div>
    </form>
</div>
