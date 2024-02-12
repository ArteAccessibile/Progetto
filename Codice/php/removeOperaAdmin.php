<?php
// deleteAccount.php
require_once "DBAccess.php";
use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION["role"])){
    header("Location: ../index.php");
    exit();
}

if($_SESSION["role"] != "admin"){
    header("Location: ../index.php");
    exit();
}

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    // Assicurati che l'utente sia autenticato
    if (isset($_POST["opera_id"])) {
        // Elimina i dati dell'utente
        $success = $connection->deleteOpera($_POST["opera_id"]);

        if ($success) {
            require_once "../config.php";
            header("Location: ".$gallery_page); // Reindirizza a una pagina 
            exit();
        } else {
            // Gestisci l'errore in caso di fallimento dell'eliminazione
            echo "Errore durante l'eliminazione dell'opera.";
        }
    } else {
        // Utente non autenticato, gestisci di conseguenza
        echo "Errore.";
    }
}

$connection->closeConnection();
?>
