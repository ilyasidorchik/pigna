<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cercare libri nella piccola biblioteca della Pigna</title>
        <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet/less" type="text/css" href="css/style.less">
	    <link rel="stylesheet" href="css/likely.css">
    </head>
    <body class="page">
        <div class="search">
            <div class="search__icon">
	            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                 viewBox="0 0 27.9 50" style="enable-background:new 0 0 27.9 50;" xml:space="preserve">
					<style type="text/css">
						.st0{fill:none;stroke:#000000;stroke-width:3;stroke-miterlimit:10;}
					</style>
		            <circle class="st0" cx="10.9" cy="24.1" r="9.4"/>
		            <rect x="20" y="27.6" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -18.3066 25.467)" width="3.2" height="14.5"/>
				</svg>
            </div>
            <div class="search__form">
                <form action="result.php" method="POST">
                    <input type="text" name="title" placeholder="Cercare libri nella piccola biblioteca della Pigna" autofocus class="input input-h1" id="searchInput" autocomplete="off">
                </form>
            </div>
        </div>
        <div class="grid">
            <?php
	            $ini = parse_ini_file('app.ini', true);

	            $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
                mysqli_set_charset($link, 'utf8');


                // Книга месяца
	            $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 1");
	            while ($row = mysqli_fetch_assoc($result)) {
	                if ($row[author] != '')
	                    $row[author] = '<div class="grid__item__authortitle__author">'.$row[author].'</div>';

                    if ($row[price] != 0)
                        $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">'.$row[price].'&thinsp;€</div>';
                    else
                        $row[price] = '';

	                echo <<<HERE
							<div class="grid__item grid__item_month-book-color">
				                <div class="grid__item__authortitle">
				                    $row[author]
				                    <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
				                </div>
				                <div class="grid__item__publishing">$row[publishing]</div>
				                $row[price]
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

	            // Все остальные книги
	            $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0");
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
            ?>
	        <div class="grid__map">
		        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d33173.89690284556!2d7.755294541201746!3d43.825032715927975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12cdf544cdcf4413%3A0x6fdc27853a84168!2zVmljb2xvIEJhbGlsbGEsIDEsIDE4MDM4IFNhbnJlbW8gSU0sINCY0YLQsNC70LjRjw!5e0!3m2!1sru!2sru!4v1548087749546" width="100%" height="156" frameborder="0" style="border:0" allowfullscreen></iframe>
	        </div>
	        <div class="grid__description">
		        <div class="likely likely-big">
			        <div class="twitter">Twittare</div>
			        <div class="facebook">Condividere</div>
			        <div class="linkedin"></div>
			        <div class="whatsapp"></div>
			        <div class="telegram">Inviare</div>
			        <div class="pinterest">Pinteressarsi</div>
		        </div>
		        <p>Piazza del Capitolo, 1, Sanremo · <a href="tel:+390184501132" class="link">+39 0184 501132</a> · <a href="mailto:piccolabibliopigna@gmail.com" class="link">piccolabibliopigna@gmail.com</a></p>
		        <p>Siamo aperti martedì dalle 15 alle 18 e sabato dalle 9 alle 12.</p>
		        <p>
			        Sito creato da direttore d’arte e tecnologo <a href="http://sidorchik.ru/" class="link">Ilià Sidorcic</a>
			        <br>e autore dell’idea e progettista <a href="http://robertblinov.net/" class="link">Robert Blinov</a>
		        </p>
	        </div>
        </div>
        <script src="js/likely.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>
        <script src="js/script.js"></script>
    </body>
</html>