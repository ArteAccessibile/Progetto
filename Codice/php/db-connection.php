<?php
    $db_host = 'localhost';
    $db_user = 'testUtente';      
    $db_password = 'password'; //da cambiare in base a quelle che avete messo su phpmyadmin
    $db_db = 'fgiacomutest'; //da cambiare in base a come avete chiamato il db

    $mysqli = @new mysqli($db_host, $db_user, $db_password, $db_db); //conntette al db
        
    if ($mysqli->connect_error) {
        exit(); 
    }
?>