<?php
    include 'functions.php';

    $bookTitle = $_POST['bookTitle'];
    $bookTitle = str_replace("'", "’", $bookTitle);

    $wordsCount = str_word_count($bookTitle, 0);
    $bookTitleWords = explode(' ', $bookTitle);
    $bookTitleWithAccent = '';
    $partsCount = substr_count($bookTitle, ' ') + 1;

    $ini = parse_ini_file('../app.ini', true);

    $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
    mysqli_set_charset($link, 'utf8');

    if ($bookTitle != '') {
        // Книга месяца
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 1");
        while ($row = mysqli_fetch_assoc($result)) {
            if (stripos($row[author], $bookTitle) !== false || stripos($row[title], $bookTitle) !== false || stripos($row[publishing], $bookTitle) !== false || stripos($row[description], $bookTitle) !== false) {
                printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);
            }
        }

        // Массив айдишников книг, чтобы не выводить книгу по два раза, если поисковое выражение есть и в авторе, и названии книги
        $arrayID = array();

        // Все остальные книги в наличии. Поиск по автору в приоритете
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = 0");
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
                                        printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);

                                        array_push($arrayID, $row[id]);
                                    }
                                }
                                else {
                                    if (stripos($row[author], $bookTitleWords[0]) !== false
                                        && stripos($row[author], $bookTitleWords[1]) !== false
                                        && stripos($row[author], $bookTitleWords[2]) !== false
                                        && stripos($row[author], $bookTitleWords[3]) !== false
                                        && stripos($row[author], $bookTitleWords[4]) !== false) {
                                        printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);

                                        array_push($arrayID, $row[id]);
                                    }
                                }
                            }
                            else {
                                if (stripos($row[author], $bookTitleWords[0]) !== false
                                    && stripos($row[author], $bookTitleWords[1]) !== false
                                    && stripos($row[author], $bookTitleWords[2]) !== false
                                    && stripos($row[author], $bookTitleWords[3]) !== false) {
                                    printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);

                                    array_push($arrayID, $row[id]);
                                }
                            }
                        }
                        else {
                            if (stripos($row[author], $bookTitleWords[0]) !== false
                                && stripos($row[author], $bookTitleWords[1]) !== false
                                && stripos($row[author], $bookTitleWords[2]) !== false) {
                                printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);

                                array_push($arrayID, $row[id]);
                            }
                        }
                    }
                    else {
                        if (stripos($row[author], $bookTitleWords[0]) !== false
                            && stripos($row[author], $bookTitleWords[1]) !== false) {
                            printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);

                            array_push($arrayID, $row[id]);
                        }
                    }
                }
                else {
                    if (stripos($row[author], $bookTitleWords[0]) !== false) {
                        printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);

                        array_push($arrayID, $row[id]);
                    }
                }
            }
        }

        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = 0");
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
                                        printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);
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
                                        printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);
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
                                    && (stripos($row[author], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWord3WithAccent) !== false || stripos($row[publishing], $bookTitleWords[3]) !== false)) {printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);
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
                                printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);
                            }
                        }
                    }
                    else {
                        $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);
                        $bookTitleWord1WithAccent = addAccent($bookTitleWords[1]);

                        if ((stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false)
                            && (stripos($row[author], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWord1WithAccent) !== false || stripos($row[publishing], $bookTitleWords[1]) !== false)) {
                            printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);
                        }
                    }
                }
                else {
                    $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);

                    if (stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false) {
                        printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);
                    }
                }
            }
        }


        // Книги на руках. Поиск по автору в приоритете
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = 1");
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
                                        printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);

                                        array_push($arrayID, $row[id]);
                                    }
                                }
                                else {
                                    if (stripos($row[author], $bookTitleWords[0]) !== false
                                        && stripos($row[author], $bookTitleWords[1]) !== false
                                        && stripos($row[author], $bookTitleWords[2]) !== false
                                        && stripos($row[author], $bookTitleWords[3]) !== false
                                        && stripos($row[author], $bookTitleWords[4]) !== false) {
                                        printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);

                                        array_push($arrayID, $row[id]);
                                    }
                                }
                            }
                            else {
                                if (stripos($row[author], $bookTitleWords[0]) !== false
                                    && stripos($row[author], $bookTitleWords[1]) !== false
                                    && stripos($row[author], $bookTitleWords[2]) !== false
                                    && stripos($row[author], $bookTitleWords[3]) !== false) {
                                    printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);

                                    array_push($arrayID, $row[id]);
                                }
                            }
                        }
                        else {
                            if (stripos($row[author], $bookTitleWords[0]) !== false
                                && stripos($row[author], $bookTitleWords[1]) !== false
                                && stripos($row[author], $bookTitleWords[2]) !== false) {
                                printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);

                                array_push($arrayID, $row[id]);
                            }
                        }
                    }
                    else {
                        if (stripos($row[author], $bookTitleWords[0]) !== false
                            && stripos($row[author], $bookTitleWords[1]) !== false) {
                            printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);

                            array_push($arrayID, $row[id]);
                        }
                    }
                }
                else {
                    if (stripos($row[author], $bookTitleWords[0]) !== false) {
                        printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);

                        array_push($arrayID, $row[id]);
                    }
                }
            }
        }

        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = 1");
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
                                        printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);
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
                                        printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);
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
                                    && (stripos($row[author], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWord3WithAccent) !== false || stripos($row[publishing], $bookTitleWords[3]) !== false)) {printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);
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
                                printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);
                            }
                        }
                    }
                    else {
                        $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);
                        $bookTitleWord1WithAccent = addAccent($bookTitleWords[1]);

                        if ((stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false)
                            && (stripos($row[author], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWord1WithAccent) !== false || stripos($row[publishing], $bookTitleWords[1]) !== false)) {
                            printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);
                        }
                    }
                }
                else {
                    $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);

                    if (stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false) {
                        printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);
                    }
                }
            }
        }
    }
    else {
        // Книга месяца
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 1");
        while ($row = mysqli_fetch_assoc($result)) {
            printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);
        }

        // Все остальные книги, которые не на руках
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = 0");
        while ($row = mysqli_fetch_assoc($result)) {
            printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);
        }

        // Книги, которые на руках
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = 1");
        while ($row = mysqli_fetch_assoc($result)) {
            printBookTemplate($row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands]);
        }
    }