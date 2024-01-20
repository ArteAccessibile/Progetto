<?php
    include ".." . DIRECTORY_SEPARATOR . "config.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_destroy();
    
    header("Location: " . $index_page);
    exit();
?>