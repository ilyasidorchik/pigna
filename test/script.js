let addPersonBtn = document.querySelector('.btn_add-person');
if (addPersonBtn != null) {
    addPersonBtn.addEventListener('click', addPerson);
}

function addPerson() {
    event.preventDefault();
    let fullNameInput = document.querySelector('.input_full-name');
    let params = 'fullName=' + fullNameInput.value;

    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../php/addPerson.php');
    xhr.onreadystatechange = () => {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                if (fullNameInput.value !== '') {
                    let peopleList = document.querySelector('.people-list');
                    let newPerson = document.createElement('li');
                    newPerson.innerHTML = fullNameInput.value;
                    peopleList.appendChild(newPerson);

                    fullNameInput.value = '';
                }
            }
            else {
                console.log('Ошибка: ' + xhr.status);
            }
        }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
}

// Остальные скрипты сайта