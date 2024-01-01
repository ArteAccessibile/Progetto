<?php

namespace DB;


class DBAccess {
    private const HOST_DB = "localhost";
        private const DATABASE_NAME = "fgiacomuTest";
        private const USERNAME = "testUtente"; // da cambiare alla consegna
        private const PASSWORD = "password";

        private $connection;

        public function openDBConnection(){
            $this -> connection = mysqli_connect(self::HOST_DB, self::USERNAME, self::PASSWORD, self::DATABASE_NAME);
            return mysqli_connect_errno()==0;
        }

        public function getOperas() {
            $query = "SELECT id, titolo FROM opera"; // Selecting id and name of the opera from the 'opera' table
            $result = $this->connection->query($query);
         
            $operas = array();
         
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $name = $row['titolo'];
                    $file_path = "../../immagini/" . str_replace(" ", "", strtolower($name)) . ".jpg"; // Generating the file path based on the opera's name
                    $operas[] = array('id' => $id, 'titolo' => $name, 'file_path' => $file_path); // Adding each opera's id, name and file path to the $operas array
                }
            }
         
            return $operas;
         }
         
    
         public function getOperaById($operaId) {
            $query = "SELECT * FROM opera WHERE id = ?"; // Selecting all columns from the 'opera' table where the id matches the given id
            $statement = $this->connection->prepare($query);
            $statement->bind_param("i", $operaId); // Binding the id parameter to the query
            $statement->execute();
            
            $result = $statement->get_result();
          
            if ($result->num_rows > 0) {
                $opera = $result->fetch_assoc(); // Fetching the opera details as an associative array
                $name = $opera['titolo'];
                $file_path = "../../immagini/" . str_replace(" ", "", strtolower($name)) . ".jpg"; // Generating the file path based on the opera's name
                $opera['file_path'] = $file_path; // Adding the file path to the $opera array
            } else {
                $opera = null;
            }
          
            return $opera;
         }
         
     
         public function getArtists() {
            $query = "SELECT * FROM artista"; // Selecting all columns from the 'artista' table
            $result = $this->connection->query($query);
           
            $artists = array();
           
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $artists[] = $row; // Adding each artist's details to the $artists array
                }
            }
           
            return $artists;
          }
          
          public function getArtistByUser($userEmail) {
            $query = "SELECT * FROM artista WHERE utente = ?"; // Selecting all columns from the 'artista' table where the user email matches the given email
            $statement = $this->connection->prepare($query);
            $statement->bind_param("s", $userEmail); // Binding the user email parameter to the query
            $statement->execute();
           
            $result = $statement->get_result();
           
            if ($result->num_rows > 0) {
                $artist = $result->fetch_assoc(); // Fetching the artist details as an associative array
            } else {
                $artist = null;
            }
           
            return $artist;
          }
          
         
     
    public function closeConnection() {
        $this->connection->close();
    }
}




?>