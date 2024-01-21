<?php
    include "../config.php";
    include $php_path . "db-connection.php";
    include $php_path . "check-connection.php";

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION["go_back_page"] = $account_page; //index page definito in config.php


    $page = file_get_contents($html_path . "account.html");

    
    if (isset($_SESSION["role"]) && $_SESSION["role"] != "guest" && isset($_SESSION["email"])) {
        $page = str_replace("<loggedhas/>", "<h2 class=\"logged_has\"> Sei loggato come: <strong>".$_SESSION["email"]."</strong> </h2>" , $page);
    } else {
        //vedremo
    }


    $mysqli->close(); //mysqli da db-connection.php
    echo $page;
?>