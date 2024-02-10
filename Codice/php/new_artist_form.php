<?php
    require_once "../config.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $page = file_get_contents($html_path . "diventa_artista.html");

    if (isset($_SESSION["role"])) {
        if ($_SESSION["role"] == "artista") {
            header("Location: ../php/account.php");
            exit;
        }
    }

    if(!isset($_SESSION["email"])) {
        $page = str_replace("<error/>", "<p> Sessione scaduta, torna al login per accedere: <a href=\"login.php\"> Vai al login </a> </p>", $page); 
        $page = str_replace("<visibility/>", "<div class=\"nascosto\">", $page);
    }else{
        $page = str_replace("<error/>", "", $page); 
        $page = str_replace("<visibility/>", "<div>", $page);
    }

    echo $page;
?>


