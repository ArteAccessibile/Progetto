<?php

include 'php/framework/controller.php';
include 'php/framework/templateEngine.php';

class ArtistController extends Controller{
    public function save(){
        if (!isset($_SESSION['user'])) {
            $this->redirect($this->link('/login'));
        }

        // see if I am an artist
        $artist = new ArtistModel();
        $artist_values = $artist->get_artist_by_user_id($_SESSION['user']['id']);

        if (isset($_POST['alias']) && isset($_POST['contact_mail'])) {
            if ($artist_values) {
                $artist->id = $artist_values['id'];
                $artist->user_id = $_SESSION['user']['id'];
                $artist->alias = $_POST['alias'];
                $artist->contact_mail = $_POST['contact_mail'];
                $artist->save();
            } else {
                $artist->user_id = $_SESSION['user']['id'];
                $artist->alias = $_POST['alias'];
                $artist->contact_mail = $_POST['contact_mail'];
                $artist->save();
            }
        }

        $alias = "";
        $contact_mail = "";

        if ($artist_values) {
            $alias = $artist_values['alias'];
            $contact_mail = $artist_values['contact_mail'];
        }

        // template
        $template = new TemplateEngine();
        $template->loadTemplate('saveArtist');
        $template->assign('title', 'Save Artist');
        $template->assign('link', $this->link('/artist/save'));
        $template->assign('alias', $alias);
        $template->assign('contact_mail', $contact_mail);
        echo $template->render();
    }

    public function listArtists() {
        $artists = new ArtistModel();
        $artists = $artists->findAll();

        $template = new TemplateEngine();
        $template->loadTemplate('listArtists');
        $template->assign('title', 'List Artists');
        $template->assign('artists', $artists);
        echo $template->render();
    }

    public function addArtwork() {
        if (!isset($_SESSION['user'])) {
            $this->redirect($this->link('/login'));
        }

        // see if I am an artist
        $artist = new ArtistModel();
        $artist_values = $artist->get_artist_by_user_id($_SESSION['user']['id']);
        if(empty($artist_values)){
            $this->redirect($this->link('/artist/save'));
        }

        if (isset($_POST['title']) && isset($_POST['short_description']) && isset($_POST['description']) && isset($_POST['creation_date'])) {
            $artwork = new ArtworkModel();
            $artwork->artist_id = $artist_values['id'];
            $artwork->title = $_POST['title'];
            $artwork->short_description = $_POST['short_description'];
            $artwork->description = $_POST['description'];
            $artwork->creation_date = $_POST['creation_date'];
            $artwork->save();
            $this->redirect($this->link('/artist/listArtworks', ['artist_id' => $artist_values['id']]));
        }

        $template = new TemplateEngine();
        $template->loadTemplate('addArtwork');
        $template->assign('title', 'Add Artwork');
        $template->assign('link', $this->link('/artwork/save'));
        echo $template->render();
    }

    public function listArtworks() {
        if (!isset($_GET['artist_id'])) {
            $this->redirect($this->link('/artist/listArtists'));
        }

        $artist_id = $_GET['artist_id'];

        $artist = new ArtistModel();
        $artist = $artist->findById($artist_id);
        
        if (empty($artist)) {
            $this->redirect($this->link('/artist/listArtists'));
        }

        $artworks = new ArtworkModel();
        $artworks = $artworks->get_artwork_by_artist_id($artist_id);

        $template = new TemplateEngine();
        $template->loadTemplate('listArtwork');
        $template->assign('title', 'List Artworks');
        $template->assign('artworks', $artworks);
        $template->assign('artist_name', $artist['alias']);
        echo $template->render();
    }

    public function uploadArtwork(){
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
            $this->redirect($this->link('/artist/listArtists'));
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
            $this->redirect($this->link('/artist/listArtists'));
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
                    $this->redirect($this->link('/artist/listArtworks', ['artist_id' => $artist_values['id']]));
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "File is not an image.";
            }
        }

        $template = new TemplateEngine();
        $template->loadTemplate('uploadOperaPhoto');
        $template->assign('title', 'Upload Opera Photo');
        $template->assign('link', $this->link('/artwork/upload'));
        echo $template->render();
    }
}

?>