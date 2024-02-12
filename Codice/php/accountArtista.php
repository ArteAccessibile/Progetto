<?php
require_once "DBAccess.php";
use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = file_get_contents("../html/account_artista.html");

if(!isset($_SESSION["email"])) {
    require_once "../config.php";
    $page = str_replace("<error/>", "<div class=\"errors-forms\"><p> Sessione scaduta, torna al login per accedere e visualizzare il contenuto richiesto: <a href=\"login.php\"> Vai al <span lang = \"en\">login</span> </a> </p></div>", $page); 
    $page = str_replace("<visibility/>", "<div class=\"nascosto\">", $page);
    require_once "modules-loader.php";
    echo $page;
    exit;
}

if($_SESSION["role"] != "artista" || $_SESSION["role"] != "admin") {
    require_once "../config.php";
    $page = str_replace("<error/>", "<div class=\"errors-forms\"><p> Devi essere un aritista per accedere a questo contenuto, clicca <a href=\"new_artist_form.php\">qui</a> per diventare un artista.</p></div>", $page); 
    $page = str_replace("<visibility/>", "<div class=\"nascosto\">", $page);
    require_once "modules-loader.php";
    echo $page;
    exit;
}

//TODO ADD CHECK SONO ARTISTA? ANCHE IN PAGINA OPERA UPLOAD MA IN OPERA UPLOAD SOLO SONO ADMIN ?

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

$page = str_replace("<loggedhas/>", "<h2 class=\"logged_has\"> Hai già eseguito l'accesso come: <strong>".$_SESSION["email"]."</strong> </h2>" , $page);
//quello sopra solo se è settato il ruolo e l'email

if ($connectionOk) {

    $pseudonimo = $connection->getArtistaPseudonimoByUser($_SESSION["email"]);
    $descrizione = $connection->getArtistaDescByUser($_SESSION["email"]);

    $lista = $connection->getImagesByArtist($_SESSION["email"]);

    //crea alert per bottone elimina
    $fotoProfiloJPG = "../../immagini/artisti/" . $pseudonimo . ".jpg";
    
    // se la versione JPG manca, cerco la versione PNG della foto profilo
    if (!file_exists($fotoProfiloJPG)) {
        $fotoProfiloPNG = "../../immagini/artisti/" . $pseudonimo . ".png";
        // Check PNG 
        if (file_exists($fotoProfiloPNG)) {
            $fotoProfilo = $fotoProfiloPNG;
        } else {
            // Metto una profile picture di default
            $fotoProfilo = "../../immagini/account_logo.png";
        }
    } else {
        $fotoProfilo = $fotoProfiloJPG;
    }
        $imagesHtml = "";
    if (!empty($lista)) {
        foreach ($lista as $image) {
            $imagesHtml .= "<div class='opera_artista_card'>";
            $imagesHtml .= "<img src='{$image}' alt=''>";
            $imagesHtml .= "<form method='POST' action='deleteImage.php'>"; 
            $imagesHtml .= "<input type='hidden' name='image_path' value='{$image}'>";
            $imagesHtml .= "<button type='submit' name='delete_image'>Elimina</button>";
            $imagesHtml .= "</form>";
            $imagesHtml .= "</div>";
        }
    } else {
        $imagesHtml = "<p> Non sono state caricate delle opere.</p>";
    }
    
}

$connection->closeConnection();
$page = str_replace("<visibility/>", "<div class=\"visibile\">", $page);
$page = str_replace("<error/>", "", $page);
$page= str_replace("{FotoProfilo}", $fotoProfilo, $page);
$page = str_replace("{pseudonimo}", $pseudonimo, $page);
$page = str_replace("{emailUser}", $_SESSION["email"], $page);
$page = str_replace("{descrizione}", $descrizione, $page);
$page = str_replace("{listaOpere}", $imagesHtml, $page);
$page = str_replace("<visibility/>", "<div class=\"visibile\">", $page);
$page = str_replace("<error/>", "", $page);

require_once "../config.php";
require_once "modules-loader.php";
echo $page;
?>
