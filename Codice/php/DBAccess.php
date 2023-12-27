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
         
     
    
     
    public function closeConnection() {
        $this->connection->close();
    }
}




?>