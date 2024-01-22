<?php
include $root . "config.php";

if(isset($page)){
    $header = file_get_contents($modules_path . "header.html");
    $footer = file_get_contents($modules_path . "footer.html");
    $nav = file_get_contents($modules_path . "mininavbar.html");
    if(isset($_SESSION["nav_page"])){
        switch($_SESSION["nav_page"]){
            case "home":
                $header = str_replace("<li id=\"home\">", "<li lang=\"en\" id=\"selected\">", $header);
                $nav = str_replace("<li id=\"minihomeli\">", "<li id=\"selectedMini\" lang=\"en\">", $nav);
                break;
            case "gallery":
                $header = str_replace("<li id=\"gallery\">", "<li lang=\"en\" id=\"selected\">", $header);
                $nav = str_replace("<li id=\"minigalleryli\">", "<li id=\"selectedMini\" lang=\"en\">", $nav);
                break;
            case "artists":
                $header = str_replace("<li id=\"artists\">", "<li lang=\"en\" id=\"selected\">", $header);
                $nav = str_replace("<li id=\"miniartistsli\">", "<li id=\"selectedMini\" lang=\"en\">", $nav);
                break;
            case "contacts":
                $header = str_replace("<li id=\"contacts\">", "<li lang=\"en\" id=\"selected\">", $header);
                $nav = str_replace("<li id=\"minicontactsli\">", "<li id=\"selectedMini\" lang=\"en\">", $nav);
                break;     
        }
    } 
    else{
        $nav = str_replace("<li id=\"home\">", "<li lang=\"en\" id=\"selected\">", $nav);
    }


    $page = str_replace("<header/>", $header, $page);
    $page = str_replace("<footer/>", $footer, $page);
    $page = str_replace("<mininavbar/>", $nav, $page);
}
?>