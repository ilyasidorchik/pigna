<?php

require 'functions.php';

$ini = parse_ini_file('../app.ini', true);

if (password_verify($ini[admin][password], $_COOKIE['admin_rights'])) {
    $id = $_POST['id'];

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

    $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
    mysqli_set_charset($link, 'utf8');

    // При добавлении новой книги месяца, старая книга месяца теряет свой статус
    if ($monthBook == 1)
        mysqli_query($link, "UPDATE catalogue SET monthBook = 0 WHERE monthBook = 1");

    // Добавление новой книги в базу данных
    mysqli_query($link, "UPDATE catalogue SET title = '$titleTypografed', author = '$authorTypografed', publishing = '$publishing', price = '$price', monthBook = '$monthBook', description = '$description' WHERE id = $id");
}