<?php
// uploadProfileImage.php
require_once "DBAccess.php";
use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    if (isset($_FILES['profileImage'])) {
        $userId = $_SESSION["email"];
        $profileImage = $_FILES['profileImage'];

        // Check if the file is an image
        $fileType = exif_imagetype($profileImage['tmp_name']);
        if ($fileType === false) {
            echo "Invalid file format.";
            exit();
        }

        // Define the allowed image types
        $allowedTypes = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF);

        // Check if the uploaded image is of an allowed type
        if (!in_array($fileType, $allowedTypes)) {
            echo "Unsupported image type. Please upload a JPEG, PNG, or GIF.";
            exit();
        }

        // Define the directory where the profile images will be stored
        $profileImageDirectory = '../../immagini/artisti/';

        // Generate a unique filename for the profile image using the artist's name
        $artistName = $connection->getArtistaPseudonimoByUser($userId);
        $profileImageFilename = $artistName . '.' . pathinfo($profileImage['name'], PATHINFO_EXTENSION);

        // Move the uploaded file to the profile image directory
        $destinationPath = $profileImageDirectory . $profileImageFilename;

        // If a file with the same name already exists, delete it
        if (file_exists($destinationPath)) {
            unlink($destinationPath);
        }

        if (!move_uploaded_file($profileImage['tmp_name'], $destinationPath)) {
            echo "Error uploading image.";
            exit();
        }

  
        // Redirect back to the previous page
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    echo "Database connection error.";
}

$connection->closeConnection();
?>
