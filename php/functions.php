<?php
    require 'remotetypograf.php';
    function typograf($str) {
        $remoteTypograf = new RemoteTypograf('UTF-8');

        $remoteTypograf->htmlEntities();
        $remoteTypograf->br (false);
        $remoteTypograf->p (false);
        $remoteTypograf->nobr (3);
        $remoteTypograf->quotA ('laquo raquo');
        $remoteTypograf->quotB ('bdquo ldquo');

        $strTypografed = $remoteTypograf->processText($str);

        $prepositions = array(" di ", " a ", " da ", " in ", " con ", " su ", " per ", " tra ", " fra ", " e ", " o ", " il ", " lo ", " la ", " i ", " gli ", " le ", " del ", " dello ", " della ", " dei ", " degli ", " delle ", " al ", " allo ", " alla ", " ai ", " agli ", " alle ", " dal ", " dallo ", " dalla ", " dai ", " dagli ", " dalle ", " nel ", " nello ", " nella ", " nei ", " negli ", " nelle ", " sul ", " col ", " sullo ", " sulla ", " sui ", " sugli ", " sulle ", "san ", "una ");
        $prepositionsTypografed = array("di&nbsp;", " a&nbsp;", " da&nbsp;", " in&nbsp;", " con&nbsp;", " su&nbsp;", " per&nbsp;", " tra&nbsp;", " fra&nbsp;", " e&nbsp;", " o&nbsp;", " il&nbsp;", " lo&nbsp;", " la&nbsp;", " i&nbsp;", " gli&nbsp;", " le&nbsp;", " del&nbsp;", " dello&nbsp;", " della&nbsp;", " dei&nbsp;", " degli&nbsp;", " delle&nbsp;", " al&nbsp;", " allo&nbsp;", " alla&nbsp;", " ai&nbsp;", " agli&nbsp;", " alle&nbsp;", " dal&nbsp;", " dallo&nbsp;", " dalla&nbsp;", " dai&nbsp;", " dagli&nbsp;", " dalle&nbsp;", " nel&nbsp;", " nello&nbsp;", " nella&nbsp;", " nei&nbsp;", " negli&nbsp;", " nelle&nbsp;", " sul&nbsp;", " col&nbsp;", " sullo&nbsp;", " sulla&nbsp;", " sui&nbsp;", " sugli&nbsp;", " sulle&nbsp;", "san&nbsp;", "una&nbsp;");
        $strTypografed = str_replace($prepositions, $prepositionsTypografed, $strTypografed);

        return $strTypografed;
    }

    function printAllBooks($link, $onHandsStart, $onHandsEnd, $admin) {
        // Поддержка новинок (нужна в том случае, когда не добавляются новые книги, а новинки в каталоге устаревают)
        supportNewBooksByDate($link);

        // Книга месяца
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 1");
        while ($row = mysqli_fetch_assoc($result))
            printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);

        // Новинки в наличии
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND new = 1 AND onHands = '$onHandsStart' ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($result))
            printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);

        // Новинки на руках
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND new = 1 AND onHands = '$onHandsEnd' ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($result))
            printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);

        // Все остальные книги в наличии
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = '$onHandsStart' AND new = 0 ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($result))
            printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);

        // Книги (не новинки) на руках
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = '$onHandsEnd' AND new = 0 ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($result))
            printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);
    }

    function printFoundBooksWithAuthorPriority($link, $query, $partsCount, $bookTitleWords, $arrayID, $admin) {
        // Массив айдишников книг, чтобы не выводить книгу по два раза, если поисковое выражение есть и в авторе, и названии книги
        if ($arrayID == NULL) {
            $arrayID = array();
        }

        $result = mysqli_query($link, $query);
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
                                        printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);

                                        array_push($arrayID, $row[id]);
                                    }
                                }
                                else {
                                    if (stripos($row[author], $bookTitleWords[0]) !== false
                                        && stripos($row[author], $bookTitleWords[1]) !== false
                                        && stripos($row[author], $bookTitleWords[2]) !== false
                                        && stripos($row[author], $bookTitleWords[3]) !== false
                                        && stripos($row[author], $bookTitleWords[4]) !== false) {
                                        printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);

                                        array_push($arrayID, $row[id]);
                                    }
                                }
                            }
                            else {
                                if (stripos($row[author], $bookTitleWords[0]) !== false
                                    && stripos($row[author], $bookTitleWords[1]) !== false
                                    && stripos($row[author], $bookTitleWords[2]) !== false
                                    && stripos($row[author], $bookTitleWords[3]) !== false) {
                                    printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);

                                    array_push($arrayID, $row[id]);
                                }
                            }
                        }
                        else {
                            if (stripos($row[author], $bookTitleWords[0]) !== false
                                && stripos($row[author], $bookTitleWords[1]) !== false
                                && stripos($row[author], $bookTitleWords[2]) !== false) {
                                printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);

                                array_push($arrayID, $row[id]);
                            }
                        }
                    }
                    else {
                        if (stripos($row[author], $bookTitleWords[0]) !== false
                            && stripos($row[author], $bookTitleWords[1]) !== false) {
                            printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);

                            array_push($arrayID, $row[id]);
                        }
                    }
                }
                else {
                    if (stripos($row[author], $bookTitleWords[0]) !== false) {
                        printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);

                        array_push($arrayID, $row[id]);
                    }
                }
            }
        }

        return $arrayID;
    }

    function printFoundBooks($link, $query, $partsCount, $bookTitleWords, $arrayID, $admin) {
        $result = mysqli_query($link, $query);
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
                                        printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);
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
                                        printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);
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
                                    && (stripos($row[author], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWords[3]) !== false || stripos($row[title], $bookTitleWord3WithAccent) !== false || stripos($row[publishing], $bookTitleWords[3]) !== false)) {printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);
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
                                printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);
                            }
                        }
                    }
                    else {
                        $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);
                        $bookTitleWord1WithAccent = addAccent($bookTitleWords[1]);

                        if ((stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false)
                            && (stripos($row[author], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWords[1]) !== false || stripos($row[title], $bookTitleWord1WithAccent) !== false || stripos($row[publishing], $bookTitleWords[1]) !== false)) {
                            printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);
                        }
                    }
                }
                else {
                    $bookTitleWord0WithAccent = addAccent($bookTitleWords[0]);

                    if (stripos($row[author], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWords[0]) !== false || stripos($row[title], $bookTitleWord0WithAccent) !== false || stripos($row[publishing], $bookTitleWords[0]) !== false) {
                        if ($bookTitleWord0WithAccent != 'a&') {
                            printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $row['new'], $admin);
                        }
                    }
                }
            }
        }
    }

    function supportNewBooksByCountAndDate($link, $addingDatetime, $addedBookID) {
        $datetime1 = date_create($addingDatetime);
        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE id != '$addedBookID' AND new = 1 ORDER BY id DESC");
        $newBookCount = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $newBookID = $row[id];
            $newBookCount++;
            $datetime2 = date_create($row[addingDatetime]);
            $interval = date_diff($datetime1, $datetime2)->format('%a');

            if ($newBookCount > 3 || $interval > 45) {
                mysqli_query($link, "UPDATE catalogue SET new = 0 WHERE id = '$newBookID'");
            }
        }
    }

    function supportNewBooksByDate($link) {
        $datetime1 = date_create(date('Y-m-d H:i:s'));
        $result = mysqli_query($link, "SELECT * FROM catalogue ORDER BY id DESC");
        $bookCount = 0;
        while (($row = mysqli_fetch_assoc($result)) && ($bookCount < 4)) {
            $newBookID = $row[id];
            $datetime2 = date_create($row[addingDatetime]);
            $interval = date_diff($datetime1, $datetime2)->format('%a');

            if ($interval > 45 || $bookCount == 3) {
                mysqli_query($link, "UPDATE catalogue SET new = 0 WHERE id = '$newBookID'");
            }
            else {
                mysqli_query($link, "UPDATE catalogue SET new = 1 WHERE id = '$newBookID'"); // нужно, когда вернули удалённую новинку
            }

            $bookCount++;
        }
    }

    function supportNewBooksAtRemoval($link) {
        $result = mysqli_query($link, "SELECT COUNT(*) FROM catalogue WHERE new = 1 ORDER BY id DESC");
        $row = mysqli_fetch_assoc($result);
        if ($row["COUNT(*)"] < 3) {
            // Возможно, удалили новинку
            supportNewBooksByDate($link);
        }
    }

    function printBookTemplate($id, $author, $title, $publishing, $price, $monthBook, $description, $onHands, $new, $admin) {
        if ($author != '')
            $author = '<div class="grid__item__authortitle__author">' . $author . '</div>';

        if ($price != 0)
            $price = '<div class="grid__item__sticker grid__item__sticker_price">' . $price . '&thinsp;€</div>';
        else
            $price = '';

        if ($new != 0) {
            $new = '<div class="grid__item__sticker grid__item__sticker_new">Novità</div>';
            $newClassForEdit = ' margin-for-sticker_new';
            $adminEdit = <<<HERE
                <div class="grid__item__admin grid__item__admin_edit$newClassForEdit"></div>
HERE;
        }
        else
            $new = '';

        if ($monthBook == 1) {
            $monthBookClass = ' grid__item_month-book-color';
            $monthBookBlock = <<<HERE
                        <div class="month-book">
                            <div class="month-book__wrap">
                                <div class="month-book__wrap__label">
                                    <span class="month-book__wrap__label__text">★ Libro del mese</span>
                                </div>
                                <p class="month-book__wrap__description">$description</p>
                            </div>
                        </div>
HERE;
        }

        if ($admin != '') {
            $id = "data-id=\"$id\"";

            $bookOnHandsTick = '';
            if ($onHands == 1)
                $bookOnHandsTick = 'checked';

            $adminOnHands = <<<HERE
                <div class="grid__item__admin grid__item__admin_panel grid__item__admin_on-hands">
		            <div class="form__element">
					    <label class="form__element__label">
						    <input type="checkbox" name="on_hands" value="on_hands" $bookOnHandsTick autocomplete="off" class="form__element__label__checkbox form__element__label__checkbox_on-hands">
							<span class="form__element__label__fake-checkbox"></span> In prestito
						</label>
					</div>
			    </div>
HERE;

            if ($new) {
                $newClassForEdit .= ' margin-for-edit';
            }

            $adminEdit = <<<HERE
                <div class="grid__item__admin grid__item__admin_edit$newClassForEdit">
                    <?xml version="1.0" encoding="utf-8"?>
                    <!-- Generator: Adobe Illustrator 22.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 67.7 79.8" style="enable-background:new 0 0 67.7 79.8;" xml:space="preserve">
                    <path class="grid__item__admin_edit__icon" d="M60.3,24.8L42.4,9.4C45.4,6,47.7,3.3,49,2c7.4-7.2,24.3,6.9,16.7,16.1C64.7,19.4,62.8,21.8,60.3,24.8z M21.4,73.1L0,79.8
                        l3.8-22.6c0,0,20.2-25.6,34-42.2l18,15.5C42.4,47,21.4,73.1,21.4,73.1z"/>
                    </svg>
                </div>
HERE;
        }
        else {
            $id = '';

            if ($onHands == 1) {
                $onHandsClass = ' grid__item_on-hands';
                $onHandsText = '<div class="grid__item_on-hands__text">In prestito</div>';
            }
        }


        echo <<<HERE
                    <div class="grid__item$monthBookClass$onHandsClass"$id>
                        <div class="grid__item__authortitle">
                            $adminEdit
                            $author
                            <div class="grid__item__authortitle__title" title="$title">$title</div>
                        </div>
                        <div class="grid__item__publishing">$publishing</div>
                        $price
                        $adminOnHands
                        $onHandsText
                        $new
                    </div>
                    $monthBookBlock
HERE;
    }

    function printBookAddingLink($admin, $position) {
        if ($admin == 'admin')
            echo '<div class="grid__item grid__item_place grid__item_link-to-book-adding grid__item_link-to-book-adding_position'.$position.'"><a href="+/" class="grid__item_link-to-book-adding__link grid__item_link-to-book-adding__link_desktop"></a><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 74.73 72.82" class="grid__item_link-to-book-adding__icon"><defs><style>.a{fill:url(#a);}</style><linearGradient id="a" x1="37.5" y1="1.06" x2="37.5" y2="73.88" gradientUnits="userSpaceOnUse"><stop offset="0" class="grid__item_link-to-book-adding__icon__gradient-color grid__item_link-to-book-adding__icon__gradient-color_1"/><stop offset="1" class="grid__item_link-to-book-adding__icon__gradient-color grid__item_link-to-book-adding__icon__gradient-color_2"/></linearGradient></defs><title>Aggiungere un libro</title><path class="a" d="M33.84,40.81H.13V34.13H33.84V1.06h7.31V34.13H74.86v6.68H41.15V73.88H33.84Z" transform="translate(-0.13 -1.06)"/></svg><a href="+/" class="grid__item_link-to-book-adding__link grid__item_link-to-book-adding__link_mobile">Aggiungere nuovo libro…</a></div>';
    }

    function printEvents($link, $admin) {
        $result = mysqli_query($link, "SELECT event FROM events WHERE id = 1");
        $row = mysqli_fetch_assoc($result);
        $event = $row['event'];

        if ($event != '') {
            // Типограф каждого абзаца, иначе склеиваются
            $event = explode("\n\n", $event);
            for ($eventRowI = 0; $eventRowI < count($event); $eventRowI++) {
                $event[$eventRowI] = typograf($event[$eventRowI]);
            }
            $event = implode("\n\n", $event);
        }

        if ($admin == 'admin') {
            echo <<<HERE
                <div class="grid__events grid__events_admin">
                    <form class="grid__events__form">
                        <textarea name="event" placeholder="Scriva l’evento qui" class="grid__events__form__textarea">$event</textarea>
                    </form>
                </div>
HERE;
        }
        else {
            if ($event != '') {
                $event = str_replace("\n", "<br>", $event);
                echo '<div class="grid__events">'.$event.'</div>';
            }
        }
    }

    function addAccent($word) {
        if (strlen($word) > 1) {
            switch(substr($word[strlen($word)-1], -1)) {
                case 'a':
                    $word[strlen($word)-1] = str_replace('a', '&agrave;', $word[strlen($word)-1]);
                    break;
                case 'o':
                    $word[strlen($word)-1] = str_replace('o', '&ograve;', $word[strlen($word)-1]);
                    break;
            }
        }
        else {
            switch($word) {
                case 'a':
                    $word = '&agrave;';
                    break;
                case 'o':
                    $word = '&ograve;';
                    break;
            }
        }

        return $word;
    }