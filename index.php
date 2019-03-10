<?php
	include 'php/functions.php';
	/*include 'php/remotetypograf.php';
	function typograf($str) {
	    $remoteTypograf = new RemoteTypograf('UTF-8');

	    $remoteTypograf->htmlEntities();
	    $remoteTypograf->br (false);
	    $remoteTypograf->p (false);
	    $remoteTypograf->nobr (3);
	    $remoteTypograf->quotA ('laquo raquo');
	    $remoteTypograf->quotB ('bdquo ldquo');

	    $strTypografed = $remoteTypograf->processText($str);
	    return $strTypografed;
	}

	/*$ini = parse_ini_file('app.i', true);

	$link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
	mysqli_set_charset($link, 'utf8');

	$result = mysqli_query($link, "SELECT * FROM catalogue");
	while ($row = mysqli_fetch_assoc($result)) {
	    $id = $row['id'];
	    $title = $row['title'];
	    $titleTypografed = typograf($title);

	    mysqli_query($link, "UPDATE catalogue SET title = '$titleTypografed' WHERE id = '$id'");
	}


	exit;*/
?>
<!DOCTYPE html>
<html lang="it" class="html">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Piccola biblioteca della Pigna</title>
	    <link rel="shortcut icon" href="/img/favicon.ico">
	    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon-180x180.png">
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

                /*if (password_verify($ini[admin][password], $_COOKIE['admin_rights'])) {
                    // Книга месяца
                    $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 1");
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row[author] != '')
                            $row[author] = '<div class="grid__item__authortitle__author">'.$row[author].'</div>';

                        if ($row[price] != 0)
                            $row[price] = '<div class="grid__item__sticker grid__item__sticker_price">'.$row[price].'&thinsp;€</div>';
                        else
                            $row[price] = '';

                        $bookOnHands = '';
                        if ($row[onHands] == 1)
                            $bookOnHands = 'checked';

                        echo <<<HERE
							<div class="grid__item grid__item_month-book-color" data-id="$row[id]">
				                <div class="grid__item__authortitle">
				                    $row[author]
				                    <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
				                </div>
				                <div class="grid__item__publishing">$row[publishing]</div>
				                $row[price]
				                <div class="grid__item__admin">
								      <div class="form__element">
								          <label class="form__element__label">
									          <input type="checkbox" name="on_hands" value="on_hands" $bookOnHands autocomplete="off" class="form__element__label__checkbox form__element__label__checkbox_on-hands">
									          <span class="form__element__label__fake-checkbox"></span> In prestito
								          </label>
							          </div>
							          <div class="grid__item__admin__editLinkWrap"><a class="pseudolink grid__item__admin__editLinkWrap__link">Redigere</a></div>
								</div>
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

                        $bookOnHands = '';
                        if ($row[onHands] == 1)
                            $bookOnHands = 'checked';

                        $description = '';
                        if ($row[description] != '')
                            $description = 'data-description="'.$row[description].'"';

                        echo <<<HERE
						<div class="grid__item" data-id="$row[id]" $description>
			                <div class="grid__item__authortitle">
			                    $row[author]
			                    <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
			                </div>
			                <div class="grid__item__publishing">$row[publishing]</div>
			                $row[price]
			                <div class="grid__item__admin">
								      <div class="form__element">
								          <label class="form__element__label">
									          <input type="checkbox" name="on_hands" value="on_hands" $bookOnHands autocomplete="off" class="form__element__label__checkbox form__element__label__checkbox_on-hands">
									          <span class="form__element__label__fake-checkbox"></span> In prestito
								          </label>
							          </div>
							          <div class="grid__item__admin__editLinkWrap"><a class="pseudolink grid__item__admin__editLinkWrap__link">Redigere</a></div>
							 </div>
			            </div>
HERE;
                    }
                }
                else {*/
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
            ?>
        </div>
        <div class="footer">
	        <div class="grid">
		        <div class="grid__map">
			        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10235.383716062684!2d7.769742885970775!3d43.81744871255861!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12cdf55b2cddb363%3A0x258c2b5076a50cbd!2zUGlhenphIENhcGl0b2xvLCAxLCAxODAzOCBTYW5yZW1vIElNLCDQmNGC0LDQu9C40Y8!5e0!3m2!1sru!2sru!4v1551525505146" width="100%" height="170" frameborder="0" style="border:0" allowfullscreen></iframe>
		        </div>
		        <div class="grid__description">
			        <div class="likely likely-big">
				        <div class="twitter">Twittare</div>
				        <div class="facebook">Condividere</div>
				        <div class="whatsapp"></div>
				        <div class="telegram">Inviare</div>
				        <div class="pinterest">Pinteressarsi</div>
			        </div>
			        <p>Piazza del Capitolo, 1, Sanremo&nbsp;· <nobr><a href="tel:+390184501132" class="link">+39 0184 501-132</a></nobr>&nbsp;· <a href="mailto:piccolabibliopigna@gmail.com" class="link">piccolabibliopigna@gmail.com</a></p>
			        <p>Siamo aperti martedì dalle 15 alle 18 e sabato dalle 9 alle 12.</p>

			        <p>
				        Autore dell’idea e progettista <nobr><a href="http://robertblinov.net/" class="link">Robert Blinov</a>,</nobr>
				        <br>direttore d’arte e tecnologo <nobr><a href="http://sidorchik.ru/" class="link">Ilià Sidorcic</a></nobr>
			        </p>
		        </div>
	        </div>
        </div>
        <script src="js/likely.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>
        <script src="js/script.js"></script>
    </body>
</html>