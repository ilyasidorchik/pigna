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

    document.querySelector('.form__element__label-description').addEventListener("click", toggleAppearingBlock);
    document.querySelector('.form__element__label-price').addEventListener("click", toggleAppearingBlock);

    document.querySelector('.book-adding__button').addEventListener("click", ()=>{
        event.preventDefault();
        addBook();
    });
}

function searchBook(bookTitle) {
    let xhr = new XMLHttpRequest();
    let params = 'bookTitle=' + bookTitle;
    let results = document.getElementById('results');

    xhr.open('POST', '../php/search.php');
    xhr.onreadystatechange=()=>{
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                results.innerHTML = xhr.responseText;
            }
            else
                console.log('Ошибка: ' + xhr.status);
        }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
}

function toggleAppearingBlock() {
    let elementIdentifier = this.classList.value.split("-")[1]; // e.g. description

    let label = '.form__label-' + elementIdentifier;
    let appearingLabel = document.querySelector(label);

    let inputBlock = '.form__element-' + elementIdentifier;
    let appearingInputBlock = document.querySelector(inputBlock);

    let input = '.form__element-' + elementIdentifier + ' .form__element__input';

    if (appearingInputBlock.style.display == 'none') {
        appearingLabel.style.display = 'block';
        appearingInputBlock.style.display = 'block';
        document.querySelector(input).focus();
    }
    else {
        appearingLabel.style.display = 'none';
        appearingInputBlock.style.display = 'none';
    }
}

function addBook() {
    let author = document.querySelector('.form__element__input-author').value;
    let title = document.querySelector('.form__element__input-title').value;
    let publishing = document.querySelector('.form__element__input-publishing-city').value + ', ' + document.querySelector('.form__element__input-publishing-year').value;
    let monthBook = document.querySelector('.form__element__label-description').checked;
    if (monthBook == true) {
        monthBook = 1;
    }
    else {
        monthBook = 0;
    }
    let description = document.querySelector('.form__element__input-month-book-description').value;

    let price = document.querySelector('.form__element__input-price').value;
    if (price == '') {
        price = 0;
    }

    let xhr = new XMLHttpRequest();
    let params = 'title=' + title + '&author=' + author + '&publishing=' + publishing + '&monthBook=' + monthBook + '&price=' + price + '&description=' + description;

    xhr.open('POST', '../php/addBook.php');
    xhr.onreadystatechange=()=>{
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // results.innerHTML = xhr.responseText;

            }
            else
                console.log('Ошибка: ' + xhr.status);
        }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
}