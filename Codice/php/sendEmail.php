<?php
require_once "../php/clean-input.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se l'utente è loggato
    if (isset($_SESSION["email"])) {
        $object = clearInput($_POST["object"]);
        $description = clearInput($_POST["description"]);
        $email = $_SESSION["email"];
        $error = "";

        // Email dove ricevere i messaggi
        $to = "nacope5970@fkcod.com";

        // oggetto della mail
        $subject = "Contatto da Arte Per Tutti: $object";

        // testo 
        $message = "Email: $email\nOggetto: $object\nDescrizione:\n$description";

        // intestazioni
        $headers = "From: $email";

        // tentativo di invio della mail
        $success = mail($to, $subject, $message, $headers);

        if ($success) {
            $error = "Messaggio inviato con successo!";
        } else {
            $error = "Errore nell'invio del messaggio.";
        }
    } else {
        $error = "Devi effettuare l'accesso per poter inviare un messaggio.";
    }
} else {
    $error = "Errore nella richiesta.";
}

$paginaHtml = file_get_contents("../html/contatti.html");
$paginaHtml = str_replace("{messaggiForm}", $error, $paginaHtml);

echo $paginaHtml;
?>
