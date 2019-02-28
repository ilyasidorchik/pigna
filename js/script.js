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

    let openEditPanelLink = document.querySelectorAll('.grid__item__admin__editLinkWrap__link');
    for (var j = 0; j < openEditPanelLink.length; j++) {
        openEditPanelLink[j].addEventListener('click', {handleEvent: editBook, number: j});
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
        if (publishingCity != '') {
            publishing += ', ';
        }
        publishing += publishingYear;
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

function editBook(e) {
    let book = document.querySelectorAll('.grid__item')[this.number];

    let authortitle = book.querySelector('.grid__item__authortitle').getElementsByTagName('div').length;

    let author = '';
    if (authortitle == 2) {
        author = book.querySelector('.grid__item__authortitle__author').innerHTML;
    }
    let authorStatus = 'none';
    if (author != '') {
        authorStatus = 'block';
    }

    let title = book.querySelector('.grid__item__authortitle__title').innerHTML;

    let publishing = book.querySelector('.grid__item__publishing').innerHTML;
    let publishingCity = '';
    let publishingYear = '';

    if (publishing != '') {
        if (publishing.indexOf(', ') != -1) {
            publishingCity = publishing.split(', ')[0];
            publishingYear = publishing.split(', ')[1];
        }
        else {
            if (publishing.search(/[0-9]/) != -1) {
                publishingYear = publishing;
            }
            else {
                publishingCity = publishing;
            }
        }
    }

    let monthBookCheckbox = '';
    let monthBookClass = '';
    let monthBookStatus = 'none';
    let monthBookDesc = '';
    if (book.classList.contains('grid__item_month-book-color')) {
        monthBookCheckbox = 'checked';
        monthBookClass = 'grid__item_month-book-color';
        monthBookStatus = 'block';
        monthBookDesc = document.querySelector('.month-book__wrap__description').innerHTML;
    }

    let priceStatus = 'none';
    let priceCheckbox = '';
    let price = book.querySelector('.grid__item__sticker_price');
    if (price != null) {
        priceCheckbox = 'checked';
        priceStatus = 'block';
        price = price.innerHTML;
    }

    let page = document.querySelector('.page');
    let modal = document.createElement('div');
    modal.className = 'modal';
    modal.innerHTML = '<div class="book-editing"> <h2 class="h2">Modifica di una cartella di lavoro</h2> <div class="book-editing__form"> <form> <div class="form"> <div class="form__label"> <label for="title">Titolo</label> </div> <div class="form__element"> <input type="text" name="title" id="title" autofocus autocomplete="off" class="form__element__input form__element__input_title" value="' + title +'"> </div> <div class="form__label"> <label for="author">Autore</label> </div> <div class="form__element"> <input type="text" name="author" id="author" autocomplete="off" class="form__element__input form__element__input_author" value="' + author + '"> </div> <div class="form__label"> <label for="publishing-city">Città editore</label> </div> <div class="form__element"> <input type="text" name="publishing_city" id="publishing-city" autocomplete="off" class="form__element__input form__element__input_publishing-city" value="' + publishingCity + '"> </div> <div class="form__label" style="margin-top: -.95rem;"> <label for="publishing-year">Anno&nbsp;pub-<br>blicazione</label> </div> <div class="form__element form__element-short" style="margin-top: -.95rem;"> <input type="text" name="publishing_year" id="publishing-year" autocomplete="off" class="form__element__input form__element__input_publishing-year"  value="' + publishingYear + '"> </div> <div class="form__element" style="margin-top: -1.2rem;"> <label class="form__element__label"> <input type="checkbox" name="month_book" value="month_book" autocomplete="off" class="form__element__label__checkbox form__element__label__checkbox_description" ' + monthBookCheckbox + '> <span class="form__element__label__fake-checkbox"></span> Libro del mese </label> </div> <div class="form__label form__close-to-checkbox form__label_description" style="display: ' + monthBookStatus + ';"> <label for="book_description">Descri-<br>zione</label> </div> <div class="form__element form__close-to-checkbox form__element_description" style="display: ' + monthBookStatus + ';margin-bottom: -.3rem;"> <textarea name="book_description" id="book_description" class="form__element__input form__element__textarea form__element__input_month-book-description">' + monthBookDesc + '</textarea> </div> <div class="form__element" style="margin-top: -.3rem;"> <label class="form__element__label"> <input type="checkbox" name="book_for_sale" value="book_for_sale" autocomplete="off" class="form__element__label__checkbox form__element__label__checkbox_price" ' + priceCheckbox + '> <span class="form__element__label__fake-checkbox"></span> In vendita </label> </div> <div class="form__label form__close-to-checkbox form__label_price" style="display: ' + priceStatus + ';"> <label for="price">Prezzo</label> </div> <div class="form__element form__close-to-checkbox form__element_price" style="display: ' + priceStatus + ';"> <div class="form__element__wrap-for-price"> <input type="text" name="price" id="price" autocomplete="off" class="form__element__input form__element__wrap-for-price__number form__element__input_price" value="' + price + '"> <div class="form__element__wrap-for-price__currency-sign">€</div> </div> </div> <div class="form__element" style="display: none;"> <button class="form__element__button form__element__button_book-adding form__element__button-disabled">Aggiungere</button> </div> </div> </form> </div> <div class="book-editing__cover"> <div class="grid__item ' + monthBookClass + '"> <div class="grid__item__authortitle"> <div class="grid__item__authortitle__author" style="display: ' + authorStatus + ';">' + author + '</div> <div class="grid__item__authortitle__title">' + title + '</div> </div> <div class="grid__item__publishing">' + publishing + '</div> <div class="grid__item__sticker grid__item__sticker_price" style="display: ' + priceStatus + ';">' + price + '</div> </div> </div> <div class="month-book" style="display: ' + monthBookStatus + ';"> <div class="month-book__wrap"> <div class="month-book__wrap__label"> <span class="month-book__wrap__label__text">Libro del mese</span> </div> <p class="month-book__wrap__description">' + monthBookDesc + '</p> </div> </div> <a class="book-editing__delete" title="Rimuovere"><?xml version="1.0" encoding="iso-8859-1"?> <!-- Generator: Adobe Illustrator 16.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0) --> <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"> <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 459 459" style="enable-background:new 0 0 459 459;" xml:space="preserve" class="book-editing__delete__icon"> <g> <g> <path class="book-editing__delete__icon__path" d="M76.5,408c0,28.05,22.95,51,51,51h204c28.05,0,51-22.95,51-51V102h-306V408z M408,25.5h-89.25L293.25,0h-127.5l-25.5,25.5 H51v51h357V25.5z"/> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg></a></div>';

    page.appendChild(modal);
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