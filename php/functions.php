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

        $prepositions = array(" di ", " a ", " da ", " in ", " con ", " su ", " per ", " tra ", " fra ", " e ", " o ", " il ", " lo ", " la ", " i ", " gli ", " le ", " del ", " dello ", " della ", " dei ", " degli ", " delle ", " al ", " allo ", " alla ", " ai ", " agli ", " alle ", " dal ", " dallo ", " dalla ", " dai ", " dagli ", " dalle ", " nel ", " nello ", " nella ", " nei ", " negli ", " nelle ", " sul ", " col ", " sullo ", " sulla ", " sui ", " sugli ", " sulle ", "san ");
        $prepositionsTypografed = array("di&nbsp;", " a&nbsp;", " da&nbsp;", " in&nbsp;", " con&nbsp;", " su&nbsp;", " per&nbsp;", " tra&nbsp;", " fra&nbsp;", " e&nbsp;", " o&nbsp;", " il&nbsp;", " lo&nbsp;", " la&nbsp;", " i&nbsp;", " gli&nbsp;", " le&nbsp;", " del&nbsp;", " dello&nbsp;", " della&nbsp;", " dei&nbsp;", " degli&nbsp;", " delle&nbsp;", " al&nbsp;", " allo&nbsp;", " alla&nbsp;", " ai&nbsp;", " agli&nbsp;", " alle&nbsp;", " dal&nbsp;", " dallo&nbsp;", " dalla&nbsp;", " dai&nbsp;", " dagli&nbsp;", " dalle&nbsp;", " nel&nbsp;", " nello&nbsp;", " nella&nbsp;", " nei&nbsp;", " negli&nbsp;", " nelle&nbsp;", " sul&nbsp;", " col&nbsp;", " sullo&nbsp;", " sulla&nbsp;", " sui&nbsp;", " sugli&nbsp;", " sulle&nbsp;", "san ");
        $strTypografed = str_replace($prepositions, $prepositionsTypografed, $strTypografed);

        return $strTypografed;
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

    function printBookTemplate($id, $author, $title, $publishing, $price, $monthBook, $description, $onHands, $admin) {
        if ($author != '')
            $author = '<div class="grid__item__authortitle__author">' . $author . '</div>';

        if ($price != 0)
            $price = '<div class="grid__item__sticker grid__item__sticker_price">' . $price . '&thinsp;€</div>';
        else
            $price = '';

        if ($monthBook == 1) {
            $monthBookClass = 'grid__item_month-book-color';
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

            $adminBlock = <<<HERE
                <div class="grid__item__admin grid__item__admin_panel grid__item__admin_on-hands">
		            <div class="form__element">
					    <label class="form__element__label">
						    <input type="checkbox" name="on_hands" value="on_hands" $bookOnHandsTick autocomplete="off" class="form__element__label__checkbox form__element__label__checkbox_on-hands">
							<span class="form__element__label__fake-checkbox"></span> In prestito
						</label>
					</div>
			    </div>
                <div class="grid__item__admin grid__item__admin_edit">
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
            if ($onHands == 1) {
                $onHandsClass = 'grid__item_on-hands';
                $onHandsText = '<div class="grid__item_on-hands__text">In prestito</div>';
            }
        }


        echo <<<HERE
                    <div class="grid__item $monthBookClass $onHandsClass" $id>
                        <div class="grid__item__authortitle">
                            $author
                            <div class="grid__item__authortitle__title" title="$title">$title</div>
                        </div>
                        <div class="grid__item__publishing">$publishing</div>
                        $price
                        $adminBlock
                        $onHandsText
                    </div>
                    $monthBookBlock
HERE;
    }