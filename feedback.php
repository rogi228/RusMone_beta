<?php
// --- Настройки ---
$file = "feedback.txt";   // файл, куда будут записываться обращения

// --- Проверяю, был ли POST-запрос ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Получаем данные + защита от XSS
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Формирую строку для записи
    $entry = "----- Новое сообщение -----\n" .
             "Имя: $name\n" .
             "Email: $email\n" .
             "Сообщение:\n$message\n" .
             "Дата: " . date("Y-m-d H:i:s") . "\n\n";

    // Записываю в файл
    file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);

    // Отдаю ответ браузеру
    echo "OK";
}
?>