let searchInput = document.getElementById('searchInput');
document.addEventListener('DOMContentLoaded', start); // когда HTML будет подготовлен и загружен, вызвать функцию start

function start() {
    let bookTitle;

    searchInput.addEventListener('keypress',()=>{if(event.key==='Enter'){event.preventDefault();searchBook(bookTitle)}}); // поиск по Энтеру
}

function searchBook(bookTitle) {
    if ((bookTitle == '[object MouseEvent]') || (bookTitle == undefined)) {
        bookTitle = searchInput.value;
    }
    if (bookTitle != '') {
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
}