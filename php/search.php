<?php
    //sleep(3);
    $bookTitle = $_POST['bookTitle'];

    $ini = parse_ini_file('../app.ini', true);

    $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
    mysqli_set_charset($link, 'utf8');

    $result = mysqli_query($link, "SELECT * FROM catalogue");

    while ($row = mysqli_fetch_assoc($result)) {
        if ($bookTitle == '' || stripos($row[title], $bookTitle) !== false) {
            echo <<<HERE
                <div class="grid__item">
                    <div class="grid__item__authortitle">
                        <div class="grid__item__authortitle__author">$row[author]</div>
                        <div class="grid__item__authortitle__title" title="$row[title]">$row[title]</div>
                    </div>
                    <div class="grid__item__publishing">$row[publishing]</div>
                </div>
HERE;
            }
    }