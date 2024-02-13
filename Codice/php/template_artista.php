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

   $profileImage= "../../immagini/artisti/{$artist['pseudonimo']}.jpg";
   if (!file_exists($profileImage)) {
       $profileImage = "../../immagini/artisti/{$artist['pseudonimo']}.png";
       if (!file_exists($profileImage)) {
           $profileImage = "../../immagini/account_logo.png";
       }
   }
   
   $page = file_get_contents("../html/template_artista.html");
   $page = str_replace("{artista_image}", $profileImage, $page);
   $page = str_replace("{name}", $artist['pseudonimo'], $page);
   $page = str_replace("{mail}", $artist['email_contatto'], $page);
   $page = str_replace("{descriptionArtist}", $artist['descrizione'], $page);
   
   $imagesHtml = "";
   if (!empty($images)) {
       foreach ($images as $image) {
            $imageName = pathinfo($image, PATHINFO_BASENAME);
                $imageName = str_replace(['.jpg', '.png'], '', $imageName); // Rimuovi l'estensione dal nome del file
                $imagesHtml .= "<div class='opera_artista_card'>";
                $imagesHtml .= "<img tabindex=\"0\" src='{$image}' alt='{$imageName}'>"; // uso il nome del file come attributo alt
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
