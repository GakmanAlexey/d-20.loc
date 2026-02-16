<?php
header('Content-Type: application/json');

// Получаем имя класса из запроса
$className = isset($_GET['class']) ? $_GET['class'] : '';

if (empty($className)) {
    echo json_encode(['error' => 'Класс не указан']);
    exit;
}

// Формируем путь к файлу класса
$classFile = __DIR__ . '/../class/' . $className . '.php';

if (!file_exists($classFile)) {
    echo json_encode(['error' => 'Класс не найден']);
    exit;
}

// Подключаем файл с данными класса
include $classFile;

// Возвращаем данные в JSON формате
echo json_encode($classData);
?>