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

// Set locale
setlocale(LC_ALL, 'it_IT');

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    if (isset($_POST['delete_image'])) {
        $imagePath = $_POST['image_path'];
        $userId = $_SESSION["email"];

        // controlla se c'è l'immagine
        if (!empty($imagePath)) {
            // e se esiste
            if (file_exists($imagePath)) {
                // cancella l'immagine
                if (unlink($imagePath)) {
                    //  messaggio di successo e cancella l'immagine dal database
                    $result = $connection->deleteImageFromDatabase($userId, $imagePath);
                    if ($result) {
                        echo "Immagine eliminata con successo.";
                    } else {
                        echo "Errore nell'eliminazione dal database, ritenta.";
                    }
                } else {
                    echo "Errore nell'eliminazione del file, ritenta.";
                }
            } else {
                echo "Il file specificato non esiste.";
            }
        } else {
            echo "Il percorso dell'immagine non è stato fornito.";
        }
    }
} else {
    echo "Errore durante la connesione al database.";
}

$connection->closeConnection();
?>