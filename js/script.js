let searchInput = document.getElementById('searchInput');
document.addEventListener('DOMContentLoaded', start); // когда HTML будет подготовлен и загружен, вызвать функцию start

function start() {
    let bookTitle;

    // поиск по началу печати
    searchInput.addEventListener('keyup',()=>{
        bookTitle = searchInput.value;
        if (bookTitle.length != 1) {
            event.preventDefault();
            searchBook(bookTitle);
        }
    });
}

function searchBook(bookTitle) {
    let xhr = new XMLHttpRequest();
    let params = 'bookTitle=' + bookTitle;
    document.getElementById('results').innerHTML = ''; // очищаем контейнер для результатов

    xhr.open('POST', '../php/search.php');
    xhr.onreadystatechange=()=>{
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                document.getElementById('results').innerHTML = xhr.responseText;
            }
            else
                console.log('Ошибка: ' + xhr.status);
        }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
}