<?php
require_once "DBAccess.php";
use DB\DBAccess;

$operaId = $_GET['id'];

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $opera = $connection->getOperaById($operaId);
    
    if (!empty($opera)) {
        // Check if the necessary keys exist in the $opera array
        $file_path = isset($opera['file_path']) ? $opera['file_path'] : '';
        $opera_name = isset($opera['titolo']) ? $opera['titolo'] : '';
        $opera_description = isset($opera['descrizione']) ? $opera['descrizione'] : '';

        // Check if the file exists
        if (!file_exists($file_path)) {
            echo "File not found.";
            echo $file_path;
        }

        // Pass the opera details to the template_opera.html file
        $paginaHTML = file_get_contents("../html/template_opera.html");
        $paginaHTML = str_replace("{cosa}", $opera_name, $paginaHTML);
        $paginaHTML = str_replace("{opera_image}", $file_path, $paginaHTML);
        $paginaHTML = str_replace("{opera_name}", $opera_name, $paginaHTML);
        $paginaHTML = str_replace("{opera_description}", $opera_description, $paginaHTML);
        echo $paginaHTML;
    } else {
        echo "Opera not found.";
    }
    
    $connection->closeConnection();
} else {
    echo "Database connection error.";
}
?>
