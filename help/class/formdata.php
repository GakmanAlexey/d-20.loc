<?php
$classData = [
    'title' => 'Formdata - Контейнер данных формы и сообщений валидации',
    'description' => 'Класс Formdata предназначен для хранения, передачи и обработки данных форм. Используется как DTO (Data Transfer Object) между контроллерами и валидаторами. Также содержит механизм накопления сообщений об ошибках и общий статус валидации.',
    
    'class_info' => [
        'namespace' => 'Modules\\User\\Modul',
        'pattern' => 'DTO (Data Transfer Object)',
        'file' => 'formdata.php'
    ],
    
    'properties' => [
        [
            'name' => '$login',
            'type' => 'private ?string',
            'description' => 'Логин пользователя',
            'default' => 'null'
        ],
        [
            'name' => '$email',
            'type' => 'private ?string',
            'description' => 'Email пользователя',
            'default' => 'null'
        ],
        [
            'name' => '$password',
            'type' => 'private ?string',
            'description' => 'Пароль пользователя',
            'default' => 'null'
        ],
        [
            'name' => '$password_confirm',
            'type' => 'private ?string',
            'description' => 'Подтверждение пароля',
            'default' => 'null'
        ],
        [
            'name' => '$token',
            'type' => 'private ?string',
            'description' => 'CSRF токен',
            'default' => 'null'
        ],
        [
            'name' => '$status',
            'type' => 'private bool',
            'description' => 'Общий статус валидации формы',
            'default' => 'false'
        ],
        [
            'name' => '$msg',
            'type' => 'private array',
            'description' => 'Массив сообщений об ошибках',
            'default' => '[]'
        ]
    ],
    
    'methods' => [
        [
            'name' => 'setFromArray()',
            'type' => 'public',
            'return' => 'self',
            'description' => 'Заполняет объект данными из массива',
            'parameters' => [
                'data' => 'Ассоциативный массив с данными формы'
            ],
            'example' => '$form->setFromArray($_POST);'
        ],
        [
            'name' => 'setFromForma()',
            'type' => 'public',
            'return' => 'self',
            'description' => 'Заполняет объект напрямую из массива $_POST',
            'example' => '$form->setFromForma();'
        ],
        [
            'name' => 'addMsg()',
            'type' => 'public',
            'return' => 'self',
            'description' => 'Добавляет сообщение об ошибке',
            'parameters' => [
                'message' => 'Текст сообщения'
            ],
            'example' => '$form->addMsg("Ошибка заполнения формы");'
        ],
        [
            'name' => 'getMsg()',
            'type' => 'public',
            'return' => 'array',
            'description' => 'Возвращает список сообщений об ошибках'
        ]
    ],
    
    'examples' => [
        [
            'title' => 'Базовое использование',
            'code' => '$form = (new Formdata())->setFromForma();

if (!$validator->validateRegister($form)) {
    return $form->getMsg();
}'
        ]
    ],
    
    'notes' => [
        'Используется как единый контейнер данных формы',
        'Позволяет избежать работы с $_POST напрямую в логике приложения',
        'Упрощает тестирование и отладку',
        'Позволяет централизованно накапливать ошибки'
    ],
    
    'best_practices' => [
        'Никогда не использовать $_POST напрямую в бизнес-логике',
        'Передавать Formdata между слоями приложения',
        'Использовать методы get/set вместо прямого доступа к свойствам'
    ]
];
?>