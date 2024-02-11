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

        // Check if the file is an image
        $fileType = exif_imagetype($profileImage['tmp_name']);
        if ($fileType === false) {
            echo "Formato non supportato. Perfavore inserisci una JPEG oPNG.";
            exit();
        }

        // Define the allowed image types
        $allowedTypes = array(IMAGETYPE_JPEG, IMAGETYPE_PNG);

        // Check if the uploaded image is of an allowed type
        if (!in_array($fileType, $allowedTypes)) {
            echo "Formato non supportato. Perfavore inserisci una JPEG oPNG.";
            exit();
        }

        // Define the directory where the profile images will be stored
        $profileImageDirectory = '../../immagini/artisti/';

        // Get the current pseudonimo
        $artistName = $connection->getArtistaPseudonimoByUser($userId);

        // Cancella il file esistente chiamato pseudonimo 
        $existingFilePath = $profileImageDirectory . $artistName . '.jpg';
        if (file_exists($existingFilePath)) {
            unlink($existingFilePath);
        }
        $existingFilePath = $profileImageDirectory . $artistName . '.png';
        if (file_exists($existingFilePath)) {
            unlink($existingFilePath);
        }

        // Generate a unique filename for the profile image using the artist's name and the new file type
        $profileImageFilename = $artistName . '.' . pathinfo($profileImage['name'], PATHINFO_EXTENSION);

        // Move the uploaded file to the profile image directory
        $destinationPath = $profileImageDirectory . $profileImageFilename;

        if (!move_uploaded_file($profileImage['tmp_name'], $destinationPath)) {
            echo "Errore durante il caricamento dell'immagine. Perfavore riprova.";
            exit();
        }

        // Redirect back to the previous page
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    echo "Errore di connessione al <span lang=\"en\">database</span>.";
}

$connection->closeConnection();
?>
