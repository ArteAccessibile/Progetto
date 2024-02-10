<?php
require_once "DBAccess.php";

use DB\DBAccess;

$userId = $_GET['id'];

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
  $artist = $connection->getArtistByUser($userId);
 
 if (!empty($artist)) {
   // Get the images of the artist
   $images = $connection->getImagesByArtist($userId);
   
   // Pass the artist details to the artistitemplate.html file
   $page = file_get_contents("../html/template_artista.html");
   $page = str_replace("{artista_image}", "../../immagini/artisti/{$artist['pseudonimo']}.jpg", $page);
   $page = str_replace("{name}", $artist['pseudonimo'], $page);
   $page = str_replace("{surname}", $artist['email_contatto'], $page);
   $page = str_replace("{mail}", $artist['email_contatto'], $page);
   $page = str_replace("{descriptionArtist}", $artist['descrizione'], $page);
   
   // Generate the HTML for the images
   $imagesHtml = "";
   if (!empty($images)) {
       foreach ($images as $image) {
           $imagesHtml .= "<img src=\"{$image}\" alt=\"\">";
       }
   } else {
       $imagesHtml = "No images found.";
   }
   
   
   // Replace the {listaOpere} placeholder with the generated HTML for the images
   $page = str_replace("{listaOpere}", $imagesHtml, $page);
   require_once "../config.php";
   require_once "../php/modules-loader.php";
   echo $page;
 } else {
   echo "Artist not found.";
 }
 
 $connection->closeConnection();
} else {
 echo "Database connection error.";
}
?>
