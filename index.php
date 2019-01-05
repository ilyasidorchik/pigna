<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cercare libri nella piccola biblioteca della Pigna</title>
        <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet/less" type="text/css" href="css/style.less">
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
                    <input type="text" name="title" placeholder="Cercare libri nella piccola biblioteca della Pigna" autofocus class="" id="searchInput" autocomplete="off">
                </form>
            </div>
        </div>
        <div class="grid" id="results">
            <?php
	            $ini = parse_ini_file('app.ini', true);

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
        <script src="js/script.js"></script>
    </body>
</html>