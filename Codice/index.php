<?php
    require_once "config.php";
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION["go_back_page"] = $index_page; //index page definito in config.php
    $page = file_get_contents($html_path . "home.html");

    $_SESSION["nav_page"] = "home"; //importante definirlo in ogni pagina tra home | contatti ...

    include $php_path . "modules-loader.php";

    echo $page;
?>