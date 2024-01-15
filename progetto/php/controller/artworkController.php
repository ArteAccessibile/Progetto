<?php

include 'model/artistModel.php';
include 'model/artworkModel.php';
include '../pages/artworks.php';

class ArtworkController extends Controller {
    public function index() {
        $artworkModel = new ArtworkModel();
        $artworks = $artworkModel->get_all_artworks();
 
        $template = new TemplateEngine();
        $template->loadTemplate('listArtworks');
        $template->assign('title', 'List Artworks');
        $template->assign('artworks', $artworks);
        echo $template->render();
    }
 
   
 
    public function upload() {
        // logged in?
        if (!isset($_SESSION['user'])) {
            $this->redirect($this->link('/login'));
        }
 
        // see if I am an artist
        $artist = new ArtistModel();
        $artist_values = $artist->get_artist_by_user_id($_SESSION['user']['id']);
        if(empty($artist_values)){
            $this->redirect($this->link('/artist/save'));
        }
 
        $artworks = new ArtworkModel();
        $artworks = $artworks->get_artwork_by_artist_id($artist_values['id']);
 
        if (!isset($_GET['artwork_id'])) {
            $this->redirect($this->link('/artwork/list'));
        }
 
        // check if artwork belongs to artist
        $artwork_id = $_GET['artwork_id'];
        $found = false;
        foreach ($artworks as $artwork) {
            if ($artwork['id'] == $artwork_id) {
                $found = true;
                break;
            }
        }
 
        // not mine
        if (!$found) {
            $this->redirect($this->link('/artwork/list'));
        }
 
        // get artwork photo from post
        if (isset($_FILES['photo'])){
            // check if file is an image
            $check = getimagesize($_FILES["photo"]["tmp_name"]);
            if($check !== false) {
                // get file extension
                $imageFileType = strtolower(pathinfo($_FILES["photo"]["name"],PATHINFO_EXTENSION));
                //new file name
                $newName = $artwork_id . "." . $imageFileType;
                $target_file = "uploads/" . $newName;
                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                   // save file name in database
                   $this->redirect($this->link('/artwork/list'));
                } else {
                   echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "File is not an image.";
            }
        }
 
        $template = new TemplateEngine();
        $template->loadTemplate('uploadArtworkPhoto');
        $template->assign('title', 'Upload Artwork Photo');
        $template->assign('link', $this->link('/artwork/upload'));
        echo $template->render();

        
    }
 }
 


?>