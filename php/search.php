<?php
    include 'functions.php';

    $ini = parse_ini_file('../app.ini', true);

    if (password_verify($ini[admin][password], $_COOKIE['admin_rights'])) {
        $admin = 'admin';
        $onHandsStart = 1;
        $onHandsEnd = 0;
    }
    else {
        $admin = '';
        $onHandsStart = 0;
        $onHandsEnd = 1;
    }

    $bookTitle = $_POST['bookTitle'];
    $bookTitle = str_replace("'", "’", $bookTitle);

    $wordsCount = str_word_count($bookTitle, 0);
    $bookTitleWords = explode(' ', $bookTitle);
    $bookTitleWithAccent = '';
    $partsCount = substr_count($bookTitle, ' ') + 1;

    $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
    mysqli_set_charset($link, 'utf8');

    printBookAddingLink($admin);

    printEvents($admin);

    if ($bookTitle != '') {
        // Книга месяца
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 1");
        while ($row = mysqli_fetch_assoc($result)) {
            if (stripos($row[author], $bookTitle) !== false || stripos($row[title], $bookTitle) !== false || stripos($row[publishing], $bookTitle) !== false || stripos($row[description], $bookTitle) !== false) {
                printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);
                $monthBook = true;
            }
        }

        // Новинки в наличии
        $arrayID = printFoundBooksWithAuthorPriority($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND new = 1 AND onHands = '$onHandsStart' ORDER BY id DESC", $partsCount, $bookTitleWords, $arrayID, $admin);
        printFoundBooks($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND new = 1 AND onHands = '$onHandsStart' ORDER BY id DESC", $partsCount, $bookTitleWords, $arrayID, $admin);

        // Новинки на руках
        $arrayID = printFoundBooksWithAuthorPriority($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND new = 1 AND onHands = '$onHandsEnd' ORDER BY id DESC", $partsCount, $bookTitleWords, $arrayID, $admin);
        printFoundBooks($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND new = 1 AND onHands = '$onHandsEnd' ORDER BY id DESC", $partsCount, $bookTitleWords, $arrayID, $admin);

        // Книги в наличии
        $arrayID = printFoundBooksWithAuthorPriority($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = $onHandsStart AND new = 0 ORDER BY id DESC", $partsCount, $bookTitleWords, $arrayID, $admin);
        printFoundBooks($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = $onHandsStart AND new = 0 ORDER BY id DESC", $partsCount, $bookTitleWords, $arrayID, $admin);

        // Книги на руках
        $arrayID = printFoundBooksWithAuthorPriority($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = $onHandsEnd AND new = 0 ORDER BY id DESC", $partsCount, $bookTitleWords, $arrayID, $admin);
        printFoundBooks($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = $onHandsEnd AND new = 0 ORDER BY id DESC", $partsCount, $bookTitleWords, $arrayID, $admin);
    }
    else {
        printAllBooks($link, $onHandsStart, $onHandsEnd, $admin);
    }