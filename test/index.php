<!DOCTYPE html>
	<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<title>База людей</title>
	</head>
	<body>
		<h3>База людей</h3>
		<ol class="people-list">
		    <?php
			    $ini = parse_ini_file('../app.ini', true);
			    $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
			    mysqli_set_charset($link, 'utf8');

			    $result = mysqli_query($link, "SELECT * FROM testPeople");
			    while ($row = mysqli_fetch_assoc($result)) {
					echo '<li>' . $row[fullName] . '</li>';
			    }
		    ?>
		</ol>

		<script src="script.js"></script>
	</body>
</html>