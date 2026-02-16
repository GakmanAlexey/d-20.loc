<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP справочник</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        
        .container {
            display: flex;
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            min-height: 90vh;
        }
        
        .sidebar {
            width: 300px;
            border-right: 1px solid #ddd;
            padding: 20px;
            background: #fafafa;
        }
        
        .sidebar h2 {
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
        }
        
        .class-list {
            list-style: none;
        }
        
        .class-list li {
            margin-bottom: 10px;
        }
        
        .class-list a {
            display: block;
            padding: 10px 15px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .class-list a:hover {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        
        .class-list a.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        
        .content {
            flex: 1;
            padding: 30px;
        }
        
        .class-info {
            display: none;
        }
        
        .class-info.active {
            display: block;
        }
        
        .class-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }
        
        .class-description {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
        }
        
        .methods-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .methods-table th,
        .methods-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .methods-table th {
            background: #007bff;
            color: white;
        }
        
        .methods-table tr:hover {
            background: #f5f5f5;
        }
        
        .loading {
            text-align: center;
            padding: 50px;
            color: #666;
        }
        
        .error {
            color: #dc3545;
            padding: 20px;
            background: #f8d7da;
            border-radius: 5px;
        }
        
        .method-name {
            font-weight: bold;
            color: #007bff;
        }
        
        .method-desc {
            color: #666;
        }
        
        .code-block {
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
            overflow-x: auto;
        }/* Дополнительные стили для детальной информации */
.class-metadata {
    background: #e9ecef;
    padding: 15px 20px;
    border-radius: 5px;
    margin-bottom: 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.metadata-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.metadata-label {
    font-weight: bold;
    color: #495057;
}

.metadata-value {
    background: white;
    padding: 5px 10px;
    border-radius: 3px;
    color: #007bff;
    font-family: monospace;
}

.properties-table,
.methods-table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

.properties-table th,
.methods-table th {
    background: #007bff;
    color: white;
    padding: 12px;
    text-align: left;
}

.properties-table td,
.methods-table td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    vertical-align: top;
}

.properties-table tr:hover,
.methods-table tr:hover {
    background: #f8f9fa;
}

.property-name {
    font-weight: bold;
    color: #28a745;
    font-family: monospace;
}

.property-type {
    color: #6c757d;
    font-size: 0.9em;
    font-family: monospace;
}

.method-signature {
    font-family: monospace;
    background: #f8f9fa;
    padding: 2px 5px;
    border-radius: 3px;
}

.note-box {
    background: #fff3cd;
    border-left: 4px solid #ffc107;
    padding: 15px;
    margin: 20px 0;
    border-radius: 0 5px 5px 0;
}

.note-box h4 {
    color: #856404;
    margin-bottom: 10px;
}

.note-list {
    list-style: none;
    padding-left: 0;
}

.note-list li {
    padding: 5px 0;
    padding-left: 20px;
    position: relative;
}

.note-list li:before {
    content: "•";
    color: #ffc107;
    font-weight: bold;
    position: absolute;
    left: 0;
}

.dependencies {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin: 10px 0;
}

.dependency-tag {
    background: #e7f5ff;
    color: #1864ab;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.9em;
    border: 1px solid #74c0fc;
}

.exception-box {
    background: #f8d7da;
    border-left: 4px solid #dc3545;
    padding: 15px;
    margin: 20px 0;
    border-radius: 0 5px 5px 0;
}

.env-vars {
    margin-top: 10px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 5px;
}

.env-var {
    display: flex;
    margin: 5px 0;
    padding: 5px;
    border-bottom: 1px dashed #dee2e6;
}

.env-name {
    font-weight: bold;
    width: 150px;
    color: #495057;
}

.env-desc {
    color: #6c757d;
}

.example-box {
    background: #f8f9fa;
    border-radius: 5px;
    margin: 20px 0;
    overflow: hidden;
}

.example-title {
    background: #e9ecef;
    padding: 10px 15px;
    font-weight: bold;
    color: #495057;
    border-bottom: 1px solid #dee2e6;
}
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Классы PHP</h2>
            <ul class="class-list" id="classList">
                <?php
                // Сканируем директорию с классами
                $classFiles = scandir(__DIR__ . '/class/');
                $classes = [];
                
                // Собираем информацию о классах
                foreach ($classFiles as $file) {
                    if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                        $className = pathinfo($file, PATHINFO_FILENAME);
                        
                        // Получаем заголовок из файла класса
                        include(__DIR__ . '/class/' . $file);
                        $title = isset($classData['title']) ? $classData['title'] : ucfirst($className);
                        
                        $classes[] = [
                            'file' => $className,
                            'title' => $title
                        ];
                    }
                }
                
                // Сортируем классы по заголовку
                usort($classes, function($a, $b) {
                    return strcmp($a['title'], $b['title']);
                });
                
                // Выводим список классов
                foreach ($classes as $class) {
                    echo '<li><a href="#" data-class="' . $class['file'] . '">' . htmlspecialchars($class['title']) . '</a></li>';
                }
                ?>
            </ul>
        </div>
        
        <div class="content" id="content">
            <div class="class-info active" id="welcome">
                <h1 class="class-title">Добро пожаловать в PHP справочник!</h1>
                <div class="class-description">
                    <p>Выберите класс из списка слева, чтобы просмотреть информацию о нём.</p>
                    <p>Справочник содержит описание классов, методов и примеры использования.</p>
                </div>
            </div>
            
            <div id="classInfoContainer"></div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const classLinks = document.querySelectorAll('.class-list a');
        const content = document.getElementById('content');
        const welcomeScreen = document.getElementById('welcome');
        const classInfoContainer = document.getElementById('classInfoContainer');
        
        // Функция загрузки информации о классе
        function loadClassInfo(className, element) {
            // Убираем активный класс у всех ссылок
            classLinks.forEach(link => link.classList.remove('active'));
            
            // Добавляем активный класс текущей ссылке
            if (element) {
                element.classList.add('active');
            }
            
            // Показываем загрузку
            welcomeScreen.style.display = 'none';
            classInfoContainer.innerHTML = '<div class="loading">Загрузка...</div>';
            
            // AJAX запрос
            fetch('ajax/get-class-info.php?class=' + encodeURIComponent(className))
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        classInfoContainer.innerHTML = '<div class="error">' + data.error + '</div>';
                    } else {
                        displayClassInfo(data);
                    }
                })
                .catch(error => {
                    classInfoContainer.innerHTML = '<div class="error">Ошибка загрузки данных</div>';
                });
        }
        
        // Функция отображения информации о классе
        // Функция отображения информации о классе
function displayClassInfo(data) {
    let html = '<div class="class-info active">';
    
    // Заголовок
    html += '<h1 class="class-title">' + data.title + '</h1>';
    
    // Метаданные класса
    if (data.class_info) {
        html += '<div class="class-metadata">';
        if (data.class_info.namespace) {
            html += '<div class="metadata-item"><span class="metadata-label">Namespace:</span><span class="metadata-value">' + data.class_info.namespace + '</span></div>';
        }
        if (data.class_info.extends) {
            html += '<div class="metadata-item"><span class="metadata-label">Extends:</span><span class="metadata-value">' + data.class_info.extends + '</span></div>';
        }
        if (data.class_info.pattern) {
            html += '<div class="metadata-item"><span class="metadata-label">Pattern:</span><span class="metadata-value">' + data.class_info.pattern + '</span></div>';
        }
        html += '</div>';
    }
    
    // Описание
    html += '<div class="class-description">' + data.description + '</div>';
    
    // Зависимости
    if (data.dependencies) {
        html += '<div class="note-box"><h4>Зависимости:</h4>';
        html += '<div class="dependencies">';
        for (let [dep, desc] of Object.entries(data.dependencies)) {
            html += '<span class="dependency-tag" title="' + desc + '">' + dep + '</span>';
        }
        html += '</div></div>';
    }
    
    // Свойства
    if (data.properties && data.properties.length > 0) {
        html += '<h2>Свойства класса</h2>';
        html += '<table class="properties-table">';
        html += '<thead><tr><th>Свойство</th><th>Тип</th><th>Описание</th><th>По умолчанию</th></tr></thead>';
        html += '<tbody>';
        
        data.properties.forEach(prop => {
            html += '<tr>';
            html += '<td><span class="property-name">' + prop.name + '</span></td>';
            html += '<td><span class="property-type">' + prop.type + '</span></td>';
            html += '<td>' + prop.description + '</td>';
            html += '<td><code>' + (prop.default || '—') + '</code></td>';
            html += '</tr>';
        });
        
        html += '</tbody>';
        html += '</table>';
    }
    
    // Методы
    if (data.methods && data.methods.length > 0) {
        html += '<h2>Методы класса</h2>';
        html += '<table class="methods-table">';
        html += '<thead><tr><th>Метод</th><th>Возвращает</th><th>Описание</th><th>Пример</th></tr></thead>';
        html += '<tbody>';
        
        data.methods.forEach(method => {
            html += '<tr>';
            html += '<td><span class="method-name">' + method.name + '</span><br><small class="property-type">' + method.type + '</small></td>';
            html += '<td><code>' + (method.return || 'void') + '</code></td>';
            html += '<td>' + method.description;
            
            // Показываем переменные окружения если есть
            if (method.env_vars) {
                html += '<div class="env-vars">';
                for (let [env, desc] of Object.entries(method.env_vars)) {
                    html += '<div class="env-var"><span class="env-name">' + env + '</span><span class="env-desc">' + desc + '</span></div>';
                }
                html += '</div>';
            }
            
            html += '</td>';
            html += '<td><div class="code-block">' + method.example + '</div></td>';
            html += '</tr>';
        });
        
        html += '</tbody>';
        html += '</table>';
    }
    
    // Примеры использования
    if (data.examples && data.examples.length > 0) {
        html += '<h2>Примеры использования</h2>';
        data.examples.forEach(example => {
            html += '<div class="example-box">';
            if (example.title) {
                html += '<div class="example-title">' + example.title + '</div>';
            }
            html += '<div class="code-block">' + example.code + '</div>';
            html += '</div>';
        });
    }
    
    // Заметки
    if (data.notes && data.notes.length > 0) {
        html += '<div class="note-box"><h4>Важно:</h4>';
        html += '<ul class="note-list">';
        data.notes.forEach(note => {
            html += '<li>' + note + '</li>';
        });
        html += '</ul></div>';
    }
    
    // Исключения
    if (data.exceptions) {
        html += '<div class="exception-box"><h4>Исключения:</h4>';
        html += '<ul class="note-list">';
        for (let [exc, desc] of Object.entries(data.exceptions)) {
            html += '<li><strong>' + exc + '</strong> — ' + desc + '</li>';
        }
        html += '</ul></div>';
    }
    
    html += '</div>';
    classInfoContainer.innerHTML = html;
}
        
        // Обработчик клика по ссылкам классов
        classLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const className = this.dataset.class;
                loadClassInfo(className, this);
            });
        });
    });
    </script>
</body>
</html>