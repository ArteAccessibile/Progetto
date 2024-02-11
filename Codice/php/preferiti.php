<?php
    include "../config.php";
    include $php_path . "DBAccess.php";
    use DB\DBAccess;

    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    setlocale(LC_ALL, 'it_IT');

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    //$_SESSION["go_back_page"] = $favourite_page; //index page definito in config.php
    $_SESSION["go_back_page"] =  $_SERVER['REQUEST_URI']; //è un test


    $page = file_get_contents($html_path . "preferiti.html");

    
    if (isset($_SESSION["role"]) && $_SESSION["role"] != "guest" && isset($_SESSION["email"])) {
        $page = str_replace("<loggedhas/>", "<h2 class=\"logged_has\" tabindex='0'> Sei loggato come: <strong>".$_SESSION["email"]."</strong> </h2>" , $page);
        $page = str_replace("<set-visibility/>", "<div class=\"visibile\" tabindex='0'>" , $page);
    } else {
        $page = str_replace("<loggedhas/>", "<h2 class=\"logged_has\" tabindex='0'> Devi loggarti per potere accedere ai contenuti di questa sezione </h2>" , $page);
        $page = str_replace("<set-visibility/>", "<div class=\"nascosto\" tabindex='0'>" , $page);
    }

    $connection = new DBAccess();
    $connectionOk = $connection->openDBConnection();

    if ($connectionOk) {
        $favs = $connection->getFavourites();
        $replace = "";
        if ($favs != null) {
            foreach ($favs as $f) {
                $opera = $connection->getOperaById($f['opera']);
                if(empty($opera)) {
                    echo "Failed to fetch favourites data.";
                    exit();
                }
                $file_path = isset($opera['file_path']) ? $opera['file_path'] : '';
                if (!file_exists($file_path)) {
                    echo "Error images not founded!.";
                    echo $file_path;
                }
            // Creating the list with opera names and respective image file paths
                $replace .= "
                            <div class=\"preferito-container\">
                                <a class=\"go-to-opera\" href=\"template_opera.php?id=".$f['opera']."\">
                                    <ul class=\"preferito\">
                                    <li><img src=\"".$file_path."\" alt=\"".$f['artista']."\" ></li>
                                    <li>
                                        <ul class=\"descrizione-preferito\">
                                            <li>
                                                <h3>".$f['titolo']."</h2>
                                                <p>".$f['desc_abbrev']."</p>
                                            </li>
                                            <li>
                                                <h3> Autore </h2>
                                                <p>".$f['artista']."</p>
                                            </li>
                                        </ul>
                                    </li>

                                    </ul>
                                </a>
                                <form method=\"POST\" action=\"remove-favorite.php?id=".$f['opera']."\">
                                <fieldset class=\"noBordo\"> 
                                  <input id=\"remove-favourite-".$f['opera'].$_SESSION['email']."\" class=\"remove-favourite-button\" type=\"submit\" value=\"Rimuovi preferito\">
                                </fieldset>
                                </form>
                            </div>
                            ";
                        
            }
        } else {$replace .= "<p>Non sono presenti preferiti</p>";}
    } else {
        $stringaOpere = "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
    }
    $connection->closeConnection(); 
    $page = str_replace("<favourites/>", $replace, $page);
    require_once "modules-loader.php";
    echo $page;
?> 
