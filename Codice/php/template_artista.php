<?php
require_once "DBAccess.php";
use DB\DBAccess;

$userId = $_GET['id'];

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
  $artist = $connection->getArtistByUser($userId);
  
  if (!empty($artist)) {
      // Pass the artist details to the artistitemplate.html file
      $paginaHTML = file_get_contents("../html/template_artista.html");
      $paginaHTML = str_replace("{name}", $artist['pseudonimo'], $paginaHTML);
      $paginaHTML = str_replace("{surname}", $artist['email_contatto'], $paginaHTML);
      $paginaHTML = str_replace("{mail}", $artist['email_contatto'], $paginaHTML);
      $paginaHTML = str_replace("{descriptionArtist}", $artist['descrizione'], $paginaHTML);
      echo $paginaHTML;
  } else {
      echo "Artist not found.";
  }
  
  $connection->closeConnection();
} else {
  echo "Database connection error.";
}
?>
