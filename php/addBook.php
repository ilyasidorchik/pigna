<?php
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publishing = $_POST['publishing'];
    $price = $_POST['price'];
    $monthBook = $_POST['monthBook'];
    $description = $_POST['description'];

    $ini = parse_ini_file('../app.ini', true);

    $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');

    mysqli_query($link, "INSERT INTO `catalogue` (`id`, `title`, `author`, `publishing`, `price`, `monthBook`, `description`) VALUES (NULL, '$title', '$author', '$publishing', '$price', '$monthBook', '$description')");