<?php
    include ".." . DIRECTORY_SEPARATOR . "config.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
    session_destroy();
    exit();
?>