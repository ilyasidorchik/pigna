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

    document.querySelector('.form__element__label-description').addEventListener("click", toggleAppearingBlock);
    document.querySelector('.form__element__label-price').addEventListener("click", toggleAppearingBlock);


    // Форма добавления книги
    let bookCover = document.querySelector('.book-adding__cover .grid__item');

    let authorInput = document.querySelector('.form__element__input-author');
    let bookCoverAuthorInput = document.querySelector('.grid__item__authortitle__author');

    let titleInput = document.querySelector('.form__element__input-title');
    let bookCoverTitleInput = document.querySelector('.grid__item__authortitle__title');

    let publishingCityInput = document.querySelector('.form__element__input-publishing-city');

    let bookCoverPublishingInput = document.querySelector('.grid__item__publishing');

    let publishingYearInput = document.querySelector('.form__element__input-publishing-year');

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

        bookCoverAuthorInput.innerHTML = authorInput.value;
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

        bookCoverTitleInput.innerHTML = titleInput.value;
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

        bookCoverPublishingInput.innerHTML = bookCoverPuslishingData;
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

        bookCoverPublishingInput.innerHTML = bookCoverPuslishingData;
    });


    document.querySelector('.form__element__label-price').addEventListener("click", toggleAppearingBlock);

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

    let publishingCityInput = document.querySelector('.form__element__input-publishing-city');
    let publishingCity = publishingCityInput.value;

    let publishingYearInput = document.querySelector('.form__element__input-publishing-year');
    let publishingYear = publishingYearInput.value;

    let publishing = publishingCity + publishingYear;


    // Необязательные поля
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