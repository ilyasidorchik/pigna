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

    if ($admin == 'admin')
        echo '<div class="grid__item grid__item_link-to-book-adding"><a href="+/" class="grid__item_link-to-book-adding__link"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 74.73 72.82" class="grid__item_link-to-book-adding__link__icon"><defs><style>.a{fill:url(#a);}</style><linearGradient id="a" x1="37.5" y1="1.06" x2="37.5" y2="73.88" gradientUnits="userSpaceOnUse"><stop offset="0" class="grid__item_link-to-book-adding__link__icon__gradient-color grid__item_link-to-book-adding__link__icon__gradient-color_1"/><stop offset="1" class="grid__item_link-to-book-adding__link__icon__gradient-color grid__item_link-to-book-adding__link__icon__gradient-color_2"/></linearGradient></defs><title>plus</title><path class="a" d="M33.84,40.81H.13V34.13H33.84V1.06h7.31V34.13H74.86v6.68H41.15V73.88H33.84Z" transform="translate(-0.13 -1.06)"/></svg></a></div>';

    if ($bookTitle != '') {
        // Книга месяца
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 1");
        while ($row = mysqli_fetch_assoc($result)) {
            if (stripos($row[author], $bookTitle) !== false || stripos($row[title], $bookTitle) !== false || stripos($row[publishing], $bookTitle) !== false || stripos($row[description], $bookTitle) !== false) {
                printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
            }
        }

        // Массив айдишников книг, чтобы не выводить книгу по два раза, если поисковое выражение есть и в авторе, и названии книги
        $arrayID = array();

        // Все остальные книги в наличии. Поиск по автору в приоритете
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = $onHandsStart");
        while ($row = mysqli_fetch_assoc($result)) {
            if (!in_array($row[id], $arrayID)) {
                if ($partsCount > 1 && $bookTitleWords[1] != '') {
                    if ($partsCount > 2 && $bookTitleWords[2] != '') {
                        if ($partsCount > 3 && $bookTitleWords[3] != '') {
                            if ($partsCount > 4 && $bookTitleWords[4] != '') {
                                if ($partsCount > 5 && $bookTitleWords[5] != '') {
                                    if (stripos($row[author], $bookTitleWords[0]) !== false
                                        && stripos($row[author], $bookTitleWords[1]) !== false
                                        && stripos($row[author], $bookTitleWords[2]) !== false
                                        && stripos($row[author], $bookTitleWords[3]) !== false
                                        && stripos($row[author], $bookTitleWords[4]) !== false
                                        && stripos($row[author], $bookTitleWords[5]) !== false) {
                                        printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);

                                        array_push($arrayID, $row[id]);
                                    }
                                }
                                else {
                                    if (stripos($row[author], $bookTitleWords[0]) !== false
                                        && stripos($row[author], $bookTitleWords[1]) !== false
                                        && stripos($row[author], $bookTitleWords[2]) !== false
                                        && stripos($row[author], $bookTitleWords[3]) !== false
                                        && stripos($row[author], $bookTitleWords[4]) !== false) {
                                        printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);

                                        array_push($arrayID, $row[id]);
                                    }
                                }
                            }
                            else {
                                if (stripos($row[author], $bookTitleWords[0]) !== false
                                    && stripos($row[author], $bookTitleWords[1]) !== false
                                    && stripos($row[author], $bookTitleWords[2]) !== false
                                    && stripos($row[author], $bookTitleWords[3]) !== false) {
                                    printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);

                                    array_push($arrayID, $row[id]);
                                }
                            }
                        }
                        else {
                            if (stripos($row[author], $bookTitleWords[0]) !== false
                                && stripos($row[author], $bookTitleWords[1]) !== false
                                && stripos($row[author], $bookTitleWords[2]) !== false) {
                                printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);

                                array_push($arrayID, $row[id]);
                            }
                        }
                    }
                    else {
                        if (stripos($row[author], $bookTitleWords[0]) !== false
                            && stripos($row[author], $bookTitleWords[1]) !== false) {
                            printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);

                            array_push($arrayID, $row[id]);
                        }
                    }
                }
                else {
                    if (stripos($row[author], $bookTitleWords[0]) !== false) {
                        printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);

                        array_push($arrayID, $row[id]);
                    }
                }
            }
        }

        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = $onHandsStart");
        while ($row = mysqli_fetch_assoc($result)) {
            if (!in_array($row[id], $arrayID)) {
                if ($partsCount > 1 && $bookTitleWords[1] != '') {
                    if ($partsCount > 2 && $bookTitleWords[2] != '') {
                        if ($partsCount > 3 && $bookTitleWords[3] != '') {
                            if ($partsCount > 4 && $bookTitleWords[4] != '') {
                                if ($partsCount > 5 && $bookTitleWords[5] != '') {
                                    $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);
                                    $bookTitleWord1WithAccent = addAccent($bookTitleWords[1]);
                                    $bookTitleWord2WithAccent = addAccent($bookTitleWords[2]);
                                    $bookTitleWord3WithAccent = addAccent($bookTitleWords[3]);
                                    $bookTitleWord4WithAccent = addAccent($bookTitleWords[4]);
                                    $bookTitleWord5WithAccent = addAccent($bookTitleWords[5]);

                                    if ((stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false)
                                        && (stripos($row[author], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWord1WithAccent) !== false || stripos($row[publishing], $bookTitleWords[1]) !== false)
                                        && (stripos($row[author], $bookTitleWords[2]) !== false || stripos($row[title], $bookTitleWords[2]) !== false || stripos($row[title], $bookTitleWord2WithAccent) !== false || stripos($row[publishing], $bookTitleWords[2]) !== false)
                                        && (stripos($row[author], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWord3WithAccent) !== false || stripos($row[publishing], $bookTitleWords[3]) !== false)
                                        && (stripos($row[author], $bookTitleWords[4]) !== false || stripos($row[title], $bookTitleWords[4]) !== false || stripos($row[title], $bookTitleWord4WithAccent) !== false || stripos($row[publishing], $bookTitleWords[4]) !== false)
                                        && (stripos($row[author], $bookTitleWords[5]) !== false || stripos($row[title], $bookTitleWords[5]) !== false || stripos($row[title], $bookTitleWord5WithAccent) !== false || stripos($row[publishing], $bookTitleWords[5]) !== false)) {
                                        printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
                                    }
                                }
                                else {
                                    $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);
                                    $bookTitleWord1WithAccent = addAccent($bookTitleWords[1]);
                                    $bookTitleWord2WithAccent = addAccent($bookTitleWords[2]);
                                    $bookTitleWord3WithAccent = addAccent($bookTitleWords[3]);
                                    $bookTitleWord4WithAccent = addAccent($bookTitleWords[4]);

                                    if ((stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false)
                                        && (stripos($row[author], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWord1WithAccent) !== false || stripos($row[publishing], $bookTitleWords[1]) !== false)
                                        && (stripos($row[author], $bookTitleWords[2]) !== false || stripos($row[title], $bookTitleWords[2]) !== false || stripos($row[title], $bookTitleWord2WithAccent) !== false || stripos($row[publishing], $bookTitleWords[2]) !== false)
                                        && (stripos($row[author], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWord3WithAccent) !== false || stripos($row[publishing], $bookTitleWords[3]) !== false)
                                        && (stripos($row[author], $bookTitleWords[4]) !== false || stripos($row[title], $bookTitleWords[4]) !== false || stripos($row[title], $bookTitleWord4WithAccent) !== false || stripos($row[publishing], $bookTitleWords[4]) !== false)) {
                                        printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
                                    }
                                }
                            }
                            else {
                                $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);
                                $bookTitleWord1WithAccent = addAccent($bookTitleWords[1]);
                                $bookTitleWord2WithAccent = addAccent($bookTitleWords[2]);
                                $bookTitleWord3WithAccent = addAccent($bookTitleWords[3]);

                                if ((stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false)
                                    && (stripos($row[author], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWord1WithAccent) !== false || stripos($row[publishing], $bookTitleWords[1]) !== false)
                                    && (stripos($row[author], $bookTitleWords[2]) !== false || stripos($row[title], $bookTitleWords[2]) !== false || stripos($row[title], $bookTitleWord2WithAccent) !== false || stripos($row[publishing], $bookTitleWords[2]) !== false)
                                    && (stripos($row[author], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWord3WithAccent) !== false || stripos($row[publishing], $bookTitleWords[3]) !== false)) {printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
                                }
                            }
                        }
                        else {
                            $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);
                            $bookTitleWord1WithAccent = addAccent($bookTitleWords[1]);
                            $bookTitleWord2WithAccent = addAccent($bookTitleWords[2]);

                            if ((stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false)
                                && (stripos($row[author], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWord1WithAccent) !== false || stripos($row[publishing], $bookTitleWords[1]) !== false)
                                && (stripos($row[author], $bookTitleWords[2]) !== false || stripos($row[title], $bookTitleWords[2]) !== false || stripos($row[title], $bookTitleWord2WithAccent) !== false || stripos($row[publishing], $bookTitleWords[2]) !== false)) {
                                printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
                            }
                        }
                    }
                    else {
                        $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);
                        $bookTitleWord1WithAccent = addAccent($bookTitleWords[1]);

                        if ((stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false)
                            && (stripos($row[author], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWord1WithAccent) !== false || stripos($row[publishing], $bookTitleWords[1]) !== false)) {
                            printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
                        }
                    }
                }
                else {
                    $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);

                    if (stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false) {
                        if ($bookTitleWord0WithAccent != 'a&') {
                            printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
                        }
                    }
                }
            }
        }


        // Книги на руках. Поиск по автору в приоритете
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = $onHandsEnd");
        while ($row = mysqli_fetch_assoc($result)) {
            if (!in_array($row[id], $arrayID)) {
                if ($partsCount > 1 && $bookTitleWords[1] != '') {
                    if ($partsCount > 2 && $bookTitleWords[2] != '') {
                        if ($partsCount > 3 && $bookTitleWords[3] != '') {
                            if ($partsCount > 4 && $bookTitleWords[4] != '') {
                                if ($partsCount > 5 && $bookTitleWords[5] != '') {
                                    if (stripos($row[author], $bookTitleWords[0]) !== false
                                        && stripos($row[author], $bookTitleWords[1]) !== false
                                        && stripos($row[author], $bookTitleWords[2]) !== false
                                        && stripos($row[author], $bookTitleWords[3]) !== false
                                        && stripos($row[author], $bookTitleWords[4]) !== false
                                        && stripos($row[author], $bookTitleWords[5]) !== false) {
                                        printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);

                                        array_push($arrayID, $row[id]);
                                    }
                                }
                                else {
                                    if (stripos($row[author], $bookTitleWords[0]) !== false
                                        && stripos($row[author], $bookTitleWords[1]) !== false
                                        && stripos($row[author], $bookTitleWords[2]) !== false
                                        && stripos($row[author], $bookTitleWords[3]) !== false
                                        && stripos($row[author], $bookTitleWords[4]) !== false) {
                                        printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);

                                        array_push($arrayID, $row[id]);
                                    }
                                }
                            }
                            else {
                                if (stripos($row[author], $bookTitleWords[0]) !== false
                                    && stripos($row[author], $bookTitleWords[1]) !== false
                                    && stripos($row[author], $bookTitleWords[2]) !== false
                                    && stripos($row[author], $bookTitleWords[3]) !== false) {
                                    printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);

                                    array_push($arrayID, $row[id]);
                                }
                            }
                        }
                        else {
                            if (stripos($row[author], $bookTitleWords[0]) !== false
                                && stripos($row[author], $bookTitleWords[1]) !== false
                                && stripos($row[author], $bookTitleWords[2]) !== false) {
                                printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);

                                array_push($arrayID, $row[id]);
                            }
                        }
                    }
                    else {
                        if (stripos($row[author], $bookTitleWords[0]) !== false
                            && stripos($row[author], $bookTitleWords[1]) !== false) {
                            printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);

                            array_push($arrayID, $row[id]);
                        }
                    }
                }
                else {
                    if (stripos($row[author], $bookTitleWords[0]) !== false) {
                        printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);

                        array_push($arrayID, $row[id]);
                    }
                }
            }
        }

        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = $onHandsEnd");
        while ($row = mysqli_fetch_assoc($result)) {
            if (!in_array($row[id], $arrayID)) {
                if ($partsCount > 1 && $bookTitleWords[1] != '') {
                    if ($partsCount > 2 && $bookTitleWords[2] != '') {
                        if ($partsCount > 3 && $bookTitleWords[3] != '') {
                            if ($partsCount > 4 && $bookTitleWords[4] != '') {
                                if ($partsCount > 5 && $bookTitleWords[5] != '') {
                                    $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);
                                    $bookTitleWord1WithAccent = addAccent($bookTitleWords[1]);
                                    $bookTitleWord2WithAccent = addAccent($bookTitleWords[2]);
                                    $bookTitleWord3WithAccent = addAccent($bookTitleWords[3]);
                                    $bookTitleWord4WithAccent = addAccent($bookTitleWords[4]);
                                    $bookTitleWord5WithAccent = addAccent($bookTitleWords[5]);

                                    if ((stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false)
                                        && (stripos($row[author], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWord1WithAccent) !== false || stripos($row[publishing], $bookTitleWords[1]) !== false)
                                        && (stripos($row[author], $bookTitleWords[2]) !== false || stripos($row[title], $bookTitleWords[2]) !== false || stripos($row[title], $bookTitleWord2WithAccent) !== false || stripos($row[publishing], $bookTitleWords[2]) !== false)
                                        && (stripos($row[author], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWord3WithAccent) !== false || stripos($row[publishing], $bookTitleWords[3]) !== false)
                                        && (stripos($row[author], $bookTitleWords[4]) !== false || stripos($row[title], $bookTitleWords[4]) !== false || stripos($row[title], $bookTitleWord4WithAccent) !== false || stripos($row[publishing], $bookTitleWords[4]) !== false)
                                        && (stripos($row[author], $bookTitleWords[5]) !== false || stripos($row[title], $bookTitleWords[5]) !== false || stripos($row[title], $bookTitleWord5WithAccent) !== false || stripos($row[publishing], $bookTitleWords[5]) !== false)) {
                                        printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
                                    }
                                }
                                else {
                                    $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);
                                    $bookTitleWord1WithAccent = addAccent($bookTitleWords[1]);
                                    $bookTitleWord2WithAccent = addAccent($bookTitleWords[2]);
                                    $bookTitleWord3WithAccent = addAccent($bookTitleWords[3]);
                                    $bookTitleWord4WithAccent = addAccent($bookTitleWords[4]);

                                    if ((stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false)
                                        && (stripos($row[author], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWord1WithAccent) !== false || stripos($row[publishing], $bookTitleWords[1]) !== false)
                                        && (stripos($row[author], $bookTitleWords[2]) !== false || stripos($row[title], $bookTitleWords[2]) !== false || stripos($row[title], $bookTitleWord2WithAccent) !== false || stripos($row[publishing], $bookTitleWords[2]) !== false)
                                        && (stripos($row[author], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWord3WithAccent) !== false || stripos($row[publishing], $bookTitleWords[3]) !== false)
                                        && (stripos($row[author], $bookTitleWords[4]) !== false || stripos($row[title], $bookTitleWords[4]) !== false || stripos($row[title], $bookTitleWord4WithAccent) !== false || stripos($row[publishing], $bookTitleWords[4]) !== false)) {
                                        printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
                                    }
                                }
                            }
                            else {
                                $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);
                                $bookTitleWord1WithAccent = addAccent($bookTitleWords[1]);
                                $bookTitleWord2WithAccent = addAccent($bookTitleWords[2]);
                                $bookTitleWord3WithAccent = addAccent($bookTitleWords[3]);

                                if ((stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false)
                                    && (stripos($row[author], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWord1WithAccent) !== false || stripos($row[publishing], $bookTitleWords[1]) !== false)
                                    && (stripos($row[author], $bookTitleWords[2]) !== false || stripos($row[title], $bookTitleWords[2]) !== false || stripos($row[title], $bookTitleWord2WithAccent) !== false || stripos($row[publishing], $bookTitleWords[2]) !== false)
                                    && (stripos($row[author], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWord3WithAccent) !== false || stripos($row[publishing], $bookTitleWords[3]) !== false)) {printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
                                }
                            }
                        }
                        else {
                            $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);
                            $bookTitleWord1WithAccent = addAccent($bookTitleWords[1]);
                            $bookTitleWord2WithAccent = addAccent($bookTitleWords[2]);

                            if ((stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false)
                                && (stripos($row[author], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWord1WithAccent) !== false || stripos($row[publishing], $bookTitleWords[1]) !== false)
                                && (stripos($row[author], $bookTitleWords[2]) !== false || stripos($row[title], $bookTitleWords[2]) !== false || stripos($row[title], $bookTitleWord2WithAccent) !== false || stripos($row[publishing], $bookTitleWords[2]) !== false)) {
                                printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
                            }
                        }
                    }
                    else {
                        $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);
                        $bookTitleWord1WithAccent = addAccent($bookTitleWords[1]);

                        if ((stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false)
                            && (stripos($row[author], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWord1WithAccent) !== false || stripos($row[publishing], $bookTitleWords[1]) !== false)) {
                            printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
                        }
                    }
                }
                else {
                    $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);

                    if (stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false) {
                        printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
                    }
                }
            }
        }
    }
    else {
        // Книга месяца
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 1");
        while ($row = mysqli_fetch_assoc($result)) {
            printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
        }

        // Все остальные книги, которые не на руках
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = $onHandsStart");
        while ($row = mysqli_fetch_assoc($result)) {
            printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
        }

        // Книги, которые на руках
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = $onHandsEnd");
        while ($row = mysqli_fetch_assoc($result)) {
            printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
        }
    }