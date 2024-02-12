<?php
// delete_image.php
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
    if (isset($_POST['delete_image'])) {
        $imagePath = $_POST['image_path'];
        $userId = $_SESSION["email"];

        // Use try-catch block to handle exceptions
        try {
            $result = $connection->deleteImageFromDatabase($userId, $imagePath);

            if ($result) {
                echo "Immagine eliminata con successo.";
            } else {
                echo "Errore nell'eliminazione, ritenta.";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        // Redirect back to the previous page
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    echo "Errore durante la connesione al <span lang=\"en\">database</span>.";
}

$connection->closeConnection();
?>
