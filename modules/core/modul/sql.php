<?php

namespace Modules\Core\Modul;

class Sql extends \PDO
{
    private static ?self $instance = null;

    /**
     * Статический метод для получения подключения
     */
    public static function connect(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $logger = new Logs();
        try {
            $host = Env::get('DB_HOST', 'localhost');
            $port = Env::get('DB_PORT', '3306');
            $dbname = Env::get('DB_DATABASE');
            $user = Env::get('DB_USERNAME');
            $pass = Env::get('DB_PASSWORD');
            $charset = Env::get('DB_CHARSET', 'utf8mb4');

            if (empty($dbname) || empty($user)) {
                $logger->loging('sql', "Неполная комплектация конфигураций");
                throw new \RuntimeException('Database configuration is incomplete');
            }

            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

            parent::__construct($dsn, $user, $pass, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::ATTR_PERSISTENT => false
            ]);

        } catch (\PDOException $e) {
            $logger->loging('sql', "Ошибка подключения к бд: " . $e->getMessage());
            error_log('Database connection failed: ' . $e->getMessage());
            throw new \RuntimeException('Database connection error');
        }
    }

    /**
     * Подготовка запроса с логированием
     * 
     * @param string $query SQL запрос
     * @param array $options Опции PDO
     * @return \PDOStatement|false
     */
    public function prepare(string $query, array $options = []): \PDOStatement|false
    {
        if (Env::get('APP_DEBUG') === "true") {
            $str = "запрос " . $query;
            $logger = new Logs();
            $logger->loging('sql', $str);
            error_log("SQL: $query");
        }
        
        return parent::prepare($query, $options);
    }

    /**
     * Выполнение запроса с логированием
     * 
     * @param string $query SQL запрос
     * @param int $fetchMode Режим выборки
     * @param mixed ...$fetch_mode_args Дополнительные аргументы
     * @return \PDOStatement|false
     */
    public function query(string $query, ?int $fetchMode = null, mixed ...$fetch_mode_args): \PDOStatement|false
    {
        if (Env::get('APP_DEBUG') === "true") {
            $logger = new Logs();
            $logger->loging('sql', "query: " . $query);
            error_log("SQL Query: $query");
        }
        
        if ($fetchMode !== null) {
            return parent::query($query, $fetchMode, ...$fetch_mode_args);
        }
        
        return parent::query($query);
    }

    /**
     * Экранирование строки
     * 
     * @param string $string Строка для экранирования
     * @param int $parameter_type Тип параметра
     * @return string|false
     */
    public function quote(string $string, int $parameter_type = \PDO::PARAM_STR): string|false
    {
        return parent::quote($string, $parameter_type);
    }

    /**
     * Последний INSERT ID
     * 
     * @param string|null $name Имя последовательности
     * @return string|false
     */
    public function lastInsertId(?string $name = null): string|false
    {
        return parent::lastInsertId($name);
    }

    /**
     * Запуск транзакции
     */
    public function beginTransaction(): bool
    {
        return parent::beginTransaction();
    }

    /**
     * Подтверждение транзакции
     */
    public function commit(): bool
    {
        return parent::commit();
    }

    /**
     * Откат транзакции
     */
    public function rollBack(): bool
    {
        return parent::rollBack();
    }

    /**
     * Проверка в транзакции
     */
    public function inTransaction(): bool
    {
        return parent::inTransaction();
    }

    /**
     * Получение ошибок
     */
    public function errorCode(): ?string
    {
        return parent::errorCode();
    }

    /**
     * Получение информации об ошибках
     */
    public function errorInfo(): array
    {
        return parent::errorInfo();
    }

    private function __clone() {}
    public function __wakeup(): void {}
}