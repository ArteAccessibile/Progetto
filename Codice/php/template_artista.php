<?php
require_once "DBAccess.php";
use DB\DBAccess;

$artistId = $_GET['id'];

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
   $artist = $connection->getArtistById($artistId);
   
   if (!empty($artist)) {
       // Pass the artist details to the artistitemplate.html file
       $paginaHTML = file_get_contents("../html/artistitemplate.html");
       $paginaHTML = str_replace("{name}", $artist['nome'], $paginaHTML);
       $paginaHTML = str_replace("{surname}", $artist['cognome'], $paginaHTML);
       $paginaHTML = str_replace("{mail}", $artist['email'], $paginaHTML);
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
