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
$dataCreazione = '';
$proprietario = '';
$breveDescrizione = '';
$descrizione = '';
$ListaArtisti='';


function pulisciInput($value) {
    $value = trim($value); 
    $value = strip_tags($value); 
    $value = htmlentities($value);
    return $value;
}

if(isset($_POST['submit'])){  

    $ListaArtisti=$funzioniDB->getArtistiPseudonimo();
    $opzioniArt="";
    foreach($ListaArtisti as $artista){
        $opzioniArt.= "<option value=\"{$artista}\">{$artista}</option>";
    }

    
    $messaggiPerForm="";
    $titolo = pulisciInput($_POST['titolo']); 
    if (strlen($titolo) == 0){
        $messaggiPerForm .= '<li>titolo non inserito</li>';
        echo "sei qui";
    }


    $dataCreazione = $funzioniDB->pulisciInput($_POST['Data']);
    if (strlen($dataCreazione) == 0){
        $messaggiPerForm .= '<li>anno non inserito</li>';
    }
    

    $proprietario = $funzioniDB->pulisciInput($_POST['artista']);
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

    $desc_abbrev = $funzioniDB->pulisciInput($_POST['breve_descrizione']);
    if (strlen($desc_abbrev) == 0){
        $messaggiPerForm .= '<li>descrizione abbreviata non inserita</li>';
    }
    else if(strlen($desc_abbrev)>75){
        $messaggiPerForm .= '<li>descrizione abbreviata troppo lunga</li>';
    }
    //CONTROLLO ESISTENZA DELL?OPERA
    if($funzioniDB->checkOpera($titolo, $proprietario)){
        $messaggiPerForm .= "<li>L'opera esiste già o stai usando un path o titolo già esistente</li>";
    }

    //IMMAGINE
    if (isset($_FILES['immagine']) && $_FILES['immagine']['error'] == 0) {
        $uploadDir = "../../immagini/";
        $fileName = basename($_FILES["immagine"]["name"]);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["immagine"]["tmp_name"], $targetFilePath)) {
                // File upload success
            } else {
                $messaggiPerForm .= "Errore nel caricamento del file.";
            }
        } else {
            $messaggiPerForm .= "Solo file JPG, JPEG, PNG e GIF sono permessi.";
        }
    } else {
        $messaggiPerForm .= "Si prega di selezionare un file da caricare.";
    }
    //IMMAGINE

if(strlen($messaggiPerForm) == 0){//se non ci sono messaggi di errore fino ad qua
    if($conn){

        if ($funzioniDB->aggiungiOpera($proprietario,$titolo,$desc_abbrev,$descrizione, $dataCreazione)){
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
//$paginaHTML = str_replace("{nome_utente}", $_SESSION["name"], $paginaHTML);
$paginaHTML = str_replace("{messaggiForm}", $messaggiPerForm, $paginaHTML);
$paginaHTML = str_replace("{listaArtisti}", $opzioniArt, $paginaHTML);

echo $paginaHTML;
?>