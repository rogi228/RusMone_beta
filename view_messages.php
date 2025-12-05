<?php
// view_messages.php - просмотр всех сообщений

// Проверка пароля
session_start();
$correct_password = 'Olegand27';

// Если не авторизован - показываем форму ввода пароля
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    if (isset($_POST['password']) && $_POST['password'] === $correct_password) {
        // Пароль верный
        $_SESSION['logged_in'] = true;
    } else {
        // Показываем форму ввода пароля
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Вход - RusMone</title>
            <meta charset='UTF-8'>
            <style>
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0;
                }
                .login-box {
                    background: white;
                    padding: 40px;
                    border-radius: 15px;
                    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
                    width: 350px;
                    text-align: center;
                }
                .login-box h2 {
                    color: #333;
                    margin-bottom: 30px;
                }
                .login-box input[type='password'] {
                    width: 100%;
                    padding: 12px;
                    margin: 10px 0;
                    border: 2px solid #ddd;
                    border-radius: 8px;
                    font-size: 16px;
                    transition: border 0.3s;
                }
                .login-box input[type='password']:focus {
                    border-color: #667eea;
                    outline: none;
                }
                .login-box button {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    border: none;
                    padding: 12px 30px;
                    border-radius: 8px;
                    font-size: 16px;
                    cursor: pointer;
                    width: 100%;
                    margin-top: 10px;
                    transition: transform 0.2s;
                }
                .login-box button:hover {
                    transform: translateY(-2px);
                }
                .error {
                    color: #e74c3c;
                    margin-top: 10px;
                    font-size: 14px;
                }
                .logo {
                    font-size: 24px;
                    font-weight: bold;
                    color: #2c3e50;
                    margin-bottom: 10px;
                }
            </style>
        </head>
        <body>
            <div class='login-box'>
                <div class='logo'>RusMone Admin</div>
                <h2>Введите пароль</h2>
                <form method='POST'>
                    <input type='password' name='password' placeholder='Пароль' required autofocus>
                    <button type='submit'>Войти</button>";

        if (isset($_POST['password']) && $_POST['password'] !== $correct_password) {
            echo "<div class='error'>Неверный пароль</div>";
        }

        echo "</form>
            </div>
        </body>
        </html>";
        exit;
    }
}

// Если авторизован - показываем сообщения
echo "<html><head><title>Сообщения - RusMone</title>";
echo "<meta charset='UTF-8'>";
echo "<style>
    * { box-sizing: border-box; }
    body { 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        padding: 20px; 
        max-width: 1200px; 
        margin: 0 auto; 
        background: #f8f9fa;
    }
    .header {
        background: linear-gradient(135deg, #2c3e50, #4a6491);
        color: white;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        position: relative;
    }
    .logout-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        padding: 8px 15px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        transition: background 0.3s;
    }
    .logout-btn:hover {
        background: rgba(255,255,255,0.3);
    }
    .message {
        background: white;
        padding: 20px;
        margin: 20px 0;
        border-radius: 10px;
        border-left: 5px solid #3498db;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: transform 0.2s;
    }
    .message:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    .field {
        margin: 10px 0;
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .label {
        font-weight: 600;
        color: #2c3e50;
        display: inline-block;
        width: 100px;
    }
    .message-text {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 6px;
        margin: 15px 0;
        white-space: pre-wrap;
        font-family: 'Courier New', monospace;
        border: 1px solid #e9ecef;
        line-height: 1.5;
    }
    .stats {
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin: 15px 0;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    .stat-item {
        background: #e3f2fd;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
    }
    .controls {
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin: 15px 0;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .btn {
        padding: 10px 20px;
        background: #3498db;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
    }
    .btn:hover {
        background: #2980b9;
    }
    .search-box {
        flex-grow: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
    }
    .message-number {
        font-size: 12px;
        color: #7f8c8d;
        float: right;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }
    .empty-state h3 {
        font-size: 24px;
        margin-bottom: 10px;
    }
    @media (max-width: 768px) {
        body { padding: 10px; }
        .label { width: 70px; }
        .controls { flex-direction: column; }
        .search-box { width: 100%; }
    }
</style></head><body>";

echo "<div class='header'>";
echo "<h1>📨 Сообщения от пользователей RusMone</h1>";
echo "<p>Панель управления обратной связью</p>";
echo "<a href='?logout=1' class='logout-btn'>🚪 Выйти</a>";
echo "</div>";

// Выход из системы
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: view_messages.php');
    exit;
}

// Поиск по сообщениям
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

echo "<div class='controls'>";
echo "<form method='GET' style='display:flex; flex-grow:1; gap:10px;'>";
echo "<input type='text' name='search' class='search-box' placeholder='Поиск по имени, email или тексту...' value='" . htmlspecialchars($search) . "'>";
echo "<button type='submit' class='btn'>🔍 Найти</button>";
echo "</form>";
echo "<a href='contacts.html' class='btn'>📝 К форме</a>";
echo "<a href='view_messages.php' class='btn'>🔄 Обновить</a>";
echo "<a href='index.html' class='btn'>🏠 На главную</a>";
echo "</div>";

// Ищем файл с сообщениями
$files_to_check = [
    __DIR__ . '/feedback_data/messages.txt',
    __DIR__ . '/feedback_messages.txt',
    sys_get_temp_dir() . '/rusmone_feedback/messages.txt'
];

$messages_file = null;
foreach ($files_to_check as $file) {
    if (file_exists($file) && filesize($file) > 0) {
        $messages_file = $file;
        break;
    }
}

if ($messages_file) {
    $content = file_get_contents($messages_file);

    // Разбиваем на сообщения
    $raw_messages = explode("=== НОВОЕ СООБЩЕНИЕ ===", $content);

    // Фильтруем пустые и применяем поиск
    $messages = [];
    foreach ($raw_messages as $msg) {
        $msg = trim($msg);
        if (!empty($msg)) {
            if (empty($search) || stripos($msg, $search) !== false) {
                $messages[] = $msg;
            }
        }
    }

    // Статистика
    echo "<div class='stats'>";
    echo "<div class='stat-item'>📊 Всего сообщений: " . count($raw_messages) . "</div>";
    echo "<div class='stat-item'>🔍 Найдено: " . count($messages) . "</div>";
    echo "<div class='stat-item'>📂 Файл: " . basename($messages_file) . "</div>";
    if (count($messages) > 0) {
        // Получаем дату первого (самого нового) сообщения
        $first_msg = $messages[0];
        if (preg_match('/Время:\s*(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/', $first_msg, $matches)) {
            $last_date = date('d.m.Y H:i', strtotime($matches[1]));
            echo "<div class='stat-item'>📅 Последнее: $last_date</div>";
        }
    }
    echo "</div>";

    if (count($messages) > 0) {
        // Выводим в обратном порядке (новые сверху)
        $messages = array_reverse($messages);

        foreach ($messages as $index => $message) {
            $message_num = count($messages) - $index;

            echo "<div class='message'>";
            echo "<span class='message-number'>#$message_num</span>";

            $lines = explode("\n", trim($message));
            $in_message_section = false;
            $message_content = '';

            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;

                if (strpos($line, ':') !== false && !$in_message_section) {
                    $parts = explode(':', $line, 2);
                    $label = trim($parts[0]);
                    $value = trim($parts[1] ?? '');

                    if ($label === 'Сообщение') {
                        // Начинаем секцию сообщения
                        $in_message_section = true;
                        echo "<div class='field'><span class='label'>$label</span></div>";
                    } else {
                        echo "<div class='field'>";
                        echo "<span class='label'>$label</span>";
                        echo htmlspecialchars($value);
                        echo "</div>";
                    }
                } else if ($in_message_section) {
                    // Собираем текст сообщения (может быть несколько строк)
                    $message_content .= $line . "\n";
                } else {
                    // Если строка без двоеточия и не в секции сообщения
                    echo "<div class='field'>";
                    echo htmlspecialchars($line);
                    echo "</div>";
                }
            }

            // Выводим собранное сообщение
            if (!empty($message_content)) {
                echo "<div class='message-text'>" . htmlspecialchars(trim($message_content)) . "</div>";
            }

            echo "</div>";
        }
    } else {
        if (!empty($search)) {
            echo "<div class='empty-state'>";
            echo "<h3>🔍 Ничего не найдено</h3>";
            echo "<p>Сообщения по запросу '<b>" . htmlspecialchars($search) . "</b>' не найдены.</p>";
            echo "<a href='view_messages.php' class='btn'>Показать все сообщения</a>";
            echo "</div>";
        } else {
            echo "<div class='empty-state'>";
            echo "<h3>📭 Пока нет сообщений</h3>";
            echo "<p>Как только пользователи отправят сообщения через форму обратной связи, они появятся здесь.</p>";
            echo "<a href='contacts.html' class='btn'>Перейти к форме</a>";
            echo "</div>";
        }
    }
} else {
    echo "<div class='empty-state'>";
    echo "<h3>📭 Файл с сообщениями не найден</h3>";
    echo "<p>Файл с сообщениями еще не создан. Отправьте первое сообщение через форму обратной связи.</p>";
    echo "<a href='contacts.html' class='btn'>Отправить первое сообщение</a>";
    echo "</div>";
}

echo "</body></html>";
?>