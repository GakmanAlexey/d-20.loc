<?php
// Profile view (placeholder - данные подставляются сервисом)
?>
<div class="ga_user_container">
    <h1 class="ga_user_title">Мой профиль</h1>
    <div class="ga_user_profile">
        <p class="ga_user_field"><strong>Имя:</strong> <?php echo isset($user['name'])?htmlspecialchars($user['name']):'—'; ?></p>
        <p class="ga_user_field"><strong>E-mail:</strong> <?php echo isset($user['email'])?htmlspecialchars($user['email']):'—'; ?></p>
    </div>
    <div class="ga_user_actions">
        <a class="ga_user_button ga_user_button_secondary" href="/user/change-password/">Сменить пароль</a>
        <a class="ga_user_button ga_user_button_secondary" href="/user/logout/">Выйти</a>
    </div>
</div>
