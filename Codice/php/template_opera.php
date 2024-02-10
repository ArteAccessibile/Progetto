<?php
require_once "DBAccess.php";
use DB\DBAccess;

$operaId = $_GET['id'];

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$textMessageForm="";
$file_path="";
$opera_name="";
$opera_description="";
$disable="";

if ($connectionOk) {
    $opera = $connection->getOperaById($operaId);
    
    if (!empty($opera)) {
        // prendo i dati dell'opera
        $file_path = isset($opera['file_path']) ? $opera['file_path'] : '';
        $opera_name = isset($opera['titolo']) ? $opera['titolo'] : '';
        $opera_description = isset($opera['descrizione']) ? $opera['descrizione'] : '';

        // se il file esiste
        if (!file_exists($file_path)) {
            $textMessageForm= "File not found.";
            echo $file_path;
        }

        if(isset($_SESSION["email"])){
            if($connection->checkPreferita($operaId,$_SESSION["email"])){
                $textMessageForm= "L'opera è presente nei tuoi preferiti.";
                $disable="disabled";

            }
        }
        else{
            $textMessageForm= "Per aggiungere l'opera ai preferiti devi essere loggato.";
            $disable="disabled";
        }

    } else {
        $textMessageForm= "Opera non trovata.";
    }
    
    $connection->closeConnection();
} else {
    $textMessageForm= "Errore di connessione al database.";
}


 // Pass the opera details to the template_opera.html file
 $page = file_get_contents("../html/template_opera.html");
 $page = str_replace("{cosa}", $opera_name, $page);
 $page = str_replace("{opera_image}", $file_path, $page);
 $page = str_replace("{operaId}", $operaId, $page);    
 $page = str_replace("{opera_name}", $opera_name, $page);
 $page = str_replace("{opera_description}", $opera_description, $page);
 $page = str_replace("{valore}", $disable, $page);
 $page = str_replace("{MessaggiForm}", $textMessageForm, $page);

 require_once "../config.php";
 $_SESSION["nav_page"] = "gallery";
 require_once "modules-loader.php";
 echo $page;
 ?>
