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

$messaggiForm="";
// Set locale
setlocale(LC_ALL, 'it_IT');

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    if (isset($_POST['delete_image'])) {
        $imagePath = "../immagini/artisti/" . $_POST['name']; // E.g. "../immagini/artisti/immagine.jpg
        $userId = $_SESSION["email"];

        // Check if the image path is set and not empty
        if (!empty($imagePath)) {
            // Check if the file exists before attempting to delete it
            if (file_exists($imagePath)) {
                // Attempt to delete the file from the filesystem
                if (unlink($imagePath)) {
                    // File deleted successfully, now delete the record from the database
                    $result = $connection->deleteImageFromDatabase($userId, $imagePath);
                    if ($result) {
                        // Success message
                        $messaggiForm= "Immagine eliminata con successo.";
                       
                    } else {
                        $messaggiForm= "Errore nell'eliminazione dal database, ritenta.";
                    }
                } else {
                    $messaggiForm= "Errore nell'eliminazione del file, ritenta.";
                }
            } else {
                $messaggiForm= "Il file specificato non esiste.";
            }
        } else {
            $messaggiForm= "Il percorso dell'immagine non è stato fornito.";
        }
    }
} else {
    $messaggiForm= "Errore durante la connesione al database.";
}
$connection->closeConnection();


 $page= file_get_contents("../html/account_artista.html");
 $page = str_replace("{messaggiForm}", "<div class=\"errors-forms\"><p>".$messaggiForm."</p></div>", $page);
 // Redirect to the previous page
 ob_end_clean(); // Clear any buffered output
 header("Location: " . $_SERVER['HTTP_REFERER']);

 exit();


?>
