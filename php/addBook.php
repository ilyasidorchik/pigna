<?php
    require 'functions.php';

    $id = $_POST['id'];
    if ($id == '')
        $id = 'NULL';

    $title = str_replace("'", "\'", $_POST['title']);
    $titleTypografed = typograf($title);

    $author = str_replace("'", "\'", $_POST['author']);
    if ($author != '')
        $authorTypografed = typograf($author);

    $publishing = $_POST['publishing'];
    $price = $_POST['price'];
    $monthBook = $_POST['monthBook'];

    $description = str_replace("'", "\'", $_POST['description']);
    if ($description != '')
        $description = typograf($description);

    $addingDatetime = date('Y-m-d H:i:s');

    $ini = parse_ini_file('../app.ini', true);

    $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
    mysqli_set_charset($link, 'utf8');

    // При добавлении новой книги месяца, старая книга месяца теряет свой статус
    if ($monthBook == 1)
        mysqli_query($link, "UPDATE catalogue SET monthBook = 0 WHERE monthBook = 1");


    if ($id == 'NULL') {
        // Добавление книги в базу данных
        mysqli_query($link, "INSERT INTO catalogue (id, title, author, publishing, price, monthBook, description, addingDatetime, new) VALUES ('$id', '$titleTypografed', '$authorTypografed', '$publishing', '$price', '$monthBook', '$description', '$addingDatetime', '1')");

        // Получение id добавленной книги
        $result = mysqli_query($link, "SELECT id FROM catalogue WHERE title = '$titleTypografed' AND author = '$authorTypografed' AND publishing = '$publishing' AND price = '$price' AND monthBook = '$monthBook' AND description = '$description' AND addingDatetime = '$addingDatetime' AND new = '1'");
        $row = mysqli_fetch_assoc($result);
        $addedBookID = $row['id'];
        echo $addedBookID;

        // Поддержка новинок
        supportNewBooksByCountAndDate($link, $addingDatetime, $addedBookID);
    }
    else {
        // Возвращение книги в базу данных
        mysqli_query($link, "INSERT INTO catalogue (id, title, author, publishing, price, monthBook, description, addingDatetime, new) VALUES ('$id', '$titleTypografed', '$authorTypografed', '$publishing', '$price', '$monthBook', '$description', '$addingDatetime', '0')");

        // Поддержка новинок
        supportNewBooksByDate($link);
    }