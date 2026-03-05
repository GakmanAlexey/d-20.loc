<?php
// Register view
// Переменные доступны через $this->data_view["название"] 
// или автоматически если твой движок их извлекает
?>
<div class="ga_user_container">
    <h1 class="ga_user_title">Регистрация</h1>
    
    <!-- Блок для сообщений об ошибках -->
    <?php if (!empty($this->data_view["messages"])): ?>
        <?php echo $this->data_view["messages"]; ?>
    <?php endif; ?>
    
    <form method="post" class="ga_user_form">
        <!-- CSRF токен -->
        <input type="hidden" name="token" value="<?php echo \Modules\Core\Modul\Csrftoken::getToken(); ?>">
        <label class="ga_user_label">Логин
            <input 
                type="text" 
                name="login" 
                class="ga_user_input" 
                value="<?php echo isset($this->data_view['formData']['login']) ? htmlspecialchars($this->data_view['formData']['login']) : ''; ?>"
                required
            >
        </label>
        <label class="ga_user_label">E-mail
            <input 
                type="email" 
                name="email" 
                class="ga_user_input" 
                value="<?php echo isset($this->data_view["formData"]['email']) ? htmlspecialchars($this->data_view["formData"]['email']) : ''; ?>"
                required
            >
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

<style>
.ga_user_error {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
    padding: 10px 15px;
    border-radius: 4px;
    margin-bottom: 20px;
}
.ga_user_error p {
    margin: 5px 0;
}
</style>