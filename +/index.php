<?php
	$ini = parse_ini_file('../app.ini', true);
	$hash = password_hash($ini[admin][password], PASSWORD_DEFAULT);

	$password = $_POST['password'];

	if ($password == $ini[admin][password] && !isset($_COOKIE["admin_rights"]))
        SetCookie('admin_rights', $hash, time()+60*60*24*365*10, '/');
?>
<!DOCTYPE html>
    <html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Nuovo libro</title>
	    <link rel="shortcut icon" href="/img/favicon.ico">
	    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon-180x180.png">
        <link rel="stylesheet/less" type="text/css" href="/css/style.less">
    </head>
    <body class="page">
        <h1 class="h1 input-h1"><a href="/" class="link h1__link">Piccola biblioteca della Pigna</a></h1>
        <?php
            if (password_verify($ini[admin][password], $_COOKIE['admin_rights']) || $password == $ini[admin][password]) {
            	echo <<<HERE
					<div class="book-editing">
				        <h2 class="h2">Nuovo libro</h2>
				        <div class="book-editing__form">
					        <form>
						        <div class="form">
							        <div class="form__label">
								        <label for="title">Titolo</label>
							        </div>
							        <div class="form__element">
								        <input type="text" name="title" id="title" autofocus autocomplete="off" class="form__element__input form__element__input_title">
							        </div>
			
							        <div class="form__label">
								        <label for="author">Autore</label>
							        </div>
							        <div class="form__element">
								        <input type="text" name="author" id="author" autocomplete="off" class="form__element__input form__element__input_author">
							        </div>
			
							        <div class="form__label">
								        <label for="publishing-city">Città editrice</label>
							        </div>
							        <div class="form__element">
								        <input type="text" name="publishing_city" id="publishing-city" autocomplete="off" class="form__element__input form__element__input_publishing-city">
							        </div>
			
							        <div class="form__label form__labelelement_publishing-year-margin-fix">
								        <label for="publishing-year" class="form__label__label_publishing-year">Anno&nbsp;pub-<br>blicazione</label>
							        </div>
							        <div class="form__element form__element_short form__labelelement_publishing-year-margin-fix">
								        <input type="text" name="publishing_year" id="publishing-year" autocomplete="off" maxlength="4" class="form__element__input form__element__input_publishing-year">
							        </div>
			
							        <div class="form__element form__element_checkbox form__element_checkbox-month-book">
								        <label class="form__element__label">
									        <input type="checkbox" name="month_book" value="month_book" autocomplete="off" class="form__element__label__checkbox form__element__label__checkbox_description">
									        <span class="form__element__label__fake-checkbox"></span> Libro del mese
								        </label>
							        </div>
							        <div class="form__label form__close-to-checkbox form__label_description" style="display: none;">
								        <label for="book_description" class="form__label__label_description">Descri-<br>zione</label>
							        </div>
							        <div class="form__element form__close-to-checkbox form__element_description form__element_by-checkbox" style="display: none;">
								        <textarea name="book_description" id="book_description" class="form__element__input form__element__textarea form__element__input_month-book-description"></textarea>
							        </div>
			
							        <div class="form__element form__element_checkbox form__element_checkbox-price">
								        <label class="form__element__label">
									        <input type="checkbox" name="book_for_sale" value="book_for_sale" autocomplete="off" class="form__element__label__checkbox form__element__label__checkbox_price">
									        <span class="form__element__label__fake-checkbox"></span> In vendita
								        </label>
							        </div>
							        <div class="form__label form__close-to-checkbox form__label_price" style="display: none;">
								        <label for="price">Prezzo</label>
							        </div>
							        <div class="form__element form__close-to-checkbox form__element_price form__element_by-checkbox" style="display: none;">
								        <div class="form__element__wrap-for-price">
									        <input type="text" name="price" id="price" autocomplete="off" class="form__element__input form__element__wrap-for-price__number form__element__input_price">
									        <div class="form__element__wrap-for-price__currency-sign">€</div>
								        </div>
							        </div>
			
							        <div class="form__element">
								        <button class="form__element__button form__element__button_book-adding form__element__button-disabled">Aggiungere</button>
							        </div>
						        </div>
					        </form>
				        </div>
				        <div class="book-editing__cover">
					        <div class="grid__item">
						        <div class="grid__item__authortitle">
							        <div class="grid__item__authortitle__author" style="display: none;"></div>
							        <div class="grid__item__authortitle__title"></div>
						        </div>
						        <div class="grid__item__publishing"></div>
						        <div class="grid__item__sticker grid__item__sticker_price" style="display: none;"></div>
					        </div>
				        </div>
				        <div class="book-editing__month-book month-book" style="display: none;">
					        <div class="book-editing__month-book__wrap month-book__wrap">
						        <div class="month-book__wrap__label">
							        <span class="month-book__wrap__label__text">★ Libro del mese</span>
						        </div>
						        <p class="month-book__wrap__description"></p>
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