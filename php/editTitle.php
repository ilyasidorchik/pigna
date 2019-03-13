<?php
    include 'remotetypograf.php';
    function typograf($str) {
        $remoteTypograf = new RemoteTypograf('UTF-8');

        $remoteTypograf->htmlEntities();
        $remoteTypograf->br (false);
        $remoteTypograf->p (false);
        $remoteTypograf->nobr (3);
        $remoteTypograf->quotA ('laquo raquo');
        $remoteTypograf->quotB ('bdquo ldquo');

        $strTypografed = $remoteTypograf->processText($str);
        return $strTypografed;
    }

    $id = $_POST['id'];
    $title = str_replace("'", "\'", $_POST['title']);
    $titleTypografed = typograf($title);

    if ($title != '') {
        $ini = parse_ini_file('../app.ini', true);

        $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
        mysqli_set_charset($link, 'utf8');

        // Изменение у книги названия в базе данных
        mysqli_query($link, "UPDATE catalogue SET title = '$titleTypografed' WHERE id = '$id'");
    }