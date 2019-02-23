<!DOCTYPE html>
    <html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin</title>
        <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet/less" type="text/css" href="../css/style.less">
    </head>
    <body class="page">
        <h1 class="h1 input-h1"><a href="/" class="link">Piccola biblioteca della Pigna</a></h1>
        <div class="book-adding">
	        <h2>Aggiungere un nuovo libro al catalogo</h2>
	        <div class="book-adding__form">
		        <form>
			        <div class="form">
				        <div class="form__label">
					        <label for="author">Autore</label>
				        </div>
				        <div class="form__element">
					        <input type="text" name="author" id="author" autocomplete="off" autofocus class="form__element__input form__element__input-author">
				        </div>

				        <div class="form__label" style="padding-top: .55rem;">
					        <label for="title">Titolo</label>
				        </div>
				        <div class="form__element">
					        <input type="text" name="title" id="title" autocomplete="off" class="form__element__input form__element__input-title">
				        </div>

				        <div class="form__label">
					        <label for="publishing-city">Città editore</label>
				        </div>
				        <div class="form__element form__element-short">
					        <input type="text" name="publishing_city" id="publishing-city" autocomplete="off" class="form__element__input form__element__input-publishing-city">
				        </div>

				        <div class="form__label" style="margin-top: -1.05rem;">
					        <label for="publishing-year">Anno&nbsp;pub-<br>blicazione</label>
				        </div>
				        <div class="form__element form__element-very-short" style="margin-top: -1rem;">
					        <input type="text" name="publishing_year" id="publishing-year" autocomplete="off" class="form__element__input form__element__input-publishing-year">
				        </div>

				        <div class="form__element" style="margin-top: -1.2rem;">
					        <label class="form__element__label">
						        <input type="checkbox" name="month_book" value="month_book" autocomplete="off" class="form__element__label__checkbox form__element__label-description">
						        <span class="form__element__label__fake-checkbox"></span> Libro del mese
					        </label>
				        </div>
				        <div class="form__label form__label-description form__close-to-checkbox" style="display: none;">
					        <label for="book_description">Descri-<br>zione</label>
				        </div>
				        <div class="form__element form__element-description form__close-to-checkbox" style="display: none;">
					        <textarea name="book_description" id="book_description" class="form__element__input form__element__textarea form__element__input-month-book-description"></textarea>
				        </div>

				        <div class="form__element" style="margin-top: -.3rem;">
					        <label class="form__element__label">
						        <input type="checkbox" name="book_for_sale" value="book_for_sale" autocomplete="off" class="form__element__label__checkbox form__element__label-price">
						        <span class="form__element__label__fake-checkbox"></span> In vendita
					        </label>
				        </div>
				        <div class="form__label form__close-to-checkbox form__label-price" style="display: none;">
					        <label for="price">Prezzo</label>
				        </div>
				        <div class="form__element form__element-short form__close-to-checkbox form__element-price" style="display: none;">
					        <div class="form__element__wrap-for-price">
						        <input type="text" name="price" id="price" autocomplete="off" class="form__element__input form__element__wrap-for-price__number form__element__input-price">
						        <div class="form__element__note form__element__wrap-for-price__currency-sign">€</div>
					        </div>
				        </div>

				        <div class="form__element">
					        <button class="form__element__button book-adding__button">Aggiornare</button>
				        </div>
			        </div>
		        </form>
	        </div>
	        <div class="book-adding__cover">
		        <div class="grid__item" style="display: none;">
			        <div class="grid__item__authortitle">
				        <div class="grid__item__authortitle__author"></div>
				        <div class="grid__item__authortitle__title"></div>
			        </div>
			        <div class="grid__item__publishing"></div>
		        </div>
	        </div>
	        <div class="book-adding__book-month"></div>
        </div>

        <div class="book-editing">
	        <div class="book-editing__cover">
		        <div class="grid__item">
			        <div class="grid__item__authortitle">
				        <div class="grid__item__authortitle__author">Calvini Nilo</div>
				        <div class="grid__item__authortitle__title" title="Pagine di storia Sanremasca">Pagine di storia Sanremasca</div>
			        </div>
			        <div class="grid__item__publishing">Sanremo, 1978</div>
		        </div>
	        </div>
	        <div class="book-adding__book-month"></div>
	        <form class="book-editing__form">
		        <div class="form">
			        <div class="form__label">
				        <label for="author">Autore</label>
			        </div>
			        <div class="form__element">
				        <input type="text" name="author" id="author" autocomplete="off" autofocus class="form__element__input form__element__input-author">
			        </div>

			        <div class="form__label" style="padding-top: .55rem;">
				        <label for="title">Titolo</label>
			        </div>
			        <div class="form__element">
				        <input type="text" name="title" id="title" autocomplete="off" class="form__element__input form__element__input-title">
			        </div>

			        <div class="form__label">
				        <label for="publishing-city">Città editore</label>
			        </div>
			        <div class="form__element form__element-short">
				        <input type="text" name="publishing_city" id="publishing-city" autocomplete="off" class="form__element__input form__element__input-publishing-city">
			        </div>

			        <div class="form__label" style="margin-top: -1.05rem;">
				        <label for="publishing-year">Anno&nbsp;pub-<br>blicazione</label>
			        </div>
			        <div class="form__element form__element-very-short" style="margin-top: -1rem;">
				        <input type="text" name="publishing_year" id="publishing-year" autocomplete="off" maxlength="4" class="form__element__input form__element__input-publishing-year">
			        </div>

			        <div class="form__element" style="margin-top: -1.2rem;">
				        <label class="form__element__label">
					        <input type="checkbox" name="month_book" value="month_book" autocomplete="off" class="form__element__label__checkbox form__element__label-description">
					        <span class="form__element__label__fake-checkbox"></span> Libro del mese
				        </label>
			        </div>
			        <div class="form__label form__label-description form__close-to-checkbox" style="display: none;">
				        <label for="book_description">Descri-<br>zione</label>
			        </div>
			        <div class="form__element form__element-description form__close-to-checkbox" style="display: none;">
				        <textarea name="book_description" id="book_description" class="form__element__input form__element__textarea form__element__input-month-book-description"></textarea>
			        </div>

			        <div class="form__element" style="margin-top: -.3rem;">
				        <label class="form__element__label">
					        <input type="checkbox" name="book_for_sale" value="book_for_sale" autocomplete="off" class="form__element__label__checkbox form__element__label-price">
					        <span class="form__element__label__fake-checkbox"></span> In vendita
				        </label>
			        </div>
			        <div class="form__label form__close-to-checkbox form__label-price" style="display: none;">
				        <label for="price">Prezzo</label>
			        </div>
			        <div class="form__element form__element-short form__close-to-checkbox form__element-price" style="display: none;">
				        <div class="form__element__wrap-for-price">
					        <input type="text" name="price" id="price" autocomplete="off" class="form__element__input form__element__wrap-for-price__number form__element__input-price">
					        <div class="form__element__note form__element__wrap-for-price__currency-sign">€</div>
				        </div>
			        </div>
		        </div>
	        </form>
        </div>

        <div class="grid">

            <?php
                $ini = parse_ini_file('../app.ini', true);

                $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
                mysqli_set_charset($link, 'utf8');

                $result = mysqli_query($link, "SELECT * FROM catalogue");

                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row[author] != '')
                        $row[author] = '<div class="grid__item__authortitle__author">'.$row[author].'</div>';

                    echo <<<HERE
						<div class="grid__item">
			                <div class="grid__item__authortitle">
			                    $row[author]
			                    <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
			                </div>
			                <div class="grid__item__publishing">$row[publishing]</div>
			            </div>
HERE;
                }
            ?>
        </div>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>
        <script src="/js/script.js"></script>
    </body>
</html>