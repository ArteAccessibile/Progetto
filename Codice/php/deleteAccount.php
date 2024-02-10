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

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    // Assicurati che l'utente sia autenticato
    if (isset($_SESSION["email"])) {
        $email = $_SESSION["email"];

        // Elimina i dati dell'utente
        $success = $connection->removeUserAccount($email);

        if ($success) {
            // Eliminazione riuscita, reindirizza o gestisci di conseguenza
            session_destroy(); // Opzionale: distruggi la sessione dopo l'eliminazione dell'account
            header("Location: ../index.php"); // Reindirizza a una pagina di conferma o alla homepage
            exit();
        } else {
            // Gestisci l'errore in caso di fallimento dell'eliminazione
            echo "Errore durante l'eliminazione dell'account.";
        }
    } else {
        // Utente non autenticato, gestisci di conseguenza
        echo "Utente non autenticato.";
    }
}

$connection->closeConnection();
?>
