<?php

$ini = parse_ini_file('../../app.ini', true);

if (password_verify($ini[admin][password], $_COOKIE['admin'])) {

    $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
    mysqli_set_charset($link, 'utf8');


    $personFullName = $_POST['fullName'];

    if ($personFullName != '')
        mysqli_query($link, "INSERT INTO testPeople (id, fullName) VALUES (NULL, '$personFullName')");

}