<?php
// delete_image.php
require_once "DBAccess.php";
use DB\DBAccess;

// Start session and set up error reporting
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors',  1);
ini_set('display_startup_errors',  1);
error_reporting(E_ALL);

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    if (isset($_POST['deleteImage']) && isset($_POST['nome_immagine'])) { // se il form è stato inviato
        $userId = $_SESSION["email"];
        $imageName = $_POST['nome_immagine'];
        
        $profileImageDirectory= '../../immagini/';
        // controllo se l'immagine esiste in entrambi i formati 
        $existingFilePath = $profileImageDirectory . $imageName . '.jpg';
        if (file_exists($existingFilePath)) {
            unlink($existingFilePath);
        }
        $existingFilePath = $profileImageDirectory . $imageName . '.png';
        if (file_exists($existingFilePath)) {
            unlink($existingFilePath);
        }
        
        // cancello l'immagine dal database
        $result = $connection->deleteImageFromDatabase($userId, $imageName);
        if ($result) {
            // Success message
            $echo = "Immagine eliminata con successo.";
        } else {
            $echo = "Errore nell'eliminazione dal database, ritenta.";
        }
    } else {
        $echo = "Il percorso dell'immagine non è stato fornito.";
    }
} else {
    $echo = "Errore durante la connessione al database.";
}

$connection->closeConnection();

// Redirect

header("Location: " . $_SERVER['HTTP_REFERER'] . "?message=" . urlencode($echo));
exit();
?>
