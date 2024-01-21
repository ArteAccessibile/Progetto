<?php
    include "config.php";
    include $php_path . "db-connection.php";
    include $php_path . "check-connection.php";

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION["go_back_page"] = "$index_page"; //index page definito in config.php


    $page = file_get_contents($html_path . "home.html");

    if (isset($_SESSION["role"]) && $_SESSION["role"] != "guest" && isset($_SESSION["name"])) {
        $page = str_replace("<welcome/>", "<p> Ciao, " .$_SESSION["name"]."</p>" , $page);
    } else {
        $page = str_replace("<welcome/>", "", $page);
    }

    $page = str_replace("<log/>", $log_status, $page);


    $mysqli->close(); //mysqli da db-connection.php
    echo $page;
?>