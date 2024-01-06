<?php
require_once "DBAccess.php";
use DB\DBAccess;

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
  $artists = $connection->getArtists();
  
  if (!empty($artists)) {
      // Generate the list items
      $artistaString = "";
      foreach ($artists as $artista) {
          $artistaLink = "template_artista.php?id={$artista['utente']}";
          $artistaName = $artista['pseudonimo'];
          $artistaDescription = $artista['descrizione'];
          $artistaString .= "<li class=\"card\">
              <div class=\"card-body\">
                  <a href=\"{$artistaLink}\" id=\"Artista{$artista['utente']}\">
                      <img src=\"../../immagini/artisti/{$artista['pseudonimo']}.jpg\" alt=\"Artist Image\">
                  </a>
                  <h1>{$artistaName}</h1>
                  <p>{$artistaDescription}</p>
              </div>
            </li>";

       
      }
      // Insert the list items into the <ul> tag
      $paginaHTML = str_replace("{artist-list}", $artistaString, file_get_contents("../html/artistitemplate.html"));
      echo $paginaHTML;
  } else {
      echo "No artists found.";
  }
  
  $connection->closeConnection();
} else {
  echo "Database connection error.";
}
?>
