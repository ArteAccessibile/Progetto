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
        $page = str_replace("{email}", $_SESSION["email"], $page);
        $page = str_replace("<set-visibility/>", "<div class=\"visibile\" tabindex='0'>" , $page);
    } else {
        $page = str_replace("{email}","anonimo, non hai effettuato il login.", $page);
        $page = str_replace("<loggedhas/>", "<h2 class=\"logged_has\" tabindex='0'> Devi loggarti per potere accedere ai contenuti di questa sezione </h2>" , $page);
        $page = str_replace("<set-visibility/>", "<div class=\"nascosto\" tabindex='0'>" , $page);
    }


    $mysqli->close(); //mysqli da db-connection.php
    echo $page;
?>