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

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    if (isset($_FILES['profileImage'])) {
        $userId = $_SESSION["email"];
        $profileImage = $_FILES['profileImage'];

        //controllo se il file è un'immagine
        $fileType = exif_imagetype($profileImage['tmp_name']);
        if ($fileType === false) {
            echo "Formato non supportato. Perfavore inserisci una JPEG oPNG.";
            exit();
        }

        // definisco i tipi di file supportati
        $allowedTypes = array(IMAGETYPE_JPEG, IMAGETYPE_PNG);

        // controllo se il file è tra i tipi supportati
        if (!in_array($fileType, $allowedTypes)) {
            echo "Formato non supportato. Perfavore inserisci una JPEG oPNG.";
            exit();
        }

        // directory dove verranno salvate le immagini
        $profileImageDirectory = '../../immagini/artisti/';

        // pseudo nome dell'artista
        $artistName = $connection->getArtistaPseudonimoByUser($userId);

        //rimuoivo l'immagine vecchia e la sostituisco con la nuova
        $existingFilePath = $profileImageDirectory . $artistName . '.jpg';
        if (file_exists($existingFilePath)) {
            unlink($existingFilePath);
        }
        $existingFilePath = $profileImageDirectory . $artistName . '.png';
        if (file_exists($existingFilePath)) {
            unlink($existingFilePath);
        }

        // la rinomina del file è fatta con il nome dell'artista
        $profileImageFilename = $artistName . '.' . pathinfo($profileImage['name'], PATHINFO_EXTENSION);

        // Metto il file nella cartella delle immagini
        $destinationPath = $profileImageDirectory . $profileImageFilename;

        if (!move_uploaded_file($profileImage['tmp_name'], $destinationPath)) {
            echo "Errore durante il caricamento dell'immagine. Perfavore riprova.";
            exit();
        }

        // redirect 
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    echo "Errore di connessione al <span lang=\"en\">database</span>.";
}

$connection->closeConnection();
?>
