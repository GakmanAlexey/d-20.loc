<?php
$messages = $this->data_view["messages"] ?? '';
?>
<div class="ga_user_container">
    <h1 class="ga_user_title">Смена пароля</h1>
    <div class="ga_user_messages">
        <?php if ($messages){
        echo '<div class="ga_user_error">';
        foreach ($messages as $error) {
            echo '<p>' . htmlspecialchars($error) . '</p>';
        }
        echo '</div>';
        } 
        ?>
    </div>
    <form method="post" class="ga_user_form">
            <input type="password" name="<?php echo \Modules\User\Modul\Support\Config::get("form.change.password");?>" class="ga_user_input" required>
        </label>
        <label class="ga_user_label">Новый пароль
            <input type="password" name="<?php echo \Modules\User\Modul\Support\Config::get("form.change.new_password");?>" class="ga_user_input" required>
        </label>
        <label class="ga_user_label">Повтор нового пароля
            <input type="password" name="<?php echo \Modules\User\Modul\Support\Config::get("form.change.new_password_confirm");?>" class="ga_user_input" required>
        </label>        
        <?php if (isset($_SESSION['csrf_token'])): ?>
            <input type="hidden" name="<?php echo \Modules\User\Modul\Support\Config::get("form.change.csft");?>" value="<?= $_SESSION['csrf_token'] ?>">
        <?php endif; ?>
        <div class="ga_user_actions">
            <button type="submit" name="<?php echo \Modules\User\Modul\Support\Config::get("form.change.button");?>" class="ga_user_button">Сохранить</button>
            <a class="ga_user_link" href="/user/profile/">Отмена</a>
        </div>
    </form>
</div>
