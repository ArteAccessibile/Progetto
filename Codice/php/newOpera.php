<?php
require_once "../php/DBAccess.php";


use DB\DBAccess;


ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("../html/opera_upload.html");

$funzioniDB = new DBAccess();

$conn = $funzioniDB->openDBConnection();

$messaggiPerForm = ""; //messaggio errore

//Variabili per il form
$titolo = '';
$data_creazione = '';
$proprietario = '';
$breveDescrizione = '';
$descrizione = '';


function pulisciInput($value) {
    $value = trim($value); 
    $value = strip_tags($value); 
    $value = htmlentities($value);
    return $value;
}

if(isset($_POST['submit'])){  

    
    $titolo = $funzioniDB->pulisciInput($_POST['titolo']); 
    if (strlen($titolo) == 0){
        $messaggiPerForm .= '<li>titolo non inserito</li>';
    }


    $anno = $funzioniDB->pulisciInput($_POST['anno']);
    if (strlen($anno) == 0){
        $messaggiPerForm .= '<li>anno non inserito</li>';
    }else{
        if(!preg_match("/^\d{4}$/", $anno)) {
            $messaggiPerForm .= '<li>anno deve essere un numero di 4 cifre</li>';
        }
    }

    $proprietario = $funzioniDB->pulisciInput($_POST['proprietario']);
    if (strlen($proprietario) == 0){
        //$messaggiPerForm .= '<li>proprietario non inserito</li>';
        $proprietarioNULL = NULL;//se non c'è proprietario
    }
    else{
        if(preg_match("/\d/", $proprietario)){
            $messaggiPerForm .= '<li>Il proprietario non può contenere numeri</li>';
        }
        $proprietarioNULL=$proprietario;//se invece c'è
    }

    $descrizione = $funzioniDB->pulisciInput($_POST['descrizione']);
    if (strlen($descrizione) == 0){
        $messaggiPerForm .= '<li>descrizione non inserita</li>';
    }

    $desc_abbrev = $funzioniDB->pulisciInput($_POST['desc_abbrev']);
    if (strlen($desc_abbrev) == 0){
        $messaggiPerForm .= '<li>descrizione abbreviata non inserita</li>';
    }
    else if(strlen($desc_abbrev)>75){
        $messaggiPerForm .= '<li>descrizione abbreviata troppo lunga</li>';
    }
    //CONTROLLO ESISTENZA DELL?OPERA
    if($funzioniDB->checkOpera($titolo, $artista)){
        $messaggiPerForm .= "<li>L'opera esiste già o stai usando un path o titolo già esistente</li>";
    }

    //IMMAGINE
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // DESTINAZIONE
        $uploadDir = "../../immagini/";
    
        // Verifica se la cartella di destinazione esiste, altrimenti crea la cartella
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
    
        // INFORMAZIONI SULL'IMMAGINE(recuperata online)
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
        // Verifica se il file è un'immagine
        $allowTypes = array("jpg", "jpeg", "png", "gif");
        if (in_array($fileType, $allowTypes)) {
            // Sposta il file nella cartella di destinazione
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                //echo "L'immagine " . $fileName . " è stata caricata con successo.";
            } else {
                $messaggiPerForm = "Si è verificato un errore durante il caricamento dell'immagine.";
                //echo "Si è verificato un errore durante il caricamento dell'immagine.";
            }
        } else {
            $messaggiPerForm = "Sono consentiti solo file di tipo JPG, JPEG, PNG e GIF.";
            //echo "Sono consentiti solo file di tipo JPG, JPEG, PNG e GIF.";
        }
    }
    //IMMAGINE

if(strlen($messaggiPerForm) == 0){//se non ci sono messaggi di errore fino ad qua
    if($conn){

        if ($funzioniDB->aggiungiOpera($artista,$titolo,$desc_abbrev,$descrizione, $data_creazione)){
            $messaggiPerForm = "l'opera è stato aggiunta con successo";

            
        }else {
            //echo "Errore nell'inserimento dei dati: ";
            $messaggiPerForm = "l'opera NON è stato aggiunta, si è presentato un errore nell'inserimento dati";
        }
    }else{
        die("Errore nella connessione al database");
    }
}   
    
}

$funzioniDB->closeConnection();
//per non perdere quello scritto in caso di errore
$paginaHTML = str_replace("{nome_utente}", $_SESSION["name"], $paginaHTML);
$paginaHTML = str_replace("{messaggiForm}", $messaggiPerForm, $paginaHTML);
$paginaHTML = str_replace("{titolo}", $titolo, $paginaHTML); 
$paginaHTML = str_replace("{anno}", $data_creazione, $paginaHTML);
$paginaHTML = str_replace("{descrizione}", $descrizione, $paginaHTML);

echo $paginaHTML;
?>