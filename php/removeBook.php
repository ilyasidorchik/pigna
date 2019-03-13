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

    if ($id == '') {
        $title = str_replace("'", "\'", $_POST['title']);
        $titleTypografed = typograf($title);

        $author = str_replace("'", "\'", $_POST['author']);
        $publishing = $_POST['publishing'];
        $price = $_POST['price'];
        $monthBook = $_POST['monthBook'];

        $description = str_replace("'", "\'", $_POST['description']);
        if ($description != '')
            $description = typograf($description);
    }

    $ini = parse_ini_file('../app.ini', true);

    $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
    mysqli_set_charset($link, 'utf8');

    // Удаление книги из базы данных
    if ($id == '')
        mysqli_query($link, "DELETE FROM catalogue WHERE title = '$titleTypografed' AND author = '$author' AND publishing = '$publishing' AND price = '$price' AND monthBook = '$monthBook' AND description = '$description'");
    else
        mysqli_query($link, "DELETE FROM catalogue WHERE id = '$id'");