<?php
require_once "DBAccess.php";
require_once "../config.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$page = file_get_contents("../html/contatti.html");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION["nav_page"] = "contacts"; //importante definirlo in ogni pagina tra home | contatti ...
include "modules-loader.php";
echo $page;
?>
