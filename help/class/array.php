<?php
$classData = [
    'title' => 'Массивы в PHP',
    'description' => 'Массивы в PHP — это упорядоченные структуры данных, которые хранят набор элементов. PHP поддерживает индексированные и ассоциативные массивы.',
    'methods' => [
        [
            'name' => 'array_push()',
            'description' => 'Добавляет один или несколько элементов в конец массива',
            'example' => 'array_push($arr, "новый элемент");'
        ],
        [
            'name' => 'array_pop()',
            'description' => 'Удаляет последний элемент массива',
            'example' => '$last = array_pop($arr);'
        ],
        [
            'name' => 'array_merge()',
            'description' => 'Объединяет два или более массивов',
            'example' => '$result = array_merge($arr1, $arr2);'
        ],
        [
            'name' => 'array_keys()',
            'description' => 'Возвращает все ключи массива',
            'example' => '$keys = array_keys($arr);'
        ],
        [
            'name' => 'in_array()',
            'description' => 'Проверяет, присутствует ли значение в массиве',
            'example' => 'if (in_array("значение", $arr)) { ... }'
        ]
    ],
    'examples' => [
        '// Создание массива
$fruits = ["яблоко", "банан", "апельсин"];

// Добавление элемента
array_push($fruits, "груша");

// Ассоциативный массив
$user = [
    "name" => "Иван",
    "age" => 25,
    "city" => "Москва"
];',
        '// Перебор массива
foreach ($fruits as $fruit) {
    echo $fruit . "\n";
}'
    ]
];
?>