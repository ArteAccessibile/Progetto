<?php
     require_once "../config.php";

     if (session_status() === PHP_SESSION_NONE) {
         session_start();
     }
 
     $page = file_get_contents($html_path . "registrati.html");
 
     if (isset($_SESSION["email"])) {
        session_destroy();
        header("Location: ../index.php");
        exit;
     }
    
    $page = str_replace("<error/>", "", $page); 
    $page = str_replace("<visibility/>", "<div>", $page);
 
    require_once "modules-loader.php";
    echo $page;
?>
 