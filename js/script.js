let searchInput = document.getElementById('searchInput');

// Форма добавления книги
let formWrap = document.querySelector('.book-editing__form');
let form = document.querySelector('.book-editing__form .form');

let authorInput = document.querySelectorAll('.form__element__input_author')[0];
let titleInput = document.querySelectorAll('.form__element__input_title')[0];
let publishingCityInput = document.querySelectorAll('.form__element__input_publishing-city')[0];
let publishingYearInput = document.querySelectorAll('.form__element__input_publishing-year')[0];
let monthBookCheckbox = document.querySelectorAll('.form__element__label__checkbox_description')[0];
let monthBookDescInput = document.querySelectorAll('.form__element__input_month-book-description')[0];
let priceCheckbox = document.querySelectorAll('.form__element__label__checkbox_price')[0];
let priceInput = document.querySelectorAll('.form__element__input_price')[0];
let bookAddingButton = document.querySelector('.form__element__button_book-adding');

let bookCover = document.querySelectorAll('.book-editing__cover .grid__item')[0];
let bookCoverAuthor = document.querySelectorAll('.grid__item__authortitle__author')[0];
let bookCoverTitle = document.querySelectorAll('.grid__item__authortitle__title')[0];
let bookCoverPublishing = document.querySelectorAll('.grid__item__publishing')[0];
let bookCoverMonthBook = document.querySelectorAll('.month-book')[0];
let bookCoverMonthBookDesc = document.querySelectorAll('.month-book__wrap__description')[0];
let stickerForPrice = document.querySelectorAll('.grid__item__sticker_price')[0];

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

    // Форма входа в админку
    let passwordInput = document.querySelector('.form__element__input_password');
    if (passwordInput != null) {
        passwordInput.focus();

        let enterButton = document.querySelector('.form__element__button_entering');
        enterButton.addEventListener('click', preventDefault);

        passwordInput.addEventListener('keyup', ()=>{
            if (passwordInput.value != '') {
                passwordInput.classList.remove('form__element__input_invalid');

                enterButton.removeEventListener('click', preventDefault);
                enterButton.classList.remove('form__element__button-disabled');
            }
            else {
                enterButton.addEventListener('click', preventDefault);
                enterButton.classList.add('form__element__button-disabled');
            }
        });
    }

    // Редактирование книги
    let onHandsCheckbox = document.querySelectorAll('.form__element__label__checkbox_on-hands');
    for (var i = 0; i < onHandsCheckbox.length; i++) {
        let id = document.querySelectorAll('.grid__item')[i].getAttribute('data-id');
        onHandsCheckbox[i].addEventListener('click', {handleEvent: toggleBookOnHands, number: i, id: id});
    }

    // Форма добавления книги
    titleInput.focus();
    titleInput.addEventListener('keyup', ()=>{
        if (titleInput.value != '') {
            titleInput.classList.remove('form__element__input_invalid');
            bookAddingButton.classList.remove('form__element__button-disabled');
        }
        else {
            bookAddingButton.classList.add('form__element__button-disabled');
        }

        if (monthBookCheckbox.checked == true && monthBookDescInput.value == '') {
            bookAddingButton.classList.add('form__element__button-disabled');
        }

        if (priceCheckbox.checked == true && priceInput.value == '') {
            bookAddingButton.classList.add('form__element__button-disabled');
        }

        bookCoverTitle.innerHTML = titleInput.value;
    });


    authorInput.addEventListener('keyup',()=>{
        if (authorInput.value != '') {
            bookCoverAuthor.style.display = 'block';
            bookCoverAuthor.innerHTML = authorInput.value;
        }
        else {
            bookCoverAuthor.style.display = 'none';
        }
    });


    let bookCoverPuslishingData = '';
    publishingCityInput.addEventListener('keyup', ()=>{
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

    publishingYearInput.onkeypress = allowDigit;
    publishingYearInput.addEventListener('keyup', ()=>{
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
        if (titleInput.value != '') {
            if (monthBookDescInput.value == '') {
                bookAddingButton.classList.toggle('form__element__button-disabled');
            }
        }

        if (priceCheckbox.checked == true && priceInput.value == '') {
            bookAddingButton.classList.add('form__element__button-disabled');
        }

        bookCover.classList.toggle('grid__item_month-book-color');

        if (bookCoverMonthBook.style.display == 'none') {
            bookCoverMonthBook.style.display = 'block';
        }
        else {
            bookCoverMonthBook.style.display = 'none';
        }
    });

    monthBookDescInput.addEventListener('keyup', ()=>{
        if (titleInput.value != '' && monthBookDescInput.value != '') {
            monthBookDescInput.classList.remove('form__element__input_invalid');
            bookAddingButton.classList.remove('form__element__button-disabled');
        }
        else {
            bookAddingButton.classList.add('form__element__button-disabled');
        }

        if (priceCheckbox.checked == true && priceInput.value == '') {
            bookAddingButton.classList.add('form__element__button-disabled');
        }

        bookCoverMonthBookDesc.innerHTML = monthBookDescInput.value;
    });


    priceCheckbox.addEventListener("click", toggleAppearingBlock);
    priceCheckbox.addEventListener("click", ()=>{
        if (titleInput.value != '') {
            if (priceInput.value == '') {
                bookAddingButton.classList.toggle('form__element__button-disabled');
            }
        }

        if (monthBookCheckbox.checked == true && monthBookDescInput.value == '') {
            bookAddingButton.classList.add('form__element__button-disabled');
        }

        if (stickerForPrice.style.display == 'none') {
            stickerForPrice.style.display = 'block';
        }
        else {
            stickerForPrice.style.display = 'none';
        }
    });

    priceInput.onkeypress = allowDigit;
    priceInput.addEventListener('keyup', ()=>{
        if (titleInput.value != '' && priceInput.value != '') {
            priceInput.classList.remove('form__element__input_invalid');
            bookAddingButton.classList.remove('form__element__button-disabled');
        }
        else {
            bookAddingButton.classList.add('form__element__button-disabled');
        }

        if (monthBookCheckbox.checked == true && monthBookDescInput.value == '') {
            bookAddingButton.classList.add('form__element__button-disabled');
        }

        if (priceInput.value == '') {
            stickerForPrice.innerHTML = '';
        }
        else {
            stickerForPrice.innerHTML = priceInput.value + '&thinsp;€';
        }
    });


    bookAddingButton.addEventListener("click", ()=>{
        event.preventDefault();
        addBook();
    });


    // Формы редактирования книги
    /*let  = document.querySelectorAll('.toggler');
    for (var i = 0; i < togglers.length; i++) {
        togglers[i].addEventListener('click', {handleEvent: toggleInput, number: i});
    }

    function toggleInput(e) {
        let input = document.querySelectorAll('.input')[this.number];

        if (input.style.display == 'none') {
            input.style.display = 'block';
        }
        else {
            input.style.display = 'none';
        }
    }*/
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
    let elementIdentifier = this.classList.value.split("checkbox_")[1]; // e.g. description

    let label = '.form__label_' + elementIdentifier;
    let appearingLabel = document.querySelector(label);

    let inputBlock = '.form__element_' + elementIdentifier;
    let appearingInputBlock = document.querySelector(inputBlock);

    let input = '.form__element_' + elementIdentifier + ' .form__element__input';

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
    // Обязательное поле
    let title = titleInput.value;

    // Если не заполнено поле — у него появляется фокус и обводка
    if (title == '') {
        titleInput.focus();
        titleInput.classList.add('form__element__input_invalid');
        return;
    }
    else {
        titleInput.classList.remove('form__element__input_invalid');
    }

    // Необязательные поля
    let author = authorInput.value;

    let publishingCity = publishingCityInput.value;

    let publishingYear = publishingYearInput.value;

    let publishing = publishingCity;
    if (publishingYear != '') {
        publishing += ', ' + publishingYear;
    }

    let monthBook = monthBookCheckbox.checked;
    let description = monthBookDescInput.value;
    if (monthBook == true) {
        monthBook = 1;

        if (description == '') {
            monthBookDescInput.focus();
            monthBookDescInput.classList.add('form__element__input_invalid');
            return;
        }
        else {
            monthBookDescInput.classList.remove('form__element__input_invalid');
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
            priceInput.classList.add('form__element__input_invalid');
            return;
        }
        else {
            priceInput.classList.remove('form__element__input_invalid');
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
                form.style.visibility = 'hidden';

                let alertSuccess = document.createElement('div');
                alertSuccess.className = "book-editing__form__success";
                alertSuccess.innerHTML = '<div class="book-editing__form__success__alert">Libro aggiunto al catalogo. <a class="book-editing__form__success__alert__returning pseudolink">Annulla</a></div><div class="book-editing__form__success__clearingWrap"><a class="book-editing__form__success__clearingWrap__link pseudolink">Aggiungere un altro libro…</a></div>';
                formWrap.appendChild(alertSuccess);

                document.querySelector('.book-editing__form__success__alert__returning').addEventListener("click", returnBookAddingForm);
                document.querySelector('.book-editing__form__success__clearingWrap__link').addEventListener("click", clearBookAddingForm);
            }
            else {
                console.log('Ошибка: ' + xhr.status);
            }
        }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
}

function returnBookAddingForm() {
    let title = titleInput.value;
    let author = authorInput.value;
    let publishingCity = publishingCityInput.value;
    let publishingYear = publishingYearInput.value;

    let publishing = publishingCity;
    if (publishingYear != '') {
        publishing += ', ' + publishingYear;
    }

    let monthBook = monthBookCheckbox.checked;
    let description = monthBookDescInput.value;
    if (monthBook == true) {
        monthBook = 1;
    }
    else {
        monthBook = 0;
        description = '';
    }

    let price = priceInput.value;
    if (price == '') {
        price = 0;
    }

    let xhr = new XMLHttpRequest();
    let params = 'title=' + title + '&author=' + author + '&publishing=' + publishing + '&price=' + price + '&monthBook=' + monthBook + '&description=' + description;

    xhr.open('POST', '../php/removeBook.php');
    xhr.onreadystatechange=()=>{
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                let alertSuccess = document.querySelector('.book-editing__form__success');
                formWrap.removeChild(alertSuccess);

                form.style.visibility = 'visible';
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
    let monthBookDescLabel = document.querySelector('.form__label_description');
    let monthBookDescInputBlock = document.querySelector('.form__element_description');
    if (monthBookDescInputBlock.style.display == 'block') {
        monthBookDescLabel.style.display = 'none';
        monthBookDescInputBlock.style.display = 'none';
    }

    priceCheckbox.checked = false;
    priceInput.value = '';
    let priceLabel = document.querySelector('.form__label_price');
    let priceInputBlock = document.querySelector('.form__element_price');
    if (priceInputBlock.style.display == 'block') {
        priceLabel.style.display = 'none';
        priceInputBlock.style.display = 'none';
    }

    let alertSuccess = document.querySelector('.book-editing__form__success');
    formWrap.removeChild(alertSuccess);

    bookCoverAuthor.innerHTML = '';
    bookCoverTitle.innerHTML = '';
    bookCoverPublishing.innerHTML = '';
    bookCoverMonthBookDesc.innerHTML = '';
    bookCoverMonthBook.style.display = 'none';
    bookCover.classList.remove('grid__item_month-book-color');
    stickerForPrice.innerHTML = '';
    stickerForPrice.style.display = 'none';
    form.style.visibility = 'visible';

    titleInput.focus();
}

function toggleBookOnHands(e) {
    let onHandsCheckbox = document.querySelectorAll('.form__element__label__checkbox_on-hands')[this.number];

    let onHandsStatus = 1;
    if (onHandsCheckbox.checked == false) {
        onHandsStatus = 0;
    }

    let xhr = new XMLHttpRequest();
    let params = 'id=' + this.id + '&onHandsStatus=' + onHandsStatus;

    xhr.open('POST', '../php/toggleBookOnHands.php');
    xhr.onreadystatechange=()=>{
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {

            }
            else {
                console.log('Ошибка: ' + xhr.status);
            }
        }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
}

function preventDefault() {
    event.preventDefault();
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

function allowDigit(e) {
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