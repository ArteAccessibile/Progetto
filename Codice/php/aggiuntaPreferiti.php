<?php
// uploadProfileImage.php
require_once "DBAccess.php";
use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$connection=new DBAccess();
$connectionOk=$connection->openDBConnection();


    if($connectionOk){
        if(isset($_POST['opera_id'])){
            $idOpera=$_POST['opera_id'];
            $userId=$_SESSION["email"];
            $success=$connection->aggiungiPreferiti($userId,$idOpera);
            if($success){
                echo "Opera aggiunta ai preferiti";
            }else{
                echo "Errore durante l'aggiunta ai preferiti";
            }
        }
        else{
            echo "Errore durante l'aggiunta ai preferiti";
        }
    }
    header("Location: template_opera.php?id=$idOpera");
    $connection->closeConnection();
?>