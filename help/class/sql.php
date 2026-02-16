<?php
$classData = [
    'title' => 'SQL - PDO обертка для работы с БД',
    'description' => 'Класс Sql расширяет PDO и реализует паттерн Singleton для подключения к базе данных MySQL. Обеспечивает единое подключение к БД с логированием запросов в режиме отладки.',
    
    'class_info' => [
        'namespace' => 'Modules\\Core\\Modul',
        'extends' => '\\PDO',
        'pattern' => 'Singleton'
    ],
    
    'properties' => [
        [
            'name' => '$instance',
            'type' => 'private static',
            'description' => 'Хранит единственный экземпляр класса (Singleton)',
            'default' => 'null'
        ]
    ],
    
    'methods' => [
        [
            'name' => 'connect()',
            'type' => 'public static',
            'return' => '\\PDO',
            'description' => 'Статический метод для получения подключения к БД. Реализует паттерн Singleton.',
            'example' => '$pdo = Sql::connect();'
        ],
        [
            'name' => '__construct()',
            'type' => 'private',
            'return' => 'void',
            'description' => 'Приватный конструктор для предотвращения прямого создания экземпляров. Устанавливает соединение с БД используя параметры из Env класса.',
            'example' => '// Нельзя вызвать напрямую new Sql()',
            'env_vars' => [
                'DB_HOST' => 'Хост БД (по умолчанию localhost)',
                'DB_PORT' => 'Порт БД (по умолчанию 3306)',
                'DB_DATABASE' => 'Имя базы данных (обязательно)',
                'DB_USERNAME' => 'Имя пользователя (обязательно)',
                'DB_PASSWORD' => 'Пароль',
                'DB_CHARSET' => 'Кодировка (по умолчанию utf8mb4)'
            ]
        ],
        [
            'name' => 'prepare()',
            'type' => 'public',
            'return' => 'PDOStatement',
            'description' => 'Переопределяет метод PDO::prepare(). В режиме отладки логирует SQL запросы.',
            'example' => '$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");',
            'debug' => 'При APP_DEBUG=true логирует запрос через Logs класс'
        ],
        [
            'name' => '__clone()',
            'type' => 'private',
            'return' => 'void',
            'description' => 'Приватный метод для предотвращения клонирования экземпляра (часть Singleton)',
            'example' => ''
        ],
        [
            'name' => '__wakeup()',
            'type' => 'public',
            'return' => 'void',
            'description' => 'Предотвращает десериализацию экземпляра (часть Singleton)',
            'example' => ''
        ]
    ],
    
    'examples' => [
        [
            'title' => 'Базовое использование',
            'code' => '// Получение подключения
$pdo = Sql::connect();

// Простой запрос
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();

// Подготовленный запрос
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([1]);
$user = $stmt->fetch();'
        ],
        [
            'title' => 'Вставка данных',
            'code' => '$pdo = Sql::connect();

$sql = "INSERT INTO users (name, email) VALUES (:name, :email)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ":name" => "Иван Петров",
    ":email" => "ivan@example.com"
]);

$newId = $pdo->lastInsertId();'
        ],
        [
            'title' => 'Транзакции',
            'code' => '$pdo = Sql::connect();

try {
    $pdo->beginTransaction();
    
    $pdo->exec("UPDATE accounts SET balance = balance - 100 WHERE id = 1");
    $pdo->exec("UPDATE accounts SET balance = balance + 100 WHERE id = 2");
    
    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Ошибка: " . $e->getMessage();
}'
        ],
        [
            'title' => 'Использование с Logs',
            'code' => '// При включенном режиме отладки (APP_DEBUG=true)
// Все SQL запросы автоматически логируются:

$pdo = Sql::connect();
$stmt = $pdo->prepare("SELECT * FROM products WHERE price > ?");
$stmt->execute([1000]);

// В логах появится запись:
// "SQL: SELECT * FROM products WHERE price > ?"'
        ]
    ],
    
    'notes' => [
        'Класс использует паттерн Singleton - всегда возвращает одно и то же подключение',
        'Все параметры подключения берутся из Env класса (переменные окружения)',
        'При ошибке подключения выбрасывает RuntimeException',
        'В режиме отладки логирует все SQL запросы через Logs класс',
        'Установлены оптимальные параметры PDO:',
        '- ERRMOOE_EXCEPTION - исключения при ошибках',
        '- FETCH_ASSOC - ассоциативные массивы по умолчанию',
        '- EMULATE_PREPARES = false - настоящие подготовленные запросы'
    ],
    
    'exceptions' => [
        'RuntimeException' => 'Выбрасывается при неполной конфигурации БД или ошибке подключения',
        'PDOException' => 'Ловится внутри конструктора, логируется и преобразуется в RuntimeException'
    ],
    
    'dependencies' => [
        'Logs' => 'Для логирования запросов и ошибок',
        'Env' => 'Для получения параметров подключения из окружения'
    ]
];
?>