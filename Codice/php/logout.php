<?php
    include ".." . DIRECTORY_SEPARATOR . "config.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    header("Location: " . $_SESSION["go_back_page"]);
    session_destroy();    
    exit();
?>