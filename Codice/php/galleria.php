<?php
require_once "DBAccess.php";
require_once "../config.php";
use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$page = file_get_contents("../html/galleriatemplate.html");
$stringaOpere = "";
$listaOpere = "";

$connection = new DBAccess();

$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
   if (session_status() === PHP_SESSION_NONE) {
     session_start();
   }
   $_SESSION["go_back_page"] = $gallery_page; 
   $listaOpere = $connection->getOperas();

   if ($listaOpere != null) {
       foreach ($listaOpere as $opera) {
           $file_path = $opera['file_path'];
           $opera_name = $opera['titolo'];
           $operaID = $opera['id'];
           $shortDesc = $opera['desc_abbrev'];

           $stringaOpere .= "
            
                <li> <img src='$file_path' alt='$shortDesc'>
                <h2>$opera_name</h2>
                <a href='../php/template_opera.php?id=$operaID'>Visualizza opera</a>
                </li> ";
       }
   } else {
       $stringaOpere .= "<li>Non sono presenti opere</li>";
   }

   $connection->closeConnection();
} else {
   $stringaOpere = "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
}

$page = str_replace("{opere}", $stringaOpere, $page);
$_SESSION["nav_page"] = "gallery"; //importante definirlo in ogni pagina tra home | contatti ...
require_once "modules-loader.php";
echo $page;
?>
