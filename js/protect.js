// Запрет копирования текста
document.addEventListener('copy', function(e) {
    e.preventDefault();
});

// Запрет выделения текста
document.addEventListener('selectstart', function(e) {
    e.preventDefault();
});

// Запрет перетаскивания изображений
document.addEventListener("dragstart", function(e){
    if (e.target.tagName === "IMG") {
        e.preventDefault();
    }
});

// Запрет правого клика только по изображениям
document.addEventListener('contextmenu', function(e) {
    if (e.target.tagName === "IMG") {
        e.preventDefault();
    }
});