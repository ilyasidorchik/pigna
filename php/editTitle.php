<?php
    $id = $_POST['id'];
    $title = str_replace("'", "\'", $_POST['title']);

    $ini = parse_ini_file('../app.ini', true);

    $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
    mysqli_set_charset($link, 'utf8');

    // Изменение у книги названия в базе данных
    mysqli_query($link, "UPDATE catalogue SET title = '$title' WHERE id = '$id'");