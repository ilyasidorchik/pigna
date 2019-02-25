let searchInput = document.getElementById('searchInput');

let formWrap = document.querySelector('.book-adding__form');
let form = document.querySelector('.book-adding__form .form');

let authorInput = document.querySelector('.form__element__input-author');
let titleInput = document.querySelector('.form__element__input-title');
let publishingCityInput = document.querySelector('.form__element__input-publishing-city');
let publishingYearInput = document.querySelector('.form__element__input-publishing-year');
let monthBookCheckbox = document.querySelector('.form__element__label-description');
let monthBookDescInput = document.querySelector('.form__element__input-month-book-description');
let priceCheckbox = document.querySelector('.form__element__label-price');
let priceInput = document.querySelector('.form__element__input-price');

let bookCover = document.querySelector('.book-adding__cover .grid__item');
let bookCoverAuthor = document.querySelector('.grid__item__authortitle__author');
let bookCoverTitle = document.querySelector('.grid__item__authortitle__title');
let bookCoverPublishing = document.querySelector('.grid__item__publishing');
let bookCoverMonthBook = document.querySelector('.month-book');
let bookCoverMonthBookDesc = document.querySelector('.month-book__wrap__description');
let stickerForPrice = document.querySelector('.grid__item__sticker-for-price');

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

    monthBookCheckbox.addEventListener("click", toggleAppearingBlock);
    monthBookCheckbox.addEventListener("click", ()=>{
        bookCover.classList.toggle('grid__item-month-book-color');

        if (bookCoverMonthBook.style.display == 'none') {
            bookCoverMonthBook.style.display = 'block';
        }
        else {
            bookCoverMonthBook.style.display = 'none';
        }
    });

    monthBookDescInput.addEventListener('keyup', ()=>{
        bookCoverMonthBookDesc.innerHTML = monthBookDescInput.value;
    });


    priceCheckbox.addEventListener("click", toggleAppearingBlock);
    priceCheckbox.addEventListener("click", ()=>{
        if (stickerForPrice.style.display == 'none') {
            stickerForPrice.style.display = 'block';
        }
        else {
            stickerForPrice.style.display = 'none';
        }
    });

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
    let author = authorInput.value;
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
    let publishingCity = publishingCityInput.value;

    let publishingYear = publishingYearInput.value;

    let publishing = publishingCity + ', ' + publishingYear;


    let monthBook = monthBookCheckbox.checked;
    let description = monthBookDescInput.value;
    if (monthBook == true) {
        monthBook = 1;

        if (description == '') {
            monthBookDescInput.focus();
            monthBookDescInput.classList.add('form__element__input-invalid');
            return;
        }
        else {
            monthBookDescInput.classList.remove('form__element__input-invalid');
        }
    }
    else {
        monthBook = 0;
        description = '';
    }

    let price = priceInput.value;
    if (priceCheckbox.checked == true) {
        if (price == '') {
            priceInput.focus();
            priceInput.classList.add('form__element__input-invalid');
            return;
        }
        else {
            priceInput.classList.remove('form__element__input-invalid');
        }
    }
    else {
        if (price == '') {
            price = 0;
        }
    }


    let xhr = new XMLHttpRequest();
    let params = 'title=' + title + '&author=' + author + '&publishing=' + publishing + '&price=' + price + '&monthBook=' + monthBook + '&description=' + description;

    xhr.open('POST', '../php/addBook.php');
    xhr.onreadystatechange=()=>{
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                form.style.opacity = '0';
                form.style.visibility = 'hidden';

                let alertSuccess = document.createElement('div');
                alertSuccess.className = "book-adding__form__alert-success";
                alertSuccess.innerHTML = 'Libro aqqiunto al catalogo. <a class="link-for-form-clearing">Aggiungere un altro libro</a>';
                formWrap.appendChild(alertSuccess);
                document.querySelector('.link-for-form-clearing').addEventListener("click", clearBookAddingForm);
            }
            else {
                console.log('Ошибка: ' + xhr.status);
            }
        }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
}

function clearBookAddingForm() {
    authorInput.value = '';
    titleInput.value = '';
    publishingCityInput.value = '';
    publishingYearInput.value = '';

    monthBookCheckbox.checked = false;
    monthBookDescInput.value = '';
    let monthBookDescLabel = document.querySelector('.form__label-description');
    let monthBookDescInputBlock = document.querySelector('.form__element-description');
    if (monthBookDescInputBlock.style.display == 'block') {
        monthBookDescLabel.style.display = 'none';
        monthBookDescInputBlock.style.display = 'none';
    }

    priceCheckbox.checked = false
    priceInput.value = '';
    let priceLabel = document.querySelector('.form__label-price');
    let priceInputBlock = document.querySelector('.form__element-price');
    if (priceInputBlock.style.display == 'block') {
        priceLabel.style.display = 'none';
        priceInputBlock.style.display = 'none';
    }

    let alertSuccess = document.querySelector('.book-adding__form__alert-success');
    formWrap.removeChild(alertSuccess);

    bookCoverAuthor.innerHTML = '';
    bookCoverTitle.innerHTML = '';
    bookCoverPublishing.innerHTML = '';
    bookCoverMonthBookDesc.innerHTML = '';
    bookCoverMonthBook.style.display = 'none';
    bookCover.classList.remove('grid__item-month-book-color');
    bookCover.style.display = 'none';
    stickerForPrice.innerHTML = '';
    stickerForPrice.style.display = 'none';
    form.style.opacity = '1';
    form.style.visibility = 'visible';

    authorInput.focus();
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