<?php
// Profile view (после успешного входа)
?>
<div class="ga_user_container">
    <h1 class="ga_user_title">Личный кабинет</h1>
    
    <div class="ga_user_success">
        <p>Вы успешно авторизовались!</p>
    </div>
    
    <div class="ga_user_info">
        <p>Добро пожаловать в личный кабинет.</p>
    </div>
    
    <div class="ga_user_actions">
        <a href="/user/logout/" class="ga_user_button ga_user_button_secondary">Выйти</a>
    </div>
</div>

<style>
.ga_user_success {
    background: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
    border: 1px solid #c3e6cb;
}

.ga_user_info {
    background: #e2e3e5;
    color: #383d41;
    padding: 20px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.ga_user_button_secondary {
    background: #6c757d;
}

.ga_user_button_secondary:hover {
    background: #545b62;
}
</style>