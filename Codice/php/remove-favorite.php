<?php
require_once "DBAccess.php";
use DB\DBAccess;

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();
$error = false;

if($connectionOk){
    if(session_status() == PHP_SESSION_NONE)
        session_start();
    if(!isset($_SESSION["email"])){
        $error = true;
    }
    if(isset($_POST['opera_id']) && !$error){ 
        $connection->removeFavourite($_SESSION["email"], $_POST['opera_id']);
    }
}

header("Location: ".$_SESSION["go_back_page"]);
?>