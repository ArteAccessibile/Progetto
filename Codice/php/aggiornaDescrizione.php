```php
<?php
// updatedescription.php
require_once "DBAccess.php";
require_once "../php/clean-input.php";
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
    if (isset($_POST['descrizione'])) {
        $descrizione = clearInput( $_POST['descrizione']);
        $userId = $_SESSION['email'];

        // Esegui la query di aggiornamento
        $success = $connection->aggiornaDescrizione($userId, $descrizione);

        if ($success) {
            // Redirect alla pagina precedente
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "Errore nell'aggiornamento della descrizione.";
        }
    } else {
        echo "Descrizione non fornita.";
    }
} else {
    echo "Errore di connessione al database.";
}

$connection->closeConnection();
?>
```