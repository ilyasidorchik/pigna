let searchForm = document.querySelector('.search__form form');
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
    let books = document.querySelectorAll('.grid')[0];
    let footer = document.querySelector('.footer');

    if (searchInput != null) {
        if (document.documentElement.clientWidth < 711) {
            searchInput.placeholder = 'Cercare nella biblioteca della Pigna';
        }
        else {
            searchInput.placeholder = 'Cercare libri nella piccola biblioteca della Pigna';
        }
    }

    let screen = document.documentElement.clientWidth;
    var bookEditing = document.querySelector('.book-editing');
    var bookEditingForm = document.querySelector('.book-editing__form');
    var bookEditingCover = document.querySelector('.book-editing__cover');
    var bookEditingMonthBook = document.querySelector('.book-editing__month-book');
    if (bookEditing != null && bookEditingForm != null && bookEditingCover != null && bookEditingMonthBook != null) {
        if (screen < 892) {
            bookEditing.insertBefore(bookEditingCover, bookEditingForm);
            bookEditing.insertBefore(bookEditingMonthBook, bookEditingForm);
        }
        else {
            bookEditing.appendChild(bookEditingCover);
            bookEditing.appendChild(bookEditingMonthBook);
        }

        let publishingYearLabel = document.querySelector('.form__label__label_publishing-year');
        if (screen < 535) {
            publishingYearLabel.innerHTML = 'Anno pubblicazione';
        }
        else {
            publishingYearLabel.innerHTML = 'Anno&nbsp;pub-<br>blicazione';
        }

        let descriptionLabel = document.querySelector('.form__label__label_description');
        if (screen < 535) {
            descriptionLabel.innerHTML = 'Descrizione';
        }
        else {
            descriptionLabel.innerHTML = 'Descri-<br>zione';
        }
    }

    let linkToBookAdding = document.querySelector('.grid__item_link-to-book-adding');
    if (linkToBookAdding != null) {
        if (screen < 535) {
            books.insertBefore(linkToBookAdding, books.firstChild);
        }
        else {
            if (screen < 711) {
                books.insertBefore(linkToBookAdding, books.children[3]);
            }
            else {
                if (screen < 892) {
                    books.insertBefore(linkToBookAdding, books.children[4]);
                }
                else {
                    if (screen < 1060) {
                        books.insertBefore(linkToBookAdding, books.children[5]);
                    }
                    else {
                        if (screen < 1230) {
                            books.insertBefore(linkToBookAdding, books.children[6]);
                        }
                        else {
                            books.insertBefore(linkToBookAdding, books.children[7]);
                        }
                    }
                }
            }
        }
    }

    window.addEventListener("resize", () => {
        screen = document.documentElement.clientWidth;

        if (searchInput != null) {
            if (screen  < 711) {
                searchInput.placeholder = 'Cercare nella biblioteca della Pigna';
            }
            else {
                searchInput.placeholder = 'Cercare libri nella piccola biblioteca della Pigna';
            }
        }

        if (linkToBookAdding != null) {
            if (screen < 535) {
                books.insertBefore(linkToBookAdding, books.firstChild);
            }
            else {
                if (screen < 711) {
                    books.insertBefore(linkToBookAdding, books.children[2]);
                }
                else {
                    if (screen < 892) {
                        books.insertBefore(linkToBookAdding, books.children[3]);
                    }
                    else {
                        if (screen < 1060) {
                            books.insertBefore(linkToBookAdding, books.children[4]);
                        }
                        else {
                            if (screen < 1230) {
                                books.insertBefore(linkToBookAdding, books.children[5]);
                            }
                            else {
                                books.insertBefore(linkToBookAdding, books.children[6]);
                            }
                        }
                    }
                }
            }
        }

        if (bookEditing != null && bookEditingForm != null && bookEditingCover != null && bookEditingMonthBook != null) {
            if (screen < 892) {
                bookEditing.insertBefore(bookEditingCover, bookEditingForm);
                bookEditing.insertBefore(bookEditingMonthBook, bookEditingForm);
            }
            else {
                bookEditing.appendChild(bookEditingCover);
                bookEditing.appendChild(bookEditingMonthBook);
            }

            let publishingYearLabel = document.querySelector('.form__label__label_publishing-year');
            if (screen < 535) {
                publishingYearLabel.innerHTML = 'Anno pubblicazione';
            }
            else {
                publishingYearLabel.innerHTML = 'Anno&nbsp;pub-<br>blicazione';
            }

            let descriptionLabel = document.querySelector('.form__label__label_description');
            if (screen < 535) {
                descriptionLabel.innerHTML = 'Descrizione';
            }
            else {
                descriptionLabel.innerHTML = 'Descri-<br>zione';
            }
        }
    });

    if (searchForm != null) {
        searchForm.addEventListener('keydown', () => {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        });
    }

    // Поиск по началу печати
    if (searchInput != null) {
        window.addEventListener('keydown', (e) => {
            if (e.ctrlKey || e.altKey || e.metaKey) return;

            searchInput.focus();
        });

        searchInput.addEventListener('keyup', () => {
            bookTitle = searchInput.value;
            if (bookTitle.length != 1) {
                event.preventDefault();
                searchBook(bookTitle);
            }
        });
    }

    // Футер
    if (footer != null) {
        footer.addEventListener('mouseover', ()=>{
            screen = document.documentElement.clientWidth;

            if (screen < 535) {
                //books.insertBefore(linkToBookAdding, books.firstChild);
            }
            else {
                if (screen < 711) {
                    //books.insertBefore(linkToBookAdding, books.children[2]);
                }
                else {
                    if (screen < 892) {
                        footer.style.animation = 'closeFooterCol5 .35s linear';
                    }
                    else {
                        if (screen < 1060) {
                            footer.style.animation = 'closeFooterCol5 .35s linear';
                        }
                        else {
                            footer.style.animation = 'closeFooter .25s linear';
                        }
                    }
                }
            }
        });
    }

    // Форма входа в админку
    let passwordInput = document.querySelector('.form__element__input_password');
    if (passwordInput != null) {
        passwordInput.focus();

        let enterButton = document.querySelector('.form__element__button_entering');
        enterButton.addEventListener('click', preventDefault);

        passwordInput.addEventListener('keyup', () => {
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
    let gridItems = document.querySelectorAll('.page.admin .grid__item[data-id]');
    let onHandsCheckbox = document.querySelectorAll('.form__element__label__checkbox_on-hands');
    for (let i = 0; i < gridItems.length; i++) {
        let id = document.querySelectorAll('.grid__item[data-id]')[i].getAttribute('data-id');
        gridItems[i].addEventListener('click', {handleEvent: openEditPage, number: i}, true);

        gridItems[i].addEventListener('mouseover', (e)=> {
            gridItems[i].classList.add('grid__item_hover');

            if (e.target.tagName == 'LABEL' || e.target.tagName == 'SPAN' || e.target.tagName == 'INPUT') {
                gridItems[i].classList.remove('grid__item_hover');
            }
        });
        gridItems[i].addEventListener('mouseout', ()=> {
            gridItems[i].classList.remove('grid__item_hover');
        });

        onHandsCheckbox[i].addEventListener('click', {handleEvent: toggleBookOnHands, number: i, id: id}, true);
    }

    // Форма добавления книги
    if (document.location.pathname == '/+/') {
        titleInput.focus();

        titleInput.addEventListener('keyup', () => {
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

            let title = titleInput.value;

            let xhr = new XMLHttpRequest();
            let params = 'str=' + title;

            xhr.open('POST', '../php/typograf.php');
            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        bookCoverTitle.innerHTML = xhr.responseText;
                    }
                    else
                        console.log('Ошибка: ' + xhr.status);
                }
            };
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(params);
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

            let description = monthBookDescInput.value;

            let xhr = new XMLHttpRequest();
            let params = 'str=' + description;

            xhr.open('POST', '../php/typograf.php');
            xhr.onreadystatechange=()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        bookCoverMonthBookDesc.innerHTML = xhr.responseText;
                    }
                    else
                        console.log('Ошибка: ' + xhr.status);
                }
            };
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(params);
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

    // Редактирование книги
    if (document.location.pathname == '/edit/') {
        let url = document.location.search;
        let id = url.replace('?book=', '');

        authorInput = document.querySelector('.form__element__input_author');
        titleInput = document.querySelector('.form__element__input_title');
        publishingCityInput = document.querySelector('.form__element__input_publishing-city');
        publishingYearInput = document.querySelector('.form__element__input_publishing-year');
        monthBookCheckbox = document.querySelector('.form__element__label__checkbox_description');
        monthBookDescInput = document.querySelector('.form__element__input_month-book-description');
        priceCheckbox = document.querySelector('.form__element__label__checkbox_price');
        priceInput = document.querySelector('.form__element__input_price');
        bookAddingButton = document.querySelector('.form__element__button_book-adding');

        bookCover = document.querySelector('.book-editing__cover .grid__item');
        bookCoverAuthor = document.querySelector('.grid__item__authortitle__author');
        bookCoverTitle = document.querySelector('.grid__item__authortitle__title');
        bookCoverPublishing = document.querySelector('.grid__item__publishing');
        bookCoverMonthBook = document.querySelector('.month-book');
        bookCoverMonthBookDesc = document.querySelector('.month-book__wrap__description');
        stickerForPrice = document.querySelector('.grid__item__sticker_price');


        // Подстановка данных, которые не обновились для читателя
        let titleSaved = localStorage.getItem('title' + id);
        if (titleSaved != null) {
            titleInput.value = titleSaved;

            bookCoverTitle.innerHTML = titleSaved;

            let title = titleInput.value;
            let xhrTypograf = new XMLHttpRequest();
            let params = 'str=' + title;
            xhrTypograf.open('POST', '../php/typograf.php');
            xhrTypograf.onreadystatechange = () => {
                if (xhrTypograf.readyState === 4) {
                    if (xhrTypograf.status === 200) {
                        bookCoverTitle.innerHTML = xhrTypograf.responseText;
                    }
                    else
                        console.log('Ошибка: ' + xhrTypograf.status);
                }
            };
            xhrTypograf.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhrTypograf.send(params);

            let savingInfo = document.createElement('div');
            savingInfo.className = "form__element__warning-small";
            savingInfo.innerHTML = localStorage.getItem('savingTitleInfo' + id);
            titleInput.parentNode.appendChild(savingInfo);
        }

        let authorSaved = localStorage.getItem('author' + id);
        if (authorSaved != null) {
            authorInput.value = authorSaved;

            let savingInfo = document.createElement('div');
            savingInfo.className = "form__element__warning-small";
            savingInfo.innerHTML = localStorage.getItem('savingAuthorInfo' + id);
            authorInput.parentNode.appendChild(savingInfo);

            if (authorInput.value != '') {
                bookCoverAuthor.style.display = 'block';
                bookCoverAuthor.innerHTML = authorInput.value;
            }
            else {
                bookCoverAuthor.style.display = 'none';
            }
        }

        let publishingCitySaved = localStorage.getItem('publishingCity' + id);
        if (publishingCitySaved != null) {
            publishingCityInput.value = publishingCitySaved;

            let savingInfo = document.createElement('div');
            savingInfo.className = "form__element__warning-small";
            savingInfo.innerHTML = localStorage.getItem('savingPublishingCityInfo' + id);
            publishingCityInput.parentNode.appendChild(savingInfo);
        }

        let publishingYearSaved = localStorage.getItem('publishingYear' + id);
        if (publishingYearSaved != null) {
            publishingYearInput.value = publishingYearSaved;

            let savingInfo = document.createElement('div');
            savingInfo.className = "form__element__warning-small";
            savingInfo.innerHTML = localStorage.getItem('savingPublishingYearInfo' + id);
            publishingYearInput.parentNode.appendChild(savingInfo);
        }

        if (publishingCitySaved != null || publishingYearSaved != null) {
            if (publishingYearInput.value == '') {
                bookCoverPublishing.innerHTML = publishingCityInput.value;
            }
            else {
                if (publishingCityInput.value == '') {
                    bookCoverPublishing.innerHTML = publishingYearInput.value;
                }
                else {
                    bookCoverPublishing.innerHTML = publishingCityInput.value + ', ' + publishingYearInput.value;
                }
            }
        }

        let monthBookStatusSaved = localStorage.getItem('monthBookStatus' + id);
        if (monthBookStatusSaved != null) {
            if (monthBookStatusSaved == '0') {
                if (monthBookCheckbox.checked != false) {
                    monthBookCheckbox.checked = false;
                    toggleAppearingBlock(monthBookCheckbox);
                    bookCover.classList.toggle('grid__item_month-book-color');
                    bookCoverMonthBook.style.display = 'none';
                }
            }
            else {
                if (monthBookCheckbox.checked != true) {
                    monthBookCheckbox.checked = true;
                    toggleAppearingBlock(monthBookCheckbox);
                    bookCover.classList.toggle('grid__item_month-book-color');
                    bookCoverMonthBook.style.display = 'block';
                }
            }

            let monthBookDescSaved = localStorage.getItem('monthBookDesc' + id);
            if (monthBookDescSaved != null) {
                bookCoverMonthBookDesc.innerHTML = monthBookDescSaved;
                let description = monthBookDescSaved;
                let xhrTypograf = new XMLHttpRequest();
                let params = 'str=' + description;
                xhrTypograf.open('POST', '../php/typograf.php');
                xhrTypograf.onreadystatechange = () => {
                    if (xhrTypograf.readyState === 4) {
                        if (xhrTypograf.status === 200) {
                            bookCoverMonthBookDesc.innerHTML = xhrTypograf.responseText;
                        }
                        else
                            console.log('Ошибка: ' + xhrTypograf.status);
                    }
                };
                xhrTypograf.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhrTypograf.send(params);

                monthBookDescInput.value = monthBookDescSaved;

                let savingInfo = document.createElement('div');
                savingInfo.className = "form__element__warning-small form__element__warning-small-lower";
                savingInfo.innerHTML = localStorage.getItem('savingMonthBookInfo' + id);
                monthBookDescInput.parentNode.appendChild(savingInfo);
            }
        }

        let priceSaved = localStorage.getItem('price' + id);
        if (priceSaved != null) {
            if (priceSaved == '0') {
                if (priceCheckbox.checked != false) {
                    priceCheckbox.checked = false;
                    toggleAppearingBlock(priceCheckbox);
                    stickerForPrice.style.display = 'none';
                }
            }
            else {
                if (priceCheckbox.checked != true) {
                    priceCheckbox.checked = true;
                    toggleAppearingBlock(priceCheckbox);
                    stickerForPrice.style.display = 'block';
                }

                priceInput.value = priceSaved;
                stickerForPrice.innerHTML = priceSaved + '&nbsp;€';

                let savingInfo = document.createElement('div');
                savingInfo.className = "form__element__warning-small";
                savingInfo.innerHTML = localStorage.getItem('savingPriceInfo' + id);
                priceInput.parentNode.appendChild(savingInfo);
            }
        }


        let date = new Date();
        let day = date.getDate();
        let month = convertMonth(date.getMonth() + 1);
        date = "Salvato il&nbsp;" + day + "&nbsp;" + month;

        titleInput.addEventListener('keyup', ()=>{
            if (titleInput.value != '') {
                titleInput.classList.remove('form__element__input_invalid');
                bookAddingButton.classList.remove('form__element__button-disabled');
            }
            else {
                titleInput.classList.add('form__element__input_invalid');
                bookAddingButton.classList.add('form__element__button-disabled');
            }

            if (monthBookCheckbox.checked == true && monthBookDescInput.value == '') {
                bookAddingButton.classList.add('form__element__button-disabled');
            }

            if (priceCheckbox.checked == true && priceInput.value == '') {
                bookAddingButton.classList.add('form__element__button-disabled');
            }

            let title = titleInput.value;
            let xhrTypograf = new XMLHttpRequest();
            let params = 'str=' + title;
            xhrTypograf.open('POST', '../php/typograf.php');
            xhrTypograf.onreadystatechange = () => {
                if (xhrTypograf.readyState === 4) {
                    if (xhrTypograf.status === 200) {
                        bookCoverTitle.innerHTML = xhrTypograf.responseText;
                    }
                    else
                        console.log('Ошибка: ' + xhrTypograf.status);
                }
            };
            xhrTypograf.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhrTypograf.send(params);

            // Добавление в локальное хранилище
            localStorage.setItem('title' + id, title);
            localStorage.setItem('savingTitleInfo' + id, date);
        });

        authorInput.addEventListener('keyup',()=>{
            if (authorInput.value != '') {
                bookCoverAuthor.style.display = 'block';
                bookCoverAuthor.innerHTML = authorInput.value;
            }
            else {
                bookCoverAuthor.style.display = 'none';
            }

            // Добавление в локальное хранилище
            localStorage.setItem('author' + id, authorInput.value);
            localStorage.setItem('savingAuthorInfo' + id, date);
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

            // Добавление в локальное хранилище
            localStorage.setItem('publishingCity' + id, publishingCityInput.value);
            localStorage.setItem('savingPublishingCityInfo' + id, date);
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

            // Добавление в локальное хранилище
            localStorage.setItem('publishingYear' + id, publishingYearInput.value);
            localStorage.setItem('savingPublishingYearInfo' + id, date);
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

            let monthBookStatus;
            if (monthBookCheckbox.checked == false) {
                monthBookStatus = 0;
            }
            else {
                if (bookCoverMonthBookDesc.innerHTML == '') {
                    monthBookStatus = 0;
                }
                else {
                    monthBookStatus = 1;
                }
            }

            // Добавление в локальное хранилище
            localStorage.setItem('monthBookStatus' + id, monthBookStatus);
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

            let description = monthBookDescInput.value;
            let xhrTypograf = new XMLHttpRequest();
            let params = 'str=' + description;
            xhrTypograf.open('POST', '../php/typograf.php');
            xhrTypograf.onreadystatechange = () => {
                if (xhrTypograf.readyState === 4) {
                    if (xhrTypograf.status === 200) {
                        bookCoverMonthBookDesc.innerHTML = xhrTypograf.responseText;
                    }
                    else
                        console.log('Ошибка: ' + xhrTypograf.status);
                }
            };
            xhrTypograf.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhrTypograf.send(params);

            let monthBookStatus;
            if (monthBookCheckbox.checked == false) {
                monthBookStatus = 0;
            }
            else {
                if (bookCoverMonthBookDesc.innerHTML == '') {
                    monthBookStatus = 0;
                }
                else {
                    monthBookStatus = 1;
                }
            }

            if (monthBookCheckbox.checked == true && bookCoverMonthBookDesc.innerHTML != '') {
                monthBookStatus = 1;
            }
            else {
                monthBookStatus = 0;
            }

            // Добавление в локальное хранилище
            localStorage.setItem('monthBookStatus' + id, monthBookStatus);
            localStorage.setItem('monthBookDesc' + id, description);
            localStorage.setItem('savingMonthBookInfo' + id, date);
        });


        priceCheckbox.addEventListener("click", toggleAppearingBlock);
        priceCheckbox.addEventListener("click", ()=>{
            if (titleInput.value != '') {
                if (priceCheckbox.checked == true && priceInput.value == '') {
                    bookAddingButton.classList.add('form__element__button-disabled');
                }
                else {
                    bookAddingButton.classList.remove('form__element__button-disabled');
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

            if (priceCheckbox.checked == true && priceInput.value != '') {
                stickerForPrice.innerHTML = priceInput.value + '&thinsp;€';
            }
            else {
                stickerForPrice.innerHTML = '';
            }

            let price = 0;
            if (priceCheckbox.checked == true && priceInput.value != '') {
                price = priceInput.value;
            }

            // Добавление в локальное хранилище
            localStorage.setItem('price' + id, price);
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

            if (priceInput.value != '') {
                stickerForPrice.innerHTML = priceInput.value + '&thinsp;€';
            }
            else {
                stickerForPrice.innerHTML = '';
            }

            let price = 0;
            if (priceInput.value != '') {
                price = priceInput.value;
            }

            // Добавление в локальное хранилище
            localStorage.setItem('price' + id, price);
            localStorage.setItem('savingPriceInfo' + id, date);
        });

        bookAddingButton.addEventListener("click", ()=>{
            event.preventDefault();
            editBook(id);
        });

        // Удаление книги
        let deleteLink = document.querySelector('.form__element__remove-link');
        deleteLink.addEventListener('click', {handleEvent: removeBook, id: id});
    }
}

function searchBook(bookTitle) {
    let xhr = new XMLHttpRequest();
    let params = 'bookTitle=' + bookTitle;
    let grid = document.querySelectorAll('.grid')[0];

    xhr.open('POST', '../php/search.php');
    xhr.onreadystatechange=()=>{
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                grid.innerHTML = xhr.responseText;
                let gridItemCount = grid.querySelectorAll('.grid__item').length;

                let books = grid;
                let linkToBookAdding = document.querySelector('.grid__item_link-to-book-adding');
                if (linkToBookAdding != null) {
                    if (screen < 535) {
                        books.insertBefore(linkToBookAdding, books.firstChild);
                    }
                    else {
                        if (screen < 711) {
                            books.insertBefore(linkToBookAdding, books.children[3]);
                        }
                        else {
                            if (screen < 892) {
                                books.insertBefore(linkToBookAdding, books.children[4]);
                            }
                            else {
                                if (screen < 1060) {
                                    books.insertBefore(linkToBookAdding, books.children[5]);
                                }
                                else {
                                    if (screen < 1230) {
                                        books.insertBefore(linkToBookAdding, books.children[6]);
                                    }
                                    else {
                                        books.insertBefore(linkToBookAdding, books.children[7]);
                                    }
                                }
                            }
                        }
                    }
                }

                if (xhr.responseText == '<div class="grid__item grid__item_link-to-book-adding"><a href="+/" class="grid__item_link-to-book-adding__link"></a><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 74.56 73.28" class="grid__item_link-to-book-adding__icon"><defs><style>.a{fill:url(#a);}</style><linearGradient id="a" x1="37.46" y1="0.86" x2="37.46" y2="74.14" gradientUnits="userSpaceOnUse"><stop offset="0" class="grid__item_link-to-book-adding__icon__gradient-color grid__item_link-to-book-adding__icon__gradient-color_1"/><stop offset="1" class="grid__item_link-to-book-adding__icon__gradient-color grid__item_link-to-book-adding__icon__gradient-color_2"/></linearGradient></defs><title>plus-bigger</title><path class="a" d="M32.66,42H.18V33H32.66V.86h9.6V33H74.74v9H42.26V74.14h-9.6Z" transform="translate(-0.18 -0.86)"/></svg></div>') {
                    linkToBookAdding.style.display = 'none';
                }
                else {
                    linkToBookAdding.style.display = 'flex';
                }

                // Редактирование книги
                let gridItems = document.querySelectorAll('.page.admin .grid__item[data-id]');
                let onHandsCheckbox = document.querySelectorAll('.form__element__label__checkbox_on-hands');
                for (let i = 0; i < gridItems.length; i++) {
                    let id = document.querySelectorAll('.grid__item[data-id]')[i].getAttribute('data-id');
                    gridItems[i].addEventListener('click', {handleEvent: openEditPage, number: i}, true);

                    gridItems[i].addEventListener('mouseover', (e)=> {
                        gridItems[i].classList.add('grid__item_hover');

                        if (e.target.tagName == 'LABEL' || e.target.tagName == 'SPAN' || e.target.tagName == 'INPUT') {
                            gridItems[i].classList.remove('grid__item_hover');
                        }
                    });
                    gridItems[i].addEventListener('mouseout', ()=> {
                        gridItems[i].classList.remove('grid__item_hover');
                    });

                    onHandsCheckbox[i].addEventListener('click', {handleEvent: toggleBookOnHands, number: i, id: id}, true);
                }

                let footer = document.querySelector('.footer');
                if (xhr.responseText == '' || gridItemCount <= 7) {
                    footer.classList.add('footer_bottom-sticked');
                }
                else {
                    if (footer.classList.contains('footer_bottom-sticked')) {
                        footer.classList.remove('footer_bottom-sticked');
                    }
                }
            }
            else
                console.log('Ошибка: ' + xhr.status);
        }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
}

function toggleAppearingBlock(e) {
    let elementIdentifier;
    if (e.type != 'checkbox') {
        elementIdentifier = this.classList.value.split("checkbox_")[1]; // e.g. description
    }
    else {
        elementIdentifier = e.classList.value.split("checkbox_")[1]; // e.g. description
    }

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
                form.style.display = 'none';

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

function editBook(id) {
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
        price = 0;
    }

    let params = 'id=' + id + '&title=' + title + '&author=' + author + '&publishing=' + publishing + '&price=' + price + '&monthBook=' + monthBook + '&description=' + description;

    let xhr = new XMLHttpRequest();

    xhr.open('POST', '../php/editBook.php');
    xhr.onreadystatechange=()=>{
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                window.location.replace('http://accademiapigna.sidorchik.ru/');
            }
            else {
                console.log('Ошибка: ' + xhr.status);
            }
        }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);

    localStorage.removeItem('title' + id);
    localStorage.removeItem('savingTitleInfo' + id);
    localStorage.removeItem('author' + id);
    localStorage.removeItem('savingAuthorInfo' + id);
    localStorage.removeItem('publishingYear' + id);
    localStorage.removeItem('savingPublishingYearInfo' + id);
    localStorage.removeItem('publishingCity' + id);
    localStorage.removeItem('savingPublishingCityInfo' + id);
    localStorage.removeItem('monthBookStatus' + id);
    localStorage.removeItem('monthBookDesc' + id);
    localStorage.removeItem('savingMonthBookInfo' + id);
    localStorage.removeItem('price' + id);
    localStorage.removeItem('savingPriceInfo' + id);
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
        description= '';
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

                form.style.display = 'grid';
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
    form.style.display = 'grid';

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

function openEditPage(e) {
    let book = document.querySelectorAll('.grid__item[data-id]')[this.number];
    let id = book.getAttribute('data-id');
    if (e.target.tagName == 'LABEL' || e.target.tagName == 'SPAN' || e.target.tagName == 'INPUT') {

    }
    else {
        window.location.replace('http://accademiapigna.sidorchik.ru/edit/?book=' + id);
    }
}

function removeBook() {
    let xhr = new XMLHttpRequest();
    let params = 'id=' + this.id;

    xhr.open('POST', '../php/removeBook.php');
    xhr.onreadystatechange=()=>{
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                let form = document.querySelector('.form');
                form.style.display = 'none';

                let alertSuccess = document.createElement('div');
                alertSuccess.className = "book-editing__form__success book-editing__form__success-remove";
                alertSuccess.innerHTML = '<div class="book-editing__form__success__alert">Libro eliminato. <a class="book-editing__form__success__alert__removing pseudolink">Annulla</a></div>';
                formWrap.appendChild(alertSuccess);

                let returnLink = document.querySelector('.book-editing__form__success__alert__removing');
                returnLink.addEventListener('click', {handleEvent: returnBook, id: this.id});
            }
            else {
                console.log('Ошибка: ' + xhr.status);
            }
        }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
}

function returnBook() {
    let title = document.querySelector('.grid__item__authortitle__title').innerHTML;

    let author = '';
    let authorBlock = document.querySelector('.grid__item__authortitle__author');
    if (authorBlock != null) {
        author = authorBlock.innerHTML;
    }

    let publishing = document.querySelector('.grid__item__publishing').innerHTML;

    let monthBookBlock = document.querySelector('.month-book');
    let description = '';
    let monthBook = 0;
    if (monthBookBlock.style.display == 'block') {
        monthBook = 1;
        description = document.querySelector('.month-book__wrap__description').innerHTML;
    }

    let price = 0;
    let priceBlock = document.querySelector('.grid__item__sticker_price');
    if (priceBlock.style.display == 'block') {
        price = priceBlock.innerHTML;
    }


    // Добавление удалённой книги в базу данных
    let xhr = new XMLHttpRequest();
    let params = 'id=' + this.id + '&title=' + title + '&author=' + author + '&publishing=' + publishing + '&price=' + price + '&monthBook=' + monthBook + '&description=' + description;
    xhr.open('POST', '../php/addBook.php');
    xhr.onreadystatechange=()=>{
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                let form = document.querySelector('.form');
                form.style.display = 'grid';

                let alertSuccess = document.querySelector('.book-editing__form__success');
                formWrap.removeChild(alertSuccess);
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

    if (publishingYearInput.value == '' && chr == '0') {
        return false;
    }
}

function convertMonth(month) {
    switch (month) {
        case 1:
            return 'gen';
            break;
        case 2:
            return 'feb';
            break;
        case 3:
            return 'mar';
            break;
        case 4:
            return 'apr';
            break;
        case 5:
            return 'mag';
            break;
        case 6:
            return 'giu';
            break;
        case 7:
            return 'lug';
            break;
        case 8:
            return 'ago';
            break;
        case 9:
            return 'set';
            break;
        case 10:
            return 'ott';
            break;
        case 11:
            return 'nov';
            break;
        case 12:
            return 'dic';
            break;
    }
}