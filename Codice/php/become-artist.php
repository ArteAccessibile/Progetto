<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION["role"])) {
        if ($_SESSION["role"] == "artista") {
            header("Location: ../index.php");
            exit;
        }
    }

    if(!isset($_SESSION["email"]) || !isset($_POST['new_artist_submit'])) {
        require_once "../config.php";
        $page = file_get_contents($html_path . "diventa_artista.html");
        $page = str_replace("<error/>", "<div class=\"errors-forms\"><p> Sessione scaduta, torna al login per accedere: <a href=\"login.php\"> Vai al login </a> </p></div>", $page); 
        $page = str_replace("<visibility/>", "<div class=\"nascosto\">", $page);
        echo $page;
        exit;
    }

    require_once "../php/clean-input.php";

    $desc = clearInput($_POST['new_desc']);
    $pseudonimo = clearInput($_POST['new_pseudonimo']);
    $email_contatto = clearInput($_POST['new_artist_email']);

    $error_messages = "";

    if (strlen($desc) == 0){
        $error_messages .= '<li>Descrizione non inserita</li>';
    }

    if (strlen($email_contatto) == 0){
        $error_messages .= '<li>Email di contatto non inserita</li>';
    }

    if(!filter_var($email_contatto, FILTER_VALIDATE_EMAIL)){
        $error_messages .= '<li>Email di contatto non valida</li>';
    }

    if (strlen($pseudonimo) == 0){
        $error_messages .= '<li>Pseudonimo non inserito</li>';
    }

    require_once "DBAccess.php";
    use DB\DBAccess;
    if(!strlen($error_messages)){
        $funzioniDB = new DBAccess();
        $conn = $funzioniDB->openDBConnection();
    
        if($conn){
            if ($funzioniDB->becameArtist($_SESSION["email"], $desc,$pseudonimo, $email_contatto)){
                $ok = "Sei diventato un artista! Ora puoi caricare le tue opere e gestire il tuo profilo.";
                $_SESSION["role"] = "artista";
                require_once "../config.php";
                $page = file_get_contents($html_path . "diventa_artista.html");
                $page = str_replace("<ok/>", "<p class=\"ok-message\">".$ok."</p>", $page);
                echo $page;
                exit;
            }else {
                $error_messages = "Si è verificato un errore nell'inserimento dei dati, riprova.";
            }
        }else{
            die("Errore nella connessione al database");
        }
    }
        
    if(strlen($error_messages) > 0){
        require_once "../config.php";
        $page = file_get_contents($html_path . "diventa_artista.html");
        $page = str_replace("<error/>", "<div class=\"errors-new-artist\"><ul>" . $error_messages . "</ul></div>", $page);
        $page = str_replace("<visibility/>", "<div>", $page);
        echo $page;
        exit;
    }

?>


