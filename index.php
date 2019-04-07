<?php
	include 'php/functions.php';

	$ini = parse_ini_file('app.ini', true);

	if (password_verify($ini[admin][password], $_COOKIE['admin_rights'])) {
	    $admin = 'admin';
	    $onHandsStart = 1;
	    $onHandsEnd = 0;
	}
	else {
	    $admin = '';
	    $onHandsStart = 0;
	    $onHandsEnd = 1;
	}
?>
<!DOCTYPE html>
<html lang="it" class="html">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Piccola biblioteca della Pigna</title>
	    <meta name="description" content="Storia locale, scienze, letteratura e arte">
	    <link rel="shortcut icon" href="img/favicon.ico">
	    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon-180x180.png">
        <link rel="stylesheet/less" type="text/css" href="css/style.less">
	    <link rel="stylesheet" href="css/likely.css">
    </head>
    <body class="page <?php echo $admin; ?>">
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
                if ($admin == 'admin')
                	echo '<div class="grid__item grid__item_link-to-book-adding"><a href="+/" class="grid__item_link-to-book-adding__link"></a>+</div>';

                $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
                mysqli_set_charset($link, 'utf8');

                // Книга месяца
                $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 1");
                while ($row = mysqli_fetch_assoc($result))
	                printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);

                // Все остальные книги, которые не на руках
                $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = '$onHandsStart'");
                while ($row = mysqli_fetch_assoc($result))
	                printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);

                // Книги, которые на руках
                $result = mysqli_query($link, "SELECT * FROM catalogue WHERE monthBook = 0 AND onHands = '$onHandsEnd'");
                while ($row = mysqli_fetch_assoc($result))
	                printBookTemplate($row[id], $row[author], $row[title], $row[publishing], $row[price], $row[monthBook], $row[description], $row[onHands], $admin);
            ?>
        </div>
        <div class="footer footer_bottom-sticked-fixed">
	        <div class="footer__hint">Visitare</div>
	        <div class="grid footer__main">
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
			        <p>Piazza del&nbsp;Capitolo,&nbsp;1, Sanremo&nbsp;· <nobr><a href="tel:+390184501132" class="link">+39 0184 501-132</a></nobr><span class="footer__main__middle-dot">&nbsp;·</span> <a href="mailto:piccolabibliopigna@gmail.com" class="link">piccolabibliopigna@gmail.com</a></p>
			        <p>Siamo aperti martedì dalle&nbsp;15 alle 18 e&nbsp;sabato&nbsp;dalle&nbsp;9 alle 12.</p>

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