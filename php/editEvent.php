<?php
    $event = str_replace("'", "\'", $_POST['event']);

    $ini = parse_ini_file('../app.ini', true);
    $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
    mysqli_set_charset($link, 'utf8');

    // Добавление изменённого мероприятия в базу данных
    mysqli_query($link, "UPDATE events SET event = '$event' WHERE id = 1");