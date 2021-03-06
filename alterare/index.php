<?php
    $ini = parse_ini_file('../app.ini', true);
    $hash = password_hash($ini[admin][password], PASSWORD_DEFAULT);

    $password = $_POST['password'];

    if ($password == $ini[admin][password] && !isset($_COOKIE["admin_rights"]))
        SetCookie('admin_rights', $hash, time()+60*60*24*365*10, '/');
	else {
        $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
        mysqli_set_charset($link, 'utf8');

        $result = mysqli_query($link, "SELECT * FROM catalogue WHERE id = '$_GET[libro]'");
        $row = mysqli_fetch_assoc($result);

        if ($row[id] == NULL)
            header("Location: http://accademiapigna.sidorchik.ru");
    }
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Alterare libro</title>
        <link rel="shortcut icon" href="/img/favicon.ico">
        <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon-180x180.png">
        <link rel="stylesheet/less" type="text/css" href="/css/style.less">
    </head>
    <body class="page">
        <h1 class="h1 input-h1"><a href="/" class="link h1__link">Piccola biblioteca della&nbsp;Pigna</a></h1>
        <?php
        if (password_verify($ini[admin][password], $_COOKIE['admin_rights']) || $password == $ini[admin][password]) {
            $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
            mysqli_set_charset($link, 'utf8');

            $result = mysqli_query($link, "SELECT * FROM catalogue WHERE id = '$_GET[libro]'");
            $row = mysqli_fetch_assoc($result);

            $authorStatus = 'none';
            if ($row[author] != '')
                $authorStatus = 'block';

            $publishingCity = '';
		    $publishingYear = '';
		    if ($row[publishing] != '') {
		        if (strpos($row[publishing], ', ') !== false) {
		        	$publishingParts = explode(', ', $row[publishing]);
		            $publishingCity = $publishingParts[0];
		            $publishingYear = $publishingParts[1];
		        }
		        else {
		            if (!is_numeric($row[publishing]))
                        $publishingCity = $row[publishing];
		            else
                        $publishingYear = $row[publishing];
		        }
		    }

            $monthBookCheckbox = '';
            $monthBookClass = '';
		    $monthBookStatus = 'none';
		    if ($row[monthBook]) {
		        $monthBookCheckbox = 'checked';
		        $monthBookClass = 'grid__item_month-book-color';
		        $monthBookStatus = 'block';
		    }

		    $price = '';
            $priceCheckbox = '';
            $priceStatus = 'none';
            if ($row[price] != 0) {
                $priceCheckbox = 'checked';
                $priceStatus = 'block';
                $price = $row[price];
            }

            echo <<<HERE
                            <div class="book-editing">
                                <h2 class="h2">Alterare libro</h2>
                                <div class="book-editing__form">
                                    <form>
                                        <div class="form">
                                            <div class="form__label">
                                                <label for="title">Titolo</label>
                                            </div>
                                            <div class="form__element">
                                                <input type="text" name="title" id="title" autocomplete="off" class="form__element__input form__element__input_title" value="$row[title]" data-title="$row[title]">
                                            </div>
                    
                                            <div class="form__label">
                                                <label for="author">Autore</label>
                                            </div>
                                            <div class="form__element">
                                                <input type="text" name="author" id="author" autocomplete="off" class="form__element__input form__element__input_author" value="$row[author]" data-author="$row[author]">
                                            </div>
                    
                                            <div class="form__label">
                                                <label for="publishing-city">Città editrice</label>
                                            </div>
                                            <div class="form__element">
                                                <input type="text" name="publishing_city" id="publishing-city" autocomplete="off" class="form__element__input form__element__input_publishing-city" value="$publishingCity" data-publishingCity="$publishingCity">
                                            </div>
                    
                                            <div class="form__label form__labelelement_publishing-year-margin-fix">
                                                <label for="publishing-year" class="form__label__label_publishing-year">Anno&nbsp;pub-<br>blicazione</label>
                                            </div>
                                            <div class="form__element form__element_short form__labelelement_publishing-year-margin-fix">
                                                <input type="text" name="publishing_year" id="publishing-year" autocomplete="off" maxlength="4" class="form__element__input form__element__input_publishing-year" value="$publishingYear" data-publishingYear="$publishingYear">
                                            </div>
                    
                                            <div class="form__element form__element_checkbox form__element_checkbox-month-book">
                                                <label class="form__element__label">
                                                    <input type="checkbox" name="month_book" value="month_book" autocomplete="off" class="form__element__label__checkbox form__element__label__checkbox_description" $monthBookCheckbox data-monthBook="$monthBookCheckbox">
                                                    <span class="form__element__label__fake-checkbox"></span> Libro del mese
                                                </label>
                                            </div>
                                            <div class="form__label form__close-to-checkbox form__label_description" style="display: $monthBookStatus;">
                                                <label for="book_description" class="form__label__label_description">Descri-<br>zione</label>
                                            </div>
                                            <div class="form__element form__close-to-checkbox form__element_description form__element_by-checkbox" style="display: $monthBookStatus;">
                                                <textarea name="book_description" id="book_description" class="form__element__input form__element__textarea form__element__input_month-book-description" data-monthBookDesc="$row[description]">$row[description]</textarea>
                                            </div>
                    
                                            <div class="form__element form__element_checkbox form__element_checkbox-price">
                                                <label class="form__element__label">
                                                    <input type="checkbox" name="book_for_sale" value="book_for_sale" autocomplete="off" class="form__element__label__checkbox form__element__label__checkbox_price" $priceCheckbox>
                                                    <span class="form__element__label__fake-checkbox"></span> In vendita
                                                </label>
                                            </div>
                                            <div class="form__label form__close-to-checkbox form__label_price" style="display: $priceStatus;">
                                                <label for="price">Prezzo</label>
                                            </div>
                                            <div class="form__element form__close-to-checkbox form__element_price form__element_by-checkbox" style="display: $priceStatus;">
                                                <div class="form__element__wrap-for-price">
                                                    <input type="text" name="price" id="price" autocomplete="off" class="form__element__input form__element__wrap-for-price__number form__element__input_price" value="$price" data-price="$price">
                                                    <div class="form__element__wrap-for-price__currency-sign">€</div>
                                                </div>
                                            </div>
                                            <div class="form__element">
										        <button class="form__element__button form__element__button_book-adding">Aggiornare</button>
										        <span class="form__element__remove-link">× <a class="form__element__remove-link__underline ★ pseudolink">Eliminare</a></span>
									        </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="book-editing__cover">
                                    <div class="grid__item $monthBookClass">
                                        <div class="grid__item__authortitle">
                                            <div class="grid__item__authortitle__author" style="display: $authorStatus;">$row[author]</div>
                                            <div class="grid__item__authortitle__title">$row[title]</div>
                                        </div>
                                        <div class="grid__item__publishing">$row[publishing]</div>
                                        <div class="grid__item__sticker grid__item__sticker_price" style="display: $priceStatus;">$row[price]&thinsp;€</div>
                                    </div>
                                </div>
                                <div class="book-editing__month-book month-book" style="display: $monthBookStatus;">
                                    <div class="book-editing__month-book__wrap month-book__wrap">
                                        <div class="book-editing__month-book__wrap__label month-book__wrap__label">
                                            <span class="month-book__wrap__label__text">★ Libro del mese</span>
                                        </div>
                                        <p class="book-editing__month-book__wrap__description month-book__wrap__description">$row[description]</p>
                                    </div>
                                </div>
                            </div>
HERE;
        }
        else {
            if ($password != '' && $password != $ini[admin][password]) {
                $inputInvalid = 'form__element__input_invalid';
                $warningPassword = '<div class="form__element__warning">Chiave di accesso sbagliata</div>';
            }

            echo <<<HERE
                            <div class="book-editing">
                                <h2 class="h2">Accesso al pannello amministrativo</h2>
                                <div class="book-editing__form">
                                    <form method="POST" action="">
                                        <div class="form">
                                            <div class="form__label">
                                                <label for="password">Chiave di accesso</label>
                                            </div>
                                            <div class="form__element form__element_password">
                                                <input type="password" name="password" id="password" autocomplete="off" class="form__element__input form__element__input_password $inputInvalid" value="$password">$warningPassword
                                            </div>
                    
                                            <div class="form__element">
                                                <button class="form__element__button form__element__button_entering form__element__button-disabled" name="enter">Entrare</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
HERE;
        }
        ?>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>
        <script src="/js/script.js"></script>
    </body>
</html>
