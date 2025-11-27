<?php
session_start();

$file = "active_users.txt";

$session = session_id();
$time = time();
$timeout = 30;

$users = [];

// Если файл пустой или нет — создаем
if (!file_exists($file)) {
    file_put_contents($file, "");
}

// Читаем файл
$data = file($file, FILE_IGNORE_NEW_LINES);

foreach ($data as $line) {
    if (trim($line) == "") continue; // <-- защищаемся от пустых строк

    $parts = explode("|", $line);

    if (count($parts) < 2) continue; // <-- защищаемся от кривых строк

    $userId   = $parts[0];
    $lastTime = intval($parts[1]);

    if ($time - $lastTime <= $timeout) {
        $users[$userId] = $lastTime;
    }
}

// Обновляем текущего пользователя
$users[$session] = $time;

// Пишем обратно
$fp = fopen($file, "w");

foreach ($users as $id => $t) {
    fwrite($fp, $id . "|" . $t . "\n");
}

fclose($fp);

// Выводим онлайн
echo count($users);
?>