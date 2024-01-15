<?php
include 'php/framework/router.php';


foreach (glob("framework/*.php") as $filename) {
    require $filename;
}

// require all files in controller folder
foreach (glob("controller/*.php") as $filename) {
    require $filename;
}

// requeire all files in model folder
foreach (glob("model/*.php") as $filename) {
    require $filename;
}

$router = new Router();

$router->addRoute('/artworks', 'artworkController', 'index');


$router->dispatch();
?>