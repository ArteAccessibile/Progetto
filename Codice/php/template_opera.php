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
            $textMessageForm= "<span lang=\"en\">File</span> non trovato.";
            echo $file_path;
        }

        if(isset($_SESSION["email"])){
            if($connection->checkPreferita($operaId,$_SESSION["email"])){
                $textMessageForm= "L'opera è presente nei tuoi preferiti.";
                $disable="disabled";

            }
        }
        else{
            $textMessageForm= "Per aggiungere l'opera ai preferiti devi eseguire l'accesso.";
            $disable="disabled";
        }

    } else {
        $textMessageForm= "Opera non trovata.";
    }
    
    $connection->closeConnection();
} else {
    $textMessageForm= "Errore di connessione al <span lang=\"en\">database</span>.";
}


 $page = file_get_contents("../html/template_opera.html");
 $page = str_replace("{cosa}", $opera_name, $page);
 $page = str_replace("{opera_image}", $file_path, $page);
 $page = str_replace("{operaId}", $operaId, $page);    
 $page = str_replace("{opera_name}", $opera_name, $page);
 $page = str_replace("{opera_description}", $opera_description, $page);
 $page = str_replace("{valore}", $disable, $page);
 $page = str_replace("{MessaggiForm}", $textMessageForm, $page);

 if(isset($_SESSION["role"]) && $_SESSION["role"] == "admin"){
    $button = "
                <dd>
                <form action=\"../php/removeOperaAdmin.php\" method=\"post\">
                    <fieldset class=\"noBordo\">
                        <legend>Elimina l'opera</legend>
                        <input type=\"hidden\" name=\"opera_id\" value=\"".$operaId."\">
                        <input class=\"admin-remove-opera\" id=\"admindeleteopera".$operaId."\" type=\"submit\" value=\"Elimina opera\">
                    </fieldset>
                </form>
                </dd>
              ";
    $page = str_replace("<admin-visibility/>", $button, $page);
 }
else
    $page = str_replace("<admin-visibility/>", "", $page);

 require_once "../config.php";
 $_SESSION["nav_page"] = "gallery";
 require_once "modules-loader.php";
 echo $page;
 ?>
