<?php

if(isset($page)){
    $header = file_get_contents($modules_path . "header.html");
    $footer = file_get_contents($modules_path . "footer.html");
    $nav = file_get_contents($modules_path . "mininavbar.html");
    $header = str_replace("{root}",$root, $header);

    if(isset($_SESSION["nav_page"])){
        switch($_SESSION["nav_page"]){
            case "home":
                $header = str_replace("<li id=\"home\"><a href=\"/gitprog/codice/index.php\">", "<li lang=\"en\" id=\"selected\">", $header);
                $nav = str_replace("<li id=\"minihomeli\">", "<li id=\"selectedMini\" lang=\"en\">", $nav);
                break;
            case "gallery":
                $header = str_replace("<li id=\"gallery\"><a href=\"/gitprog/codice/php/galleria.php\">", "<li lang=\"en\" id=\"selected\">", $header);
                $nav = str_replace("<li id=\"minigalleryli\">", "<li id=\"selectedMini\" lang=\"en\">", $nav);
                break;
            case "artists":
                $header = str_replace("<li id=\"artists\"><a href=\"/gitprog/codice/php/artisti.php\">", "<li lang=\"en\" id=\"selected\">", $header);
                $nav = str_replace("<li id=\"miniartistsli\">", "<li id=\"selectedMini\" lang=\"en\">", $nav);
                break;
            case "contacts":
                $header = str_replace("<li id=\"contacts\"><a href=\"/gitprog/codice/php/contatti.php\">", "<li lang=\"en\" id=\"selected\">", $header);
                $nav = str_replace("<li id=\"minicontactsli\">", "<li id=\"selectedMini\" lang=\"en\">", $nav);
                break;     
        }
    } 
    else{
        $nav = str_replace("<li id=\"home\">", "<li lang=\"en\" id=\"selected\">", $nav);
    }

    include $php_path . "check-connection.php";

    $header = str_replace("<log/>", $log_status, $header);
    
    if (isset($_SESSION["role"]) && $_SESSION["role"] != "guest" && isset($_SESSION["name"])) {
        $header = str_replace("<welcome/>", "<p class=\"welcome\"> Benvenuto, " .$_SESSION["name"]."</p>" , $header);
    } else {
        $header = str_replace("<welcome/>", "", $header);
    }

    $page = str_replace("<header/>", $header, $page);
    $page = str_replace("<footer/>", $footer, $page);
    $page = str_replace("<mininavbar/>", $nav, $page);
}
?>