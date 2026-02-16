<?php
$classData = [
    'title' => 'Env - Работа с переменными окружения',
    'description' => 'Класс Env предназначен для загрузки и доступа к переменным окружения из .env файла. Реализует паттерн Singleton с ленивой загрузкой и автоматическим логированием ошибок.',
    
    'class_info' => [
        'namespace' => 'Modules\\Core\\Modul',
        'pattern' => 'Singleton (ленивая загрузка)',
        'file' => '.env'
    ],
    
    'constants' => [
        'APP_ROOT' => 'Корневая директория приложения (определяется глобально)',
        'DS' => 'Разделитель директорий (DIRECTORY_SEPARATOR)'
    ],
    
    'properties' => [
        [
            'name' => '$vars',
            'type' => 'private static array',
            'description' => 'Хранит загруженные переменные окружения',
            'default' => '[]'
        ],
        [
            'name' => '$initialized',
            'type' => 'private static bool',
            'description' => 'Флаг инициализации (был ли загружен .env файл)',
            'default' => 'false'
        ]
    ],
    
    'methods' => [
        [
            'name' => 'load()',
            'type' => 'public static',
            'return' => 'void',
            'description' => 'Загружает переменные из .env файла. Автоматически вызывается при первом обращении к get().',
            'example' => 'Env::load(); // Явная загрузка (необязательно)',
            'throws' => [
                'RuntimeException' => 'Если .env файл не найден или имеет неверный формат'
            ]
        ],
        [
            'name' => 'get()',
            'type' => 'public static',
            'return' => 'mixed',
            'description' => 'Получает значение переменной окружения по ключу. Если переменная не найдена, возвращает значение по умолчанию.',
            'example' => '// Простое использование
$dbHost = Env::get("DB_HOST");
$dbName = Env::get("DB_DATABASE", "default_db");

// С проверкой
$appEnv = Env::get("APP_ENV", "production");
$debug = Env::get("APP_DEBUG", "false") === "true";',
            'parameters' => [
                'key' => 'Ключ переменной (строка)',
                'default' => 'Значение по умолчанию, если переменная не найдена'
            ]
        ],
        [
            'name' => 'safeLog()',
            'type' => 'private static',
            'return' => 'void',
            'description' => 'Безопасно логирует сообщения. Пытается использовать Logs класс, если это невозможно - пишет в error_log.',
            'example' => 'self::safeLog("Сообщение для логирования");'
        ]
    ],
    
    'examples' => [
        [
            'title' => 'Пример .env файла',
            'code' => '# .env
APP_NAME="Мое приложение"
APP_ENV=development
APP_DEBUG=true

DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=mydb
DB_USERNAME=root
DB_PASSWORD=secret

REDIS_HOST=127.0.0.1
REDIS_PORT=6379

MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=user@gmail.com
MAIL_PASSWORD=pass'
        ],
        [
            'title' => 'Базовое использование',
            'code' => '// Автоматическая загрузка при первом обращении
$dbConfig = [
    "host" => Env::get("DB_HOST", "localhost"),
    "port" => Env::get("DB_PORT", "3306"),
    "name" => Env::get("DB_DATABASE"),
    "user" => Env::get("DB_USERNAME"),
    "pass" => Env::get("DB_PASSWORD")
];

// Проверка режима отладки
if (Env::get("APP_DEBUG") === "true") {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}'
        ],
        [
            'title' => 'Валидация обязательных переменных',
            'code' => 'class Config {
    public static function validate(): void {
        $required = [
            "DB_DATABASE",
            "DB_USERNAME",
            "APP_KEY"
        ];
        
        foreach ($required as $key) {
            if (Env::get($key) === null) {
                throw new RuntimeException("Отсутствует обязательная переменная: " . $key);
            }
        }
    }
}

// Использование
try {
    Config::validate();
    echo "Конфигурация корректна";
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}'
        ],
        [
            'title' => 'Интеграция с другими классами',
            'code' => 'class Database {
    private $connection;
    
    public function __construct() {
        // Env автоматически загрузится при вызове get()
        $this->connection = new PDO(
            "mysql:host=" . Env::get("DB_HOST") . 
            ";dbname=" . Env::get("DB_DATABASE"),
            Env::get("DB_USERNAME"),
            Env::get("DB_PASSWORD")
        );
    }
}

class Mailer {
    public function send($to, $subject, $message) {
        $host = Env::get("MAIL_HOST");
        $user = Env::get("MAIL_USERNAME");
        $pass = Env::get("MAIL_PASSWORD");
        
        // Отправка письма...
    }
}'
        ]
    ],
    
    'notes' => [
        'Класс использует ленивую загрузку - .env файл читается только при первом обращении к get()',
        'Файл .env должен находиться в корне приложения (APP_ROOT)',
        'Формат файла должен быть совместим с parse_ini_file()',
        'При ошибках логирование пытается использовать Logs класс, но безопасно падает на error_log',
        'Все переменные возвращаются как строки, требуется явное преобразование типов',
        'Метод load() можно вызвать явно для предварительной загрузки'
    ],
    
    'exceptions' => [
        'RuntimeException' => 'Выбрасывается в случаях: .env файл не найден, .env файл имеет неверный формат'
    ],
    
    'dependencies' => [
        'Logs' => 'Используется для логирования (опционально, с безопасным падением)'
    ],
    
    'error_scenarios' => [
        'Файл не найден' => 'Бросает RuntimeException и логирует критическую ошибку',
        'Неверный формат' => 'Бросает RuntimeException и логирует ошибку парсинга',
        'Переменная не найдена' => 'Возвращает null или значение по умолчанию (без ошибки)',
        'Ошибка логирования' => 'Безопасно падает на error_log'
    ],
    
    'best_practices' => [
        'Всегда проверяйте обязательные переменные при старте приложения',
        'Используйте значения по умолчанию для опциональных настроек',
        'Не храните .env файл в репозитории (добавьте в .gitignore)',
        'Для булевых значений используйте строгое сравнение с "true"',
        'Создайте .env.example с примерами всех необходимых переменных'
    ]
];
?>