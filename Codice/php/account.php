<?php
    require_once "../config.php";

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION["go_back_page"] = $index_page;


    $page = file_get_contents($html_path . "account.html");

    
    if (isset($_SESSION["role"]) && $_SESSION["role"] != "guest" && isset($_SESSION["email"])) {
        $page = str_replace("<loggedhas/>", "<h2 class=\"logged_has\"> Hai eseguito l'accesso come: <strong>".$_SESSION["email"]."</strong> </h2>" , $page);
        $page = str_replace("<account-options>", "<div class=\"account_options_visible\" >" , $page);

        if($_SESSION["role"] == "artista"){
            $page = str_replace("<become-artist-visibility/>", "<li class=\"account_options_invisible\">" , $page);
            $page = str_replace("<artist-visibility/>", "<li class=\"account_options_visible\">" , $page);
        } else {
            $page = str_replace("<artist-visibility/>", "<li class=\"account_options_invisible\">" , $page);
            $page = str_replace("<become-artist-visibility/>", "<li class=\"account_options_visible\">" , $page);
        }
        if(isset($_SESSION["now-artist"]) && $_SESSION["now-artist"] == "yes"){
            $_SESSION["now-artist"] = "no";
            $message = "Sei diventato un artista! Ora puoi caricare le tue opere e gestire il tuo profilo.";
            $page = str_replace("<now-artist-message/>", "<p class=\"ok-message\">".$message."</p>" , $page);
            $page = str_replace("<artist-visibility/>", "<li class=\"account_options_visible\">" , $page);
        }
    } else {
        $page = str_replace("<loggedhas/>", "<h2 class=\"logged_has\" > Devi eseguire l'accesso per potere accedere ai contenuti di questa sezione: <a href=\"login.php\" lang=\"en\"> Login </a></h2>" , $page);
        $page = str_replace("<account-options>", "<div class=\"account_options_invisible\">" , $page);
    }


    require_once "modules-loader.php";
    echo $page;
?>