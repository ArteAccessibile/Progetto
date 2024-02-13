<?php

if(isset($page)){
    $header = file_get_contents($modules_path . "header.html");
    $footer = file_get_contents($modules_path . "footer.html");
    $nav = file_get_contents($modules_path . "mininavbar.html");

    if(isset($_SESSION["nav_page"])){
        switch($_SESSION["nav_page"]){
            case "home":
                $header = str_replace("<li id=\"home\"><a href=\"/gitprog/codice/index.php\"><span lang=\"en\">Home</span></a></li>", "<li id=\"selected\"><span lang=\"en\">Home</span></li>", $header);
                $nav = str_replace("<li id=\"minihomeli\"><a href=\"/gitprog/codice/index.php\"><span lang=\"en\">Home</span></a></li>", "<li id=\"selectedMini\"><span lang=\"en\">Home</span></li>", $nav);
                break;
            case "gallery":
                $header = str_replace("<li id=\"gallery\"><a href=\"/gitprog/codice/php/galleria.php\">Galleria</a></li>", "<li id=\"selected\">Galleria</li>", $header);
                $nav = str_replace("<li id=\"minigalleryli\"><a href=\"/gitprog/codice/php/galleria.php\">Galleria</a></li>", "<li id=\"selectedMini\">Galleria</li>", $nav);
                break;
            case "artists":
                $header = str_replace("<li id=\"artists\"><a href=\"/gitprog/codice/php/artisti.php\">Artisti</a></li>", "<li id=\"selected\">Artisti</li>", $header);
                $nav = str_replace("<li id=\"miniartistsli\"><a href=\"/gitprog/codice/php/artisti.php\">Artisti</a></li>","<li id=\"selectedMini\">Artisti</li>", $nav);
                break;
            case "contacts":
                $header = str_replace("<li id=\"contacts\"><a href=\"/gitprog/codice/php/contatti.php\">Contatti</a></li>", "<li id=\"selected\">Contatti</li>", $header);
                $nav = str_replace("<li id=\"minicontactsli\"><a href=\"/gitprog/codice/php/contatti.php\">Contatti</a></li>", "<li id=\"selectedMini\">Contatti</li>", $nav);
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