<?php
require_once "DBAccess.php";
use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("../html/galleriatemplate.html");
$stringaOpere = "";
$listaOpere = "";

$connection = new DBAccess();

$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaOpere = $connection->getOperas();

    if ($listaOpere != null) {
        foreach ($listaOpere as $opera) {
            $file_path = $opera['file_path'];
            $opera_name = $opera['titolo'];

            // Creating the list with opera names and respective image file paths
            $stringaOpere .= "<li><a href='example.com'>$opera_name</a></li> <img src='$file_path' alt='$file_path'>";
        }
    } else {
        $stringaOpere .= "<li>Non sono presenti opere</li>";
    }

    $connection->closeConnection();
} else {
    $stringaOpere = "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
}

$paginaHTML = str_replace("{opere}", $stringaOpere, $paginaHTML);
echo $paginaHTML;
?>
