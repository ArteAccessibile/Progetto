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

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {

    $pseudonimo = $connection->getArtistaPseudonimoByUser($_SESSION["email"]);
    $descrizione = $connection->getArtistaDescByUser($_SESSION["email"]);

    $lista = $connection->getImagesByArtist($_SESSION["email"]);

    // Generate the HTML for the images
    $imagesHtml = "";
    if (!empty($lista)) {
        foreach ($lista as $image) {
            $imagesHtml .= "<img src=\"{$image}\" alt=\"\">";
        }
    } else {
        $imagesHtml = "No images found.";
    }
}

$connection->closeConnection();

$page = str_replace("{pseudonimo}", $pseudonimo, $page);
$page = str_replace("{emailUser}", $_SESSION["email"], $page);
$page = str_replace("{descrizione}", $descrizione, $page);
$page = str_replace("{listaOpere}", $imagesHtml, $page);

echo $page;
?>
