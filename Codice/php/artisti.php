<?php
require_once "DBAccess.php";
require_once "../config.php";

use DB\DBAccess;

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  $_SESSION["go_back_page"] = $artists_page; 
  $artists = $connection->getArtists();
  
  if (!empty($artists)) {
      // genero la lista di artisti
      $artistaString = "";
      
      foreach ($artists as $listaArtisti) {
          $artistaLink = "template_artista.php?id={$listaArtisti['utente']}";
          $artistaName = $listaArtisti['pseudonimo'];
          $artistaDescription = $listaArtisti['descrizione'];

          $fotoProfiloJPG = "../../immagini/artisti/" . $artistaName . ".jpg";
    
          // se il file non esiste, prova a caricare la versione PNG
          if (!file_exists($fotoProfiloJPG)) {
              $fotoProfiloPNG = "../../immagini/artisti/" . $artistaName . ".png";
              // controllo se esiste la versione PNG
              if (file_exists($fotoProfiloPNG)) {
                  $fotoProfilo = $fotoProfiloPNG;
              } else {
                  // se nessuna delle due versioni esiste, imposto un'immagine di profilo predefinita
                  $fotoProfilo = "../../immagini/account_logo.png";
              }
          } else {
              $fotoProfilo = $fotoProfiloJPG;
          }

          $artistaString .= "<li class=\"card\">
              <div class=\"card-body\">
                  <a href=\"{$artistaLink}\" id=\"Artista{$listaArtisti['utente']}\">
                      <img src=\"$fotoProfilo\" alt=\"Immagine artista\">
                  </a>
                  <p class=\"pseudonimo\"><strong>{$artistaName}</strong></p>
              <p>{$artistaDescription}</p>
              </div>
              
             
            </li>";

       
      }
      // inserisco la lista di artisti nella pagina in ul
      $page = str_replace("{artist-list}", $artistaString, file_get_contents("../html/artistitemplate.html"));

      $_SESSION["nav_page"] = "artists"; //importante definirlo in ogni pagina tra home | contatti ...
      include "modules-loader.php";

      echo $page; //per far funzionare script sopra è importante che si chiami page
  } else {
      echo "Nessun artista trovato.";
  }
  
  $connection->closeConnection();
} else {
  echo "Errore di connessione al <span lang=\"en\">database</span>, ci scusiamo per il disagio.";
}
?>
