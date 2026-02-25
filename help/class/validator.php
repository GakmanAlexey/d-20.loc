<?php
$classData = [
    'title' => 'Validator - Централизованная система валидации пользовательских форм',
    'description' => 'Класс Validator предназначен для проверки корректности данных, полученных от пользователя. Реализует набор атомарных и групповых валидаторов, поддерживает многоязычные сообщения об ошибках и интеграцию с БД.',
    
    'class_info' => [
        'namespace' => 'Modules\\User\\Modul',
        'pattern' => 'Service + Strategy',
        'file' => 'validator.php'
    ],
    
    'properties' => [
        [
            'name' => '$config',
            'type' => 'private array',
            'description' => 'Конфигурация лимитов из config.json',
            'default' => '[]'
        ],
        [
            'name' => '$lang',
            'type' => 'private array',
            'description' => 'Массив локализованных сообщений',
            'default' => '[]'
        ]
    ],
    
    'methods' => [
        [
            'name' => 'validateLogin()',
            'type' => 'public',
            'return' => 'bool',
            'description' => 'Проверяет логин: обязательность, длину, уникальность'
        ],
        [
            'name' => 'validateEmail()',
            'type' => 'public',
            'return' => 'bool',
            'description' => 'Проверяет email: обязательность, формат'
        ],
        [
            'name' => 'validatePassword()',
            'type' => 'public',
            'return' => 'bool',
            'description' => 'Проверяет пароль: обязательность, длину'
        ],
        [
            'name' => 'validatePasswordConfirm()',
            'type' => 'public',
            'return' => 'bool',
            'description' => 'Проверяет совпадение паролей'
        ],
        [
            'name' => 'validateCsrf()',
            'type' => 'public',
            'return' => 'bool',
            'description' => 'Проверяет CSRF токен'
        ],
        [
            'name' => 'validateAuth()',
            'type' => 'public',
            'return' => 'bool',
            'description' => 'Групповая проверка формы авторизации'
        ],
        [
            'name' => 'validateRegister()',
            'type' => 'public',
            'return' => 'bool',
            'description' => 'Групповая проверка формы регистрации'
        ]
    ],
    
    'examples' => [
        [
            'title' => 'Проверка регистрации',
            'code' => '$form = (new Formdata())->setFromForma();
$validator = new Validator();

if (!$validator->validateRegister($form)) {
    return $form->getMsg();
}'
        ]
    ],
    
    'notes' => [
        'Поддерживает раннее прерывание (fail-fast)',
        'Использует конфигурацию лимитов',
        'Работает с локализацией сообщений',
        'Поддерживает безопасную проверку уникальности логина через PDO'
    ],
    
    'best_practices' => [
        'Разделять атомарные и групповые валидаторы',
        'Не смешивать валидацию с бизнес-логикой',
        'Все сообщения получать из языковых файлов',
        'Использовать early-return для повышения читаемости'
    ],
    
    'dependencies' => [
        'Env' => 'Получение языка и префикса таблиц',
        'Sql' => 'Подключение к БД',
        'Csrftoken' => 'Проверка CSRF защиты',
        'Formdata' => 'Контейнер данных формы'
    ]
];
?>