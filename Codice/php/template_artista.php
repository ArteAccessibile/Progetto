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
   $paginaHTML = file_get_contents("../html/template_artista.html");
   $paginaHTML = str_replace("{artista_image}", "../../immagini/artisti/{$artist['pseudonimo']}.jpg", $paginaHTML);
   $paginaHTML = str_replace("{name}", $artist['pseudonimo'], $paginaHTML);
   $paginaHTML = str_replace("{surname}", $artist['email_contatto'], $paginaHTML);
   $paginaHTML = str_replace("{mail}", $artist['email_contatto'], $paginaHTML);
   $paginaHTML = str_replace("{descriptionArtist}", $artist['descrizione'], $paginaHTML);
   
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
   $paginaHTML = str_replace("{listaOpere}", $imagesHtml, $paginaHTML);
   echo $paginaHTML;
 } else {
   echo "Artist not found.";
 }
 
 $connection->closeConnection();
} else {
 echo "Database connection error.";
}
?>
