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

$router->addRoute('/', 'HomeController', 'index');
$router->addRoute('/about', 'HomeController', 'about');
$router->addRoute('/login', 'UserController', 'login');
$router->addRoute('/logout', 'UserController', 'login');
$router->addRoute('/users', 'UserController', 'listUsers');
$router->addRoute('/register', 'UserController', 'register');
$router->addRoute('/artist/save', 'ArtistController', 'save');
$router->addRoute('/artists', 'ArtistController', 'listArtists');
$router->addRoute('/artwork/save', 'ArtistController', 'addArtwork');
$router->addRoute('/artist/listArtworks', 'ArtistController', 'listArtworks');
$router->addRoute('/artwork/upload', 'ArtistController', 'uploadArtwork');
$router->addRoute('/artworks', 'ArtworkController', 'index');


$router->dispatch();
?>