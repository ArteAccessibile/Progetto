<?php

namespace DB;

use mysqli;
use Exception;

class DBAccess {
    
       private const HOST_DB = "localhost";
        private const DATABASE_NAME = "arte_accessibile";
        private const USERNAME = "root"; // da cambiare alla consegna
        private const PASSWORD = "";

        private $connection;

        public function openDBConnection(){
            $this -> connection = mysqli_connect(self::HOST_DB, self::USERNAME, self::PASSWORD, self::DATABASE_NAME);
            return mysqli_connect_errno()==0;
        }

        public function login($email,$password){
            //encrypt password
            $password = md5($password);
            $query = "SELECT * FROM `utente` WHERE `email` = '$email' AND `psw` = '$password'";
            return $this->connection->query($query);
        }

        public function getOperas() {
            $query = "SELECT id, titolo, desc_abbrev FROM opera"; 
            $result = $this->connection->query($query);
         
            $operas = array();
         
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $name = $row['titolo'];
                    $shortdesc = $row['desc_abbrev'];
                    $file_path = "../../immagini/" . str_replace(" ", "", strtolower($name)) . ".jpg"; // genera il percorso del file in base al nome dell'opera
                    $operas[] = array('id' => $id, 'titolo' => $name, 'file_path' => $file_path, 'desc_abbrev'=>$shortdesc); // aggiunge i dettagli dell'opera all'array $operas
                }
            }
         
            return $operas;
         }
         
    
         public function getOperaById($operaId) { //l'id è quello dell'artista
            $query = "SELECT * FROM opera WHERE id = ?"; 
            $statement = $this->connection->prepare($query);
            $statement->bind_param("i", $operaId); 
            $statement->execute();
            
            $result = $statement->get_result();
          
            if ($result->num_rows > 0) {
                $opera = $result->fetch_assoc(); 
                $name = $opera['titolo'];
                $file_path = "../../immagini/" . str_replace(" ", "", strtolower($name)) . ".jpg"; // genera il percorso del file in base al nome dell'opera
                $opera['file_path'] = $file_path; // aggiunge il percorso del file all'array $opera
            } else {
                $opera = null;
            }
          
            return $opera;
         }
         
     
         public function getArtists() {
            $query = "SELECT * FROM artista"; 
            $result = $this->connection->query($query);
           
            $artists = array();
           
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $artists[] = $row; // aggiungi righe a $artists 
                }
            }
           
            return $artists;
          }
          public function getArtistiPseudonimo() {
            $query = "SELECT pseudonimo FROM artista"; 
            $result = $this->connection->query($query);
           
            $artists = array();
           
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $artists[] = $row['pseudonimo']; 
                }
            }
           
            return $artists;
          }
          public function getArtistaPseudonimoByUser($value) {
            $query = "SELECT pseudonimo FROM artista WHERE utente = ?"; 
            $statement = $this->connection->prepare($query);
            $statement->bind_param("s",$value);// questo fa in modo che il parametro sia una stringa
            $statement->execute();
           
            $risultato = $statement->get_result();
            if($risultato->num_rows > 0){
                $row = $risultato->fetch_assoc();
                $pseudonimo = $row['pseudonimo'];
            }
            else{
                $pseudonimo = null;
            }
            
            return $pseudonimo;
          }
          public function getArtistaDescByUser($value) {
            $query = "SELECT descrizione FROM artista WHERE utente = ?"; 
            $statement = $this->connection->prepare($query);
            $statement->bind_param("s",$value);// questo fa in modo che il parametro sia una stringa
            $statement->execute();
           
            $risultato = $statement->get_result();
            if($risultato->num_rows > 0){
                $row = $risultato->fetch_assoc();
                $descrizione = $row['descrizione'];
            }
            else{
                $descrizione = null;
            }
            
            return $descrizione;
          }
          
          public function getArtistByUser($userEmail) {
            $query = "SELECT * FROM artista WHERE utente = ?"; 
            $statement = $this->connection->prepare($query);
            $statement->bind_param("s", $userEmail); 
            $statement->execute();
           
            $result = $statement->get_result();
           
            if ($result->num_rows > 0) {
                $artist = $result->fetch_assoc(); 
            } else {
                $artist = null;
            }
           
            return $artist;
          }
          
          public function getImagesByArtist($artistId) {
            $query = "SELECT titolo FROM opera WHERE artista = ? LIMIT 3"; 
            $statement = $this->connection->prepare($query);
            $statement->bind_param("s", $artistId); 
            $statement->execute();
            
            $result = $statement->get_result();
            
            $images = array();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $title = $row['titolo'];
                    $file_path = "../../immagini/" . str_replace(" ", "", strtolower($title)) . ".jpg"; 
                    $images[] = $file_path; 
                }
            }
            
            return $images;
         }
         

         public function deleteImageFromDatabase($artista, $nome) {
            $query = "DELETE FROM opera WHERE artista = ? AND titolo = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $artista, $nome);
            $stmt->execute();
            return $stmt;
        }
         public function getFavourites() {
            $query = "SELECT opera.id as opera, pseudonimo, titolo, desc_abbrev FROM opera,preferito,artista WHERE preferito.utente=\"".$_SESSION["email"]."\" AND preferito.opera=opera.id AND opera.artista=artista.utente"; 
            $result = $this->connection->query($query);
         
            $fav = array();
         
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $artista = $row['pseudonimo'];
                    $title = $row['titolo'];
                    $shortdesc = $row['desc_abbrev'];
                    $opera = $row['opera'];
                    $fav[] = array('artista' => $artista, 'titolo' => $title, 'desc_abbrev'=>$shortdesc, 'opera'=>$opera);
                }
            }
            return $fav;
         }
// funzione per pulire input form
         public function pulisciInput($value) {
            $value = trim($value); 
            $value = strip_tags($value); 
            $value = htmlentities($value);
            return $value;
        }
        
        public function checkOpera ($titolo, $artista){
            $titolo = $this->connection->real_escape_string($titolo);
            $artista = $this->connection->real_escape_string($artista);
        
            $query = "SELECT * FROM opera WHERE titolo = ? AND artista = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("ss", $titolo, $artista);
            $stmt->execute();
        
            $result = $stmt->get_result();
        
            if ($result->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        }
        
        public function aggiungiOpera($artista, $titolo, $desc_abbrev, $descrizione, $data_creazione) {
            $query = "INSERT INTO opera (artista, titolo, desc_abbrev, descrizione, data_creazione) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($query);
            if ($stmt === false) {
                // Handle error, prepare failed
                return false;
            }
        
            // 's' denota il tipo dei parametri passati: 's' string, 'i' integer, 'd'  double, 'b' for blob
            $bind = $stmt->bind_param("sssss", $artista, $titolo, $desc_abbrev, $descrizione, $data_creazione);
            if ($bind === false) {
                return false;
            }
        
            $execute = $stmt->execute();
            if ($execute === false) {
                return false;
            }
        
            $stmt->close();
            
            return true; 
        }

    
    public function isArtista($email){
        $query = "SELECT * FROM artista WHERE utente = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
    
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return true;
        } 

        return false;
    }

    public function becameArtist($utente, $desc, $pseudonimo, $email_contatto) {
        $query = "INSERT INTO artista (utente, descrizione, pseudonimo, email_contatto) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        if ($stmt === false) {
            return false;
        }
    
        $bind = $stmt->bind_param("ssss", $utente, $desc, $pseudonimo, $email_contatto);
        if ($bind === false) {
            return false;
        }
    
        $execute = $stmt->execute();
        if ($execute === false) {
            return false;
        }
    
        $stmt->close();
        
        return true; 
    }

    public function checkEmail($email) {
        $query = "SELECT * FROM utente WHERE email = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
    
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return false;
        } 

        return true;
    }

    public function registerUser($name, $surname, $email, $password, $role) {
        $password = md5($password);
        $query = "INSERT INTO utente (nome, cognome, email, psw, ruolo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        if ($stmt === false) {
            return false;
        }
    
        $bind = $stmt->bind_param("sssss", $name, $surname, $email, $password, $role);
        if ($bind === false) {
            return false;
        }
    
        $execute = $stmt->execute();
        if ($execute === false) {
            return false;
        }
    
        $stmt->close();
        
        return true; 
    }
  
    public function removeUserAccount($email){ 
        $query = "DELETE FROM utente WHERE email = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt;
        
    }


        
        public function aggiungiPreferiti($userId,$idOpera){
            $query = "INSERT INTO preferito (utente,opera) VALUES (?,?)";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("si",$userId,$idOpera);
            $stmt->execute();
            return $stmt;
        }

        public function checkPreferita($idOpera,$userId){
            $query = "SELECT * FROM preferito WHERE utente = ? AND opera = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("si",$userId,$idOpera);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                return true;
            }
            else{
                return false;
            }
        }
        
    public function removeFavourite($email,$idOpera){
        $query = "DELETE FROM preferito WHERE utente = ? AND opera = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ss",$email,$idOpera);
        $stmt->execute();
        return $stmt;
    }


    public function aggiornaDescrizione($userId, $descrizione) {
        $query = "UPDATE artista SET descrizione = ? WHERE utente = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ss", $descrizione, $userId);
        $stmt->execute();
        return $stmt;
    }

    public function closeConnection() {
        $this->connection->close();
    }

}
?>