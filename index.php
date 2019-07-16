<?php
	require 'php/functions.php';

	$ini = parse_ini_file('app.ini', true);

	if (password_verify($ini[admin][password], $_COOKIE['admin_rights'])) {
	    $admin = 'admin';

	    // Книги на руках в начале, чтобы было удобно найти книгу и отметить, что её вернули
	    $onHandsStart = 1;
	    $onHandsEnd = 0;
	}
	else {
	    $admin = '';

        // Книги на руках в конце
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
	    <meta name="description" content="Storia locale, scienze documentarie, letteratura e arte">
	    <link rel="shortcut icon" href="/img/favicon.ico">
	    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon-180x180.png">
        <link rel="stylesheet/less" type="text/css" href="/css/style.less">
	    <link rel="stylesheet" href="/css/likely.css">
    </head>
    <body class="page<?php echo $admin ? ' '.$admin : $admin; ?>">
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
                <form action="" method="POST">
                    <input type="text" name="title" placeholder="Cercare libri nella piccola biblioteca della Pigna" autofocus class="input input-h1" id="searchInput" autocomplete="off">
                </form>
            </div>
        </div>
        <div class="description">Storia locale, scienze documentarie, letteratura&nbsp;e arte</div>
        <div class="grid">
            <?php
                $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
                mysqli_set_charset($link, 'utf8');

                printBookAddingLink($admin, '');
                printEvents($link, $admin);
                printAllBooks($link, $onHandsStart, $onHandsEnd, $admin);
            ?>
        </div>
        <div class="footer footer_mobile footer_mobile_bordered">
	        <div class="grid footer__main">
		        <div class="grid__description">
			        <div class="likely likely_mobile likely-big">
				        <div class="twitter"></div>
				        <div class="facebook"></div>
				        <div class="whatsapp"></div>
				        <div class="telegram"></div>
				        <div class="pinterest"></div>
			        </div>
			        <p><a href="https://www.google.com/maps?ll=43.819368,7.774345&z=13&t=m&hl=en-US&gl=RU&mapclient=embed&q=Piazza+Capitolo,+1+18038+Sanremo+IM+Italy" class="link">Piazza del&nbsp;Capitolo,&nbsp;1</a>, Sanremo&nbsp;· <nobr><a href="tel:+390184501132" class="link">+39 0184 501-132</a></nobr> <a href="mailto:piccolabibliopigna@gmail.com" class="link">piccolabibliopigna@gmail.com</a></p>
			        <p>Siamo aperti mercoledì dalle 21 alle&nbsp;22:30 e sabato dalle&nbsp;9 alle 12.</p>
		        </div>
	        </div>
        </div>
        <div class="footer footer_desktop footer_bottom-sticked-fixed">
	        <div class="footer__hint">Visitare</div>
	        <div class="grid footer__main">
		        <div class="grid__map grid__map_desktop">
<!--			        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10235.383716062684!2d7.769742885970775!3d43.81744871255861!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12cdf55b2cddb363%3A0x258c2b5076a50cbd!2zUGlhenphIENhcGl0b2xvLCAxLCAxODAzOCBTYW5yZW1vIElNLCDQmNGC0LDQu9C40Y8!5e0!3m2!1sru!2sru!4v1551525505146" width="100%" height="170" frameborder="0" style="border:0" allowfullscreen></iframe>-->
		        </div>
		        <div class="grid__description">
			        <div class="likely likely_desktop likely-big">
				        <div class="twitter">Twittare</div>
				        <div class="facebook">Condividere</div>
				        <div class="whatsapp"></div>
				        <div class="telegram">Inviare</div>
				        <div class="pinterest">Pinteressarsi</div>
			        </div>
			        <p class="grid__description__text">Piazza del&nbsp;Capitolo,&nbsp;1, Sanremo&nbsp;· <nobr><a href="tel:+390184501132" class="link">+39 0184 501-132</a></nobr><span class="footer__main__middle-dot">&nbsp;·</span> <a href="mailto:piccolabibliopigna@gmail.com" class="link">piccolabibliopigna@gmail.com</a></p>
			        <p class="grid__description__text">Siamo aperti mercoledì dalle 21 alle 22:30 e sabato dalle 9 alle 12.</p>
			        <p>
				        Autore dell’idea e progettista <nobr><a href="http://robertblinov.net/" class="link">Robert Blinov</a>,</nobr>
				        <br>direttore d’arte e tecnologo <nobr><a href="http://sidorchik.ru/" class="link">Ilià Sidorcic</a></nobr>
			        </p>
		        </div>
	        </div>
        </div>
        <script src="/js/likely.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkUOdZ5y7hMm0yrcCQoCvLwzdM6M8s5qk&callback=initMap"></script>
        <script src="/js/script.js"></script>
    </body>
</html>