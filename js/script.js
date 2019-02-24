let searchInput = document.getElementById('searchInput');
document.addEventListener('DOMContentLoaded', start); // когда HTML будет подготовлен и загружен, вызвать функцию start

function start() {
    let bookTitle;

    // поиск по началу печати
    if (searchInput != null) {
        searchInput.addEventListener('keyup',()=>{
            bookTitle = searchInput.value;
            if (bookTitle.length != 1) {
                event.preventDefault();
                searchBook(bookTitle);
            }
        });
    }


    // Форма добавления книги
    let bookCover = document.querySelector('.book-adding__cover .grid__item');

    let authorInput = document.querySelector('.form__element__input-author');
    let bookCoverAuthor = document.querySelector('.grid__item__authortitle__author');

    let titleInput = document.querySelector('.form__element__input-title');
    let bookCoverTitle = document.querySelector('.grid__item__authortitle__title');

    let publishingCityInput = document.querySelector('.form__element__input-publishing-city');

    let bookCoverPublishing = document.querySelector('.grid__item__publishing');

    let publishingYearInput = document.querySelector('.form__element__input-publishing-year');


    // Поле с годом издания только для цифр
    publishingYearInput.onkeypress = function(e) {
        e = e || event;

        if (e.ctrlKey || e.altKey || e.metaKey) return;

        var chr = getChar(e);

        // с null надо осторожно в неравенствах,
        // т.к. например null >= '0' => true
        // на всякий случай лучше вынести проверку chr == null отдельно
        if (chr == null) return;

        if (chr < '0' || chr > '9') {
            return false;
        }
    }


    authorInput.addEventListener('keyup',()=>{
        // При заполнении полей появляется обложка
        // Если поля снова очищаются, обложка пропадает
        if (bookCover.style.display == 'none') {
            bookCover.style.display = 'flex';
        }
        else {
            if (authorInput.value == '' && titleInput.value == '' && publishingCityInput.value == '' && publishingYearInput.value == '') {
                bookCover.style.display = 'none';
            }
        }

        bookCoverAuthor.innerHTML = authorInput.value;
    });


    titleInput.addEventListener('keyup', ()=>{
        // При заполнении полей появляется обложка
        // Если поля снова очищаются, обложка пропадает
        if (bookCover.style.display == 'none') {
            bookCover.style.display = 'flex';
        }
        else {
            if (authorInput.value == '' && titleInput.value == '' && publishingCityInput.value == '' && publishingYearInput.value == '') {
                bookCover.style.display = 'none';
            }
        }

        bookCoverTitle.innerHTML = titleInput.value;
    });


    let bookCoverPuslishingData = '';
    publishingCityInput.addEventListener('keyup', ()=>{
        // При заполнении полей появляется обложка
        // Если поля снова очищаются, обложка пропадает
        if (bookCover.style.display == 'none') {
            bookCover.style.display = 'flex';
        }
        else {
            if (authorInput.value == '' && titleInput.value == '' && publishingCityInput.value == '' && publishingYearInput.value == '') {
                bookCover.style.display = 'none';
            }
        }

        if (publishingYearInput.value == '') {
            bookCoverPuslishingData = publishingCityInput.value;
        }
        else {
            if (publishingCityInput.value == '') {
                bookCoverPuslishingData = publishingYearInput.value;
            }
            else {
                bookCoverPuslishingData = publishingCityInput.value + ', ' + publishingYearInput.value;
            }
        }

        bookCoverPublishing.innerHTML = bookCoverPuslishingData;
    });

    publishingYearInput.addEventListener('keyup', ()=>{
        // При заполнении полей появляется обложка
        // Если поля снова очищаются, обложка пропадает
        if (bookCover.style.display == 'none') {
            bookCover.style.display = 'flex';
        }
        else {
            if (authorInput.value == '' && titleInput.value == '' && publishingCityInput.value == '' && publishingYearInput.value == '') {
                bookCover.style.display = 'none';
            }
        }

        if (publishingYearInput.value == '') {
            if (publishingCityInput.value == '') {
                bookCoverPuslishingData = '';
            }
            else {
                bookCoverPuslishingData = publishingCityInput.value;
            }
        }
        else {
            if (publishingCityInput.value == '') {
                bookCoverPuslishingData = publishingYearInput.value;
            }
            else {
                bookCoverPuslishingData = publishingCityInput.value + ', ' + publishingYearInput.value;
            }
        }

        bookCoverPublishing.innerHTML = bookCoverPuslishingData;
    });

    document.querySelector('.form__element__label-description').addEventListener("click", toggleAppearingBlock);
    document.querySelector('.form__element__label-description').addEventListener("click", ()=>{
        bookCover.classList.toggle('grid__item-month-book-color');

        let bookCoverMonthBook = document.querySelector('.month-book');
        if (bookCoverMonthBook.style.display == 'none') {
            bookCoverMonthBook.style.display = 'block';
        }
        else {
            bookCoverMonthBook.style.display = 'none';
        }
    });

    let monthBookDescInput = document.querySelector('.form__element__input-month-book-description');
    let bookCoverMonthBookDesc = document.querySelector('.month-book__wrap__description');
    monthBookDescInput.addEventListener('keyup', ()=>{
        bookCoverMonthBookDesc.innerHTML = monthBookDescInput.value;
    });


    document.querySelector('.form__element__label-price').addEventListener("click", toggleAppearingBlock);
    var stickerForPrice = document.querySelector('.grid__item__sticker-for-price');
    document.querySelector('.form__element__label-price').addEventListener("click", ()=>{
        if (stickerForPrice.style.display == 'none') {
            stickerForPrice.style.display = 'block';
        }
        else {
            stickerForPrice.style.display = 'none';
        }
    });

    let priceInput = document.querySelector('.form__element__input-price');
    priceInput.addEventListener('keyup', ()=>{
        if (priceInput.value == '') {
            stickerForPrice.innerHTML = '';
        }
        else {
            stickerForPrice.innerHTML = priceInput.value + '&thinsp;€';
        }
    });


    document.querySelector('.book-adding__button').addEventListener("click", ()=>{
        event.preventDefault();
        addBook();
    });
}

function searchBook(bookTitle) {
    let xhr = new XMLHttpRequest();
    let params = 'bookTitle=' + bookTitle;
    let results = document.querySelector('.grid');

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
    // Обязательные поля
    // Если не заполнено поле — у него появляется фокус и обводка
    let authorInput = document.querySelector('.form__element__input-author');
    let author = authorInput.value;

    let titleInput = document.querySelector('.form__element__input-title');
    let title = titleInput.value;

    if (author == '') {
        authorInput.focus();
        authorInput.classList.add('form__element__input-invalid');
        return;
    }
    else {
        authorInput.classList.remove('form__element__input-invalid');
    }

    if (title == '') {
        titleInput.focus();
        titleInput.classList.add('form__element__input-invalid');
        return;
    }
    else {
        titleInput.classList.remove('form__element__input-invalid');
    }

    // Необязательные поля
    let publishingCityInput = document.querySelector('.form__element__input-publishing-city');
    let publishingCity = publishingCityInput.value;

    let publishingYearInput = document.querySelector('.form__element__input-publishing-year');
    let publishingYear = publishingYearInput.value;

    let publishing = publishingCity + ', ' + publishingYear;


    let monthBook = document.querySelector('.form__element__label-description').checked;
    let descriptionBlock = document.querySelector('.form__element__input-month-book-description');
    let description = descriptionBlock.value;
    if (monthBook == true) {
        monthBook = 1;

        if (description == '') {
            descriptionBlock.focus();
            descriptionBlock.classList.add('form__element__input-invalid');
            return;
        }
        else {
            descriptionBlock.classList.remove('form__element__input-invalid');
        }
    }
    else {
        monthBook = 0;
        description = '';
    }

    let priceCheckbox = document.querySelector('.form__element__label-price');
    let priceBlock = document.querySelector('.form__element__input-price');
    let price = priceBlock.value;

    if (priceCheckbox.checked == true) {
        if (price == '') {
            priceBlock.focus();
            priceBlock.classList.add('form__element__input-invalid');
            return;
        }
        else {
            priceBlock.classList.remove('form__element__input-invalid');
        }
    }
    else {
        if (price == '') {
            price = 0;
        }
    }


    let xhr = new XMLHttpRequest();
    let params = 'title=' + title + '&author=' + author + '&publishing=' + publishing + '&price=' + price + '&monthBook=' + monthBook + '&description=' + description;

    console.log(params);

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

function getChar(event) {
    if (event.which == null) {
        if (event.keyCode < 32) return null;
        return String.fromCharCode(event.keyCode) // IE
    }

    if (event.which != 0 && event.charCode != 0) {
        if (event.which < 32) return null;
        return String.fromCharCode(event.which) // остальные
    }

    return null; // специальная клавиша
}