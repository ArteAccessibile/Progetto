<?php
require_once "DBAccess.php";

use DB\DBAccess;

$userId = $_GET['id'];

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
  $artist = $connection->getArtistByUser($userId);
 
 if (!empty($artist)) {
   
   $images = $connection->getImagesByArtist($userId);
   
   $page = file_get_contents("../html/template_artista.html");
   $page = str_replace("{artista_image}", "../../immagini/artisti/{$artist['pseudonimo']}.jpg", $page);
   $page = str_replace("{name}", $artist['pseudonimo'], $page);
   $page = str_replace("{mail}", $artist['email_contatto'], $page);
   $page = str_replace("{descriptionArtist}", $artist['descrizione'], $page);
   
   $imagesHtml = "";
   if (!empty($images)) {
       foreach ($images as $image) {
           $imagesHtml .= "<img src=\"{$image}\" alt=\"\">";
       }
   } else {
       $imagesHtml = "Nessuna immagine trovata";
   }
   
   
   $page = str_replace("{listaOpere}", $imagesHtml, $page);
   require_once "../config.php";
   $_SESSION["nav_page"] = "artists";
   require_once "../php/modules-loader.php";
   echo $page;
 } else {
   echo "Artist not found.";
 }
 
 $connection->closeConnection();
} else {
 echo "Errore di connessione al <span lang=\"en\">database</span>.";
}

?>
