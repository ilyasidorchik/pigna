<?php
    require 'functions.php';

    $str = $_POST['str'];
    $strTypografed = typograf($str);
    echo $strTypografed;