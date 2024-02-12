<?php
require_once "DBAccess.php";
require_once "../config.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$errorMessage="";

$page = file_get_contents("../html/contatti.html");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION["go_back_page"] = $contact_page;
$_SESSION["nav_page"] = "contacts"; //importante definirlo in ogni pagina tra home | contatti ...

$page = str_replace ("{messaggiForm}",$errorMessage,$page);

include "modules-loader.php";
echo $page;
?>
