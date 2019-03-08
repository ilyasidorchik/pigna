<?php
    function addAccent($word) {
        switch (substr($word[strlen($word)-1], -1)) {
            case 'a':
                $word[strlen($word)-1] = str_replace('a', '&agrave;', $word[strlen($word)-1]);
                break;
            case 'o':
                $word[strlen($word)-1] = str_replace('o', '&ograve;', $word[strlen($word)-1]);
                break;
        }

        return $word;
    }

    function printBookTemplate($author, $title, $publishing, $price, $monthBook, $description, $onHands) {
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
                                    <span class="month-book__wrap__label__text">Libro del mese</span>
                                </div>
                                <p class="month-book__wrap__description">$description</p>
                            </div>
                        </div>
HERE;
        }

        if ($onHands == 1) {
            $onHandsClass = 'grid__item_on-hands';
            $onHandsText = '<div class="grid__item_on-hands__text">In prestito</div>';
        }

        echo <<<HERE
                    <div class="grid__item $monthBookClass $onHandsClass">
                        <div class="grid__item__authortitle">
                            $author
                            <div class="grid__item__authortitle__title" title="$title">$title</div>
                        </div>
                        <div class="grid__item__publishing">$publishing</div>
                        $price
                        $onHandsText
                    </div>
                    $monthBookBlock
HERE;
    }