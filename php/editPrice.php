<?php
    $id = $_POST['id'];
    $price = $_POST['price'];

    $ini = parse_ini_file('../app.ini', true);

    $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
    mysqli_set_charset($link, 'utf8');

    // Изменение у книги цены
    mysqli_query($link, "UPDATE catalogue SET price = '$price' WHERE id = '$id'");