<?php
	$ini = parse_ini_file('../../app.ini', true);

	$hash = password_hash($ini[admin][password], PASSWORD_DEFAULT);

	$password = $_POST['password'];

	if ($password == $ini[admin][password] && !isset($_COOKIE["admin"]))
	    SetCookie('admin', $hash, time()+60*60*24*365*10, '/');
?>
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
			    $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
			    mysqli_set_charset($link, 'utf8');

			    $result = mysqli_query($link, "SELECT * FROM testPeople");
			    while ($row = mysqli_fetch_assoc($result)) {
					echo '<li>' . $row[fullName] . '</li>';
			    }
		    ?>
		</ol>
		<hr><br>

		<?php
			if (password_verify($ini[admin][password], $_COOKIE['admin'])) {
				echo <<<HERE
					<form method="POST" action="" class="form_add-person">
						<input type="text" name="fullName" placeholder="ФИО человека" autofocus required class="input_full-name">
						<input type="submit" name="submit" value="Добавить" class="btn_add-person">
					</form>
HERE;
			}
			else {
				echo <<<HERE
					<form method="POST" action="">
                        <input type="password" name="password" placeholder="Пароль">
                        <button name="enter">Войти в админку</button>
                    </form>
HERE;
			}
		?>



		<script src="../script.js"></script>
	</body>
</html>