<?php

session_start();

require_once "DBAccess.php";
require_once "../config.php";
use DB\DBAccess;

ini_set('display_errors', 1); //per mostrare gli errori a video
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$page = file_get_contents("../html/account_artista.html");

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

  if ($connectionOk) {
  }


$page=str_replace("{pseudonimo}","da cambiare con _session[pseudonimo]",$page);
$page=str_replace("{emailUser}","da cambiare con _session[email]",$page);
$page=str_replace("{descrizione}","da cambiare con getDescByArtistEmail]",$page);
$page=str_replace("{mieOpere}","da cambiare con getOpereByArtistEmail]",$page);




echo $page;
?>