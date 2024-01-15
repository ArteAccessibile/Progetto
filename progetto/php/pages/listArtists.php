<?php
require_once '../framework/orm.php';
include '../model/artistModel.php';

// Assuming you have an instance of ArtistModel
$artistModel = new ArtistModel();

// Fetch all artists from the database
$artists = $artistModel->findAll();

// Output artist information as JSON for JavaScript to consume
echo json_encode($artists);
?>