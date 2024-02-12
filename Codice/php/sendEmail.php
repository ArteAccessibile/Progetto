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

        // Email address where you want to receive the message
        $to = "nacope5970@fkcod.com";

        // Subject of the email
        $subject = "Contatto da Arte Per Tutti: $object";

        // Message body
        $message = "Email: $email\nOggetto: $object\nDescrizione:\n$description";

        // Additional headers
        $headers = "From: $email";

        // Attempt to send the email
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
