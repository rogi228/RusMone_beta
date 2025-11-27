function updateOnlineCount() {
    fetch("/online.php")
        .then(response => response.text())
        .then(count => {
            document.getElementById("online-counter").textContent =
                "На сайте сейчас находится: " + count + " человек.";
        })
        .catch(error => console.error("Ошибка получения данных:", error));
}

// Обновляем каждые 5 секунд
setInterval(updateOnlineCount, 5000);

// Обновляем сразу при входе
updateOnlineCount();