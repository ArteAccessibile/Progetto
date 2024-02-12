<?php
require_once "DBAccess.php";
use DB\DBAccess;

$operaId = $_GET['id'];

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();
$error = false;

if($connectionOk){
    if(session_status() == PHP_SESSION_NONE)
        session_start();
    if(!isset($_SESSION["email"])){
        $error = true;
    }
    if(isset($_GET['id'])){ //TODO NON VA BENE DIOCANE PERCHè SE NO METTI URL E CIAO
        $connection->removeFavourite($_SESSION["email"], $operaId);
        header("Location: ".$_SESSION["go_back_page"]);
    }
}
else
    $error = true;

//if error prendi errore e vai alla pagina

?>