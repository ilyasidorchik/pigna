<?php

$ini = parse_ini_file('../app.ini', true);

if (password_verify($ini[admin][password], $_COOKIE['admin_rights'])) {
    $id = $_POST['id'];
    $onHandsStatus = $_POST['onHandsStatus'];

    $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
    mysqli_set_charset($link, 'utf8');

    // Отметка, что книга на руках
    mysqli_query($link, "UPDATE catalogue SET onHands = '$onHandsStatus' WHERE id = '$id'");
}