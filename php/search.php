<?php
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
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 1");

        while ($row = mysqli_fetch_assoc($result)) {
            if (stripos($row[author], $bookTitle) !== false || stripos($row[title], $bookTitle) !== false || stripos($row[publishing], $bookTitle) !== false || stripos($row[description], $bookTitle) !== false) {
                if ($row[author] != '')
                    $row[author] = '<div class="grid__item__authortitle__author">'.$row[author].'</div>';

                if ($row[price] != 0)
                    $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">'.$row[price].'&thinsp;€</div>';
                else
                    $row[price] = '';

                if ($row[onHands] == 1) {
                    $onHandsClass = 'grid__item_on-hands';
                    $onHandsText = '<div class="grid__item_on-hands__text">Libro dato<br>a un lettore</div>';
                }

                echo <<<HERE
                    <div class="grid__item grid__item_month-book-color $onHandsClass">
                        <div class="grid__item__authortitle">
                            $row[author]
                            <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
                        </div>
                        <div class="grid__item__publishing">$row[publishing]</div>
                        $row[price]
				        $onHandsText
                    </div>
                    <div class="month-book">
					    <div class="month-book__wrap">
					        <div class="month-book__wrap__label">
						        <span class="month-book__wrap__label__text">Libro del mese</span>
							</div>
							<p class="month-book__wrap__description">$row[description]</p>
						</div>
					</div>
HERE;
            }
        }

        // Массив айдишников книг, чтобы не выводить книгу по два раза, если поисковое выражение есть и в авторе, и названии книги
        $arrayID = array();

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
                                        if ($row[author] != '')
                                            $row[author] = '<div class="grid__item__authortitle__author">' . $row[author] . '</div>';

                                        if ($row[price] != 0)
                                            $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">' . $row[price] . '&thinsp;€</div>';
                                        else
                                            $row[price] = '';
                                        echo <<<HERE
                                            <div class="grid__item">
                                                <div class="grid__item__authortitle">
                                                    $row[author]
                                                    <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
                                                </div>
                                                <div class="grid__item__publishing">$row[publishing]</div>
                                                $row[price]
                                            </div>
HERE;

                                        array_push($arrayID, $row[id]);
                                    }
                                }
                                else {
                                    if (stripos($row[author], $bookTitleWords[0]) !== false
                                        && stripos($row[author], $bookTitleWords[1]) !== false
                                        && stripos($row[author], $bookTitleWords[2]) !== false
                                        && stripos($row[author], $bookTitleWords[3]) !== false
                                        && stripos($row[author], $bookTitleWords[4]) !== false) {
                                        if ($row[author] != '')
                                            $row[author] = '<div class="grid__item__authortitle__author">' . $row[author] . '</div>';

                                        if ($row[price] != 0)
                                            $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">' . $row[price] . '&thinsp;€</div>';
                                        else
                                            $row[price] = '';
                                        echo <<<HERE
                                            <div class="grid__item">
                                                <div class="grid__item__authortitle">
                                                    $row[author]
                                                    <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
                                                </div>
                                                <div class="grid__item__publishing">$row[publishing]</div>
                                                $row[price]
                                            </div>
HERE;

                                        array_push($arrayID, $row[id]);
                                    }
                                }
                            }
                            else {
                                if (stripos($row[author], $bookTitleWords[0]) !== false
                                    && stripos($row[author], $bookTitleWords[1]) !== false
                                    && stripos($row[author], $bookTitleWords[2]) !== false
                                    && stripos($row[author], $bookTitleWords[3]) !== false) {
                                    if ($row[author] != '')
                                        $row[author] = '<div class="grid__item__authortitle__author">' . $row[author] . '</div>';

                                    if ($row[price] != 0)
                                        $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">' . $row[price] . '&thinsp;€</div>';
                                    else
                                        $row[price] = '';
                                    echo <<<HERE
                                            <div class="grid__item">
                                                <div class="grid__item__authortitle">
                                                    $row[author]
                                                    <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
                                                </div>
                                                <div class="grid__item__publishing">$row[publishing]</div>
                                                $row[price]
                                            </div>
HERE;

                                    array_push($arrayID, $row[id]);
                                }
                            }
                        }
                        else {
                            if (stripos($row[author], $bookTitleWords[0]) !== false
                                && stripos($row[author], $bookTitleWords[1]) !== false
                                && stripos($row[author], $bookTitleWords[2]) !== false) {

                                if ($row[author] != '')
                                    $row[author] = '<div class="grid__item__authortitle__author">' . $row[author] . '</div>';

                                if ($row[price] != 0)
                                    $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">' . $row[price] . '&thinsp;€</div>';
                                else
                                    $row[price] = '';
                                echo <<<HERE
                                        <div class="grid__item">
                                            <div class="grid__item__authortitle">
                                                $row[author]
                                                <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
                                            </div>
                                            <div class="grid__item__publishing">$row[publishing]</div>
                                            $row[price]
                                        </div>
HERE;

                                array_push($arrayID, $row[id]);
                            }
                        }
                    }
                    else {
                        if (stripos($row[author], $bookTitleWords[0]) !== false
                            && stripos($row[author], $bookTitleWords[1]) !== false) {
                            if ($row[author] != '')
                                $row[author] = '<div class="grid__item__authortitle__author">' . $row[author] . '</div>';

                            if ($row[price] != 0)
                                $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">' . $row[price] . '&thinsp;€</div>';
                            else
                                $row[price] = '';
                            echo <<<HERE
                                    <div class="grid__item">
                                        <div class="grid__item__authortitle">
                                            $row[author]
                                            <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
                                        </div>
                                        <div class="grid__item__publishing">$row[publishing]</div>
                                        $row[price]
                                    </div>
HERE;

                            array_push($arrayID, $row[id]);
                        }
                    }
                }
                else {
                    if (stripos($row[author], $bookTitleWords[0]) !== false) {
                        if ($row[author] != '')
                            $row[author] = '<div class="grid__item__authortitle__author">' . $row[author] . '</div>';

                        if ($row[price] != 0)
                            $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">' . $row[price] . '&thinsp;€</div>';
                        else
                            $row[price] = '';

                        echo <<<HERE
                                        <div class="grid__item">
                                            <div class="grid__item__authortitle">
                                                $row[author]
                                                <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
                                            </div>
                                            <div class="grid__item__publishing">$row[publishing]</div>
                                            $row[price]
                                        </div>
HERE;
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
                                        if ($row[author] != '')
                                            $row[author] = '<div class="grid__item__authortitle__author">' . $row[author] . '</div>';

                                        if ($row[price] != 0)
                                            $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">' . $row[price] . '&thinsp;€</div>';
                                        else
                                            $row[price] = '';
                                        echo <<<HERE
                                        <div class="grid__item">
                                            <div class="grid__item__authortitle">
                                                $row[author]
                                                <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
                                            </div>
                                            <div class="grid__item__publishing">$row[publishing]</div>
                                            $row[price]
                                        </div>
HERE;
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
                                        if ($row[author] != '')
                                            $row[author] = '<div class="grid__item__authortitle__author">' . $row[author] . '</div>';

                                        if ($row[price] != 0)
                                            $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">' . $row[price] . '&thinsp;€</div>';
                                        else
                                            $row[price] = '';
                                        echo <<<HERE
                                        <div class="grid__item">
                                            <div class="grid__item__authortitle">
                                                $row[author]
                                                <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
                                            </div>
                                            <div class="grid__item__publishing">$row[publishing]</div>
                                            $row[price]
                                        </div>
HERE;
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
                                    && (stripos($row[author], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWord3WithAccent) !== false || stripos($row[publishing], $bookTitleWords[3]) !== false)) {
                                        if ($row[author] != '')
                                            $row[author] = '<div class="grid__item__authortitle__author">' . $row[author] . '</div>';

                                        if ($row[price] != 0)
                                            $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">' . $row[price] . '&thinsp;€</div>';
                                        else
                                            $row[price] = '';
                                        echo <<<HERE
                                        <div class="grid__item">
                                            <div class="grid__item__authortitle">
                                                $row[author]
                                                <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
                                            </div>
                                            <div class="grid__item__publishing">$row[publishing]</div>
                                            $row[price]
                                        </div>
HERE;
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
                                    if ($row[author] != '')
                                        $row[author] = '<div class="grid__item__authortitle__author">' . $row[author] . '</div>';

                                    if ($row[price] != 0)
                                        $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">' . $row[price] . '&thinsp;€</div>';
                                    else
                                        $row[price] = '';
                                    echo <<<HERE
                                        <div class="grid__item">
                                            <div class="grid__item__authortitle">
                                                $row[author]
                                                <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
                                            </div>
                                            <div class="grid__item__publishing">$row[publishing]</div>
                                            $row[price]
                                        </div>
HERE;
                            }
                        }
                    }
                    else {
                        $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);
                        $bookTitleWord1WithAccent = addAccent($bookTitleWords[1]);

                        if ((stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false)
                            && (stripos($row[author], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWord1WithAccent) !== false || stripos($row[publishing], $bookTitleWords[1]) !== false)) {
                            if ($row[author] != '')
                                $row[author] = '<div class="grid__item__authortitle__author">' . $row[author] . '</div>';

                            if ($row[price] != 0)
                                $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">' . $row[price] . '&thinsp;€</div>';
                            else
                                $row[price] = '';
                            echo <<<HERE
                                    <div class="grid__item">
                                        <div class="grid__item__authortitle">
                                            $row[author]
                                            <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
                                        </div>
                                        <div class="grid__item__publishing">$row[publishing]</div>
                                        $row[price]
                                    </div>
HERE;
                        }
                    }
                }
                else {
                    $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);

                    if (stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false) {
                        if ($row[author] != '')
                            $row[author] = '<div class="grid__item__authortitle__author">' . $row[author] . '</div>';

                        if ($row[price] != 0)
                            $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">' . $row[price] . '&thinsp;€</div>';
                        else
                            $row[price] = '';

                        echo <<<HERE
                                        <div class="grid__item">
                                            <div class="grid__item__authortitle">
                                                $row[author]
                                                <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
                                            </div>
                                            <div class="grid__item__publishing">$row[publishing]</div>
                                            $row[price]
                                        </div>
HERE;
                    }
                }
            }
        }


        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = 1");
        while ($row = mysqli_fetch_assoc($result)) {
            if (stripos($row[author], $bookTitle) !== false) {
                if ($row[author] != '')
                    $row[author] = '<div class="grid__item__authortitle__author">'.$row[author].'</div>';

                if ($row[price] != 0)
                    $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">'.$row[price].'&thinsp;€</div>';
                else
                    $row[price] = '';

                if ($row[onHands] == 1) {
                    $onHandsClass = 'grid__item_on-hands';
                    $onHandsText = '<div class="grid__item_on-hands__text">Libro dato<br>a un lettore</div>';
                }

                echo <<<HERE
                    <div class="grid__item $onHandsClass">
                        <div class="grid__item__authortitle">
                            $row[author]
                            <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
                        </div>
                        <div class="grid__item__publishing">$row[publishing]</div>
                        $row[price]
				        $onHandsText
                    </div>
HERE;
                array_push($arrayID, $row[id]);
            }
        }

        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = 1");
        while ($row = mysqli_fetch_assoc($result)) {
            if (!in_array($row[id], $arrayID)) {
                if (stripos($row[title], $bookTitle) !== false || stripos($row[publishing], $bookTitle) !== false) {
                    if ($row[author] != '')
                        $row[author] = '<div class="grid__item__authortitle__author">'.$row[author].'</div>';

                    if ($row[price] != 0)
                        $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">'.$row[price].'&thinsp;€</div>';
                    else
                        $row[price] = '';

                    if ($row[onHands] == 1) {
                        $onHandsClass = 'grid__item_on-hands';
                        $onHandsText = '<div class="grid__item_on-hands__text">Libro dato<br>a un lettore</div>';
                    }

                    echo <<<HERE
                    <div class="grid__item $onHandsClass">
                        <div class="grid__item__authortitle">
                            $row[author]
                            <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
                        </div>
                        <div class="grid__item__publishing">$row[publishing]</div>
                        $row[price]
				        $onHandsText
                    </div>
HERE;
                }
            }
        }
    }
    else {
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 1");
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row[author] != '')
                $row[author] = '<div class="grid__item__authortitle__author">'.$row[author].'</div>';

            if ($row[price] != 0)
                $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">'.$row[price].'&thinsp;€</div>';
            else
                $row[price] = '';

            if ($row[onHands] == 1) {
                $onHandsClass = 'grid__item_on-hands';
                $onHandsText = '<div class="grid__item_on-hands__text">Libro dato<br>a un lettore</div>';
            }

            echo <<<HERE
							<div class="grid__item grid__item_month-book-color $onHandsClass">
				                <div class="grid__item__authortitle">
				                    $row[author]
				                    <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
				                </div>
				                <div class="grid__item__publishing">$row[publishing]</div>
				                $row[price]
				                $onHandsText
				            </div>

							<div class="month-book">
						        <div class="month-book__wrap">
							        <div class="month-book__wrap__label">
								        <span class="month-book__wrap__label__text">Libro del mese</span>
							        </div>
							        <p class="month-book__wrap__description">$row[description]</p>
						        </div>
					        </div>
HERE;
        }

        // Все остальные книги, которые не на руках
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = 0");
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row[author] != '')
                $row[author] = '<div class="grid__item__authortitle__author">'.$row[author].'</div>';

            if ($row[price] != 0)
                $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">'.$row[price].'&thinsp;€</div>';
            else
                $row[price] = '';

            echo <<<HERE
						<div class="grid__item">
			                <div class="grid__item__authortitle">
			                    $row[author]
			                    <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
			                </div>
			                <div class="grid__item__publishing">$row[publishing]</div>
			                $row[price]
			            </div>
HERE;
        }

        // Книги, которые на руках
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = 1");
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row[author] != '')
                $row[author] = '<div class="grid__item__authortitle__author">'.$row[author].'</div>';

            if ($row[price] != 0)
                $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">'.$row[price].'&thinsp;€</div>';
            else
                $row[price] = '';

            echo <<<HERE
							<div class="grid__item grid__item_on-hands">
				                <div class="grid__item__authortitle">
				                    $row[author]
				                    <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
				                </div>
				                <div class="grid__item__publishing">$row[publishing]</div>
				                $row[price]
				                <div class="grid__item_on-hands__text">Libro dato<br>a un lettore</div>
				            </div>
HERE;
        }
    }

    function addAccent($word) {
        switch (substr($word[strlen($word)-1], -1)) {
            case 'a':
                $word[strlen($word)-1] = str_replace('a', 'à', $word[strlen($word)-1]);
                break;
            case 'o':
                $word[strlen($word)-1] = str_replace('o', 'ò', $word[strlen($word)-1]);
                break;
        }

        return $word;
    }