<?php
    include "../config.php";
    include $php_path . "db-connection.php";
    include $php_path . "check-connection.php";

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION["go_back_page"] = $index_page;
    $liItems="";

    $page = file_get_contents($html_path . "account.html");

    
    if (isset($_SESSION["role"]) && $_SESSION["role"] != "guest" && isset($_SESSION["email"])) {
      
        $page = str_replace("<loggedhas/>", "<h2 class=\"logged_has\" tabindex='0'> Sei loggato come: <strong>".$_SESSION["email"]."</strong> </h2>" , $page);
        $page = str_replace("<account-options>", "<ul class=\"account_options_visible\" tabindex='0'>" , $page);

        if($_SESSION["role"] == "artista"){
            $page = str_replace("<become-artist-visibility/>", "<li class=\"account_options_invisible\" tabindex='0'>" , $page);
            $page = str_replace("<artist-visibility/>", "<li class=\"account_options_visible\" tabindex='0'>" , $page);
            $liItems = "<li id=\"logout\"><a href=\"../php/logout.php\">Logout</a></li>
                    <li id=\"test\"><a href=\"../php/accountArtista.php\"> Gestione opere d'arte</a></li>";
            $page = str_replace("{liPerArtista}", $liItems , $page);
        } else {
            $page = str_replace("<artist-visibility/>", "<li class=\"account_options_invisible\" tabindex='0'>" , $page);
            $page = str_replace("<become-artist-visibility/>", "<li class=\"account_options_visible\" tabindex='0'>" , $page);
        }
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