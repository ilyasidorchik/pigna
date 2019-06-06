<?php
    $id = $_POST['id'];

    $to       = 'Robert@carbonPear.tv';
    $title    = 'Библиотека Пиньи. Отредактируйте новую книгу';
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= "Content-type: text/html; charset=utf-8 \r\n";
    $headers .= "From: Библиотека Пиньи <'info@pigna.pro'>\r\n";

    $mess = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
                    <html>
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                            <title>Библиотека Пиньи. Отредактируйте новую книгу</title>
                        </head>
                        <body>                                
                            <p><a href="http://pigna.pro/alterare/?libro='.$id.'">pigna.pro/alterare/?libro='.$id.'</a></p>
                                
                            <p>В каталог библиотеки Пиньи добавлена книга с длинным автором. Возможно, из-за этого обложка выглядит некрасиво. Проверьте и отредактируйте, пожалуйста.</p>
                            <br>
                            <p>Библиотека Пиньи, pigna.pro</p>
                        </body>
                    </html>';

    mail($to, $title, $mess, $headers);