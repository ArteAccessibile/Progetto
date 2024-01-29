<?php
require_once "DBAccess.php";
require_once "../config.php";

use DB\DBAccess;

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
  $artists = $connection->getArtists();
  
  if (!empty($artists)) {
      // Generate the list items
      $artistaString = "";
      foreach ($artists as $listaArtisti) {
          $artistaLink = "template_artista.php?id={$listaArtisti['utente']}";
          $artistaName = $listaArtisti['pseudonimo'];
          $artistaDescription = $listaArtisti['descrizione'];
          $artistaString .= "<li class=\"card\">
              <div class=\"card-body\">
                  <a href=\"{$artistaLink}\" id=\"Artista{$listaArtisti['utente']}\">
                      <img src=\"../../immagini/artisti/{$listaArtisti['pseudonimo']}.jpg\" alt=\"Artist Image\">
                  </a>
                  <h1>{$artistaName}</h1>
                  <p>{$artistaDescription}</p>
              </div>
            </li>";

       
      }
      // Insert the list items into the <ul> tag
      $page = str_replace("{artist-list}", $artistaString, file_get_contents("../html/artistitemplate.html"));

      $_SESSION["nav_page"] = "artists"; //importante definirlo in ogni pagina tra home | contatti ...
      include "modules-loader.php";

      echo $page; //per far funzionare script sopra è importante che si chiami page
  } else {
      echo "No artists found.";
  }
  
  $connection->closeConnection();
} else {
  echo "Database connection error.";
}
?>
