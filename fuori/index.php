<?php
    setcookie('admin_rights', '', time() - 3600, '/');
    header("Location: http://accademiapigna.sidorchik.ru");
