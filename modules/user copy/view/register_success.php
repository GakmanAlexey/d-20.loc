<?php
// Register success view
?>
<div class="ga_user_container">
    <h1 class="ga_user_title">Регистрация завершена!</h1>
    
    <div class="ga_user_success">
        <div class="ga_user_success_icon">✓</div>
        <p class="ga_user_success_message">
            Спасибо за регистрацию!<br>
            На указанный email отправлено письмо с подтверждением.<br>
            Пожалуйста, перейдите по ссылке в письме для активации аккаунта.
        </p>
        <div class="ga_user_success_note">
            <p>📧 Проверьте папку "Спам", если письмо не приходит в течение 5 минут.</p>
        </div>
        <a href="/user/login/" class="ga_user_button ga_user_button_success">Перейти к входу</a>
    </div>
</div>

<style>
.ga_user_success {
    text-align: center;
    padding: 30px 20px;
    background: #f8f9fa;
    border-radius: 8px;
    margin: 20px 0;
}

.ga_user_success_icon {
    font-size: 64px;
    color: #28a745;
    margin-bottom: 20px;
    line-height: 1;
}

.ga_user_success_message {
    font-size: 18px;
    color: #333;
    margin-bottom: 20px;
    line-height: 1.6;
}

.ga_user_success_note {
    background: #fff3cd;
    border: 1px solid #ffeeba;
    color: #856404;
    padding: 15px;
    border-radius: 4px;
    margin: 20px 0;
    font-size: 14px;
}

.ga_user_button_success {
    display: inline-block;
    background: #28a745;
    color: white;
    text-decoration: none;
    padding: 12px 30px;
    border-radius: 4px;
    font-weight: bold;
    transition: background 0.3s;
}

.ga_user_button_success:hover {
    background: #218838;
}
</style>