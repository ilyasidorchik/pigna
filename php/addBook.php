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
    if ($id == '')
        $id = 'NULL';

    $title = str_replace("'", "\'", $_POST['title']);
    $titleTypografed = typograf($title);

    $author = str_replace("'", "\'", $_POST['author']);
    $publishing = $_POST['publishing'];
    $price = $_POST['price'];
    $monthBook = $_POST['monthBook'];

    $description = str_replace("'", "\'", $_POST['description']);
    $descriptionTypografed = typograf($description);

    $ini = parse_ini_file('../app.ini', true);

    $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
    mysqli_set_charset($link, 'utf8');

    // При добавлении новой книги месяца, старая книга месяца теряет свой статус
    if ($monthBook == 1)
        mysqli_query($link, "UPDATE catalogue SET monthBook = 0 WHERE monthBook = 1");

    // Добавление новой книги в базу данных
    mysqli_query($link, "INSERT INTO catalogue (id, title, author, publishing, price, monthBook, description) VALUES ('$id', '$titleTypografed', '$author', '$publishing', '$price', '$monthBook', '$descriptionTypografed')");