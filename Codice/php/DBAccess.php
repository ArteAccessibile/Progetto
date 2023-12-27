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
        $query = "SELECT titolo FROM opera"; // Selecting name of the opera from the 'opera' table
        $result = $this->connection->query($query);
    
        $operas = array();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = $row['titolo'];
                $file_path = "../../immagini/" . str_replace(" ", "", strtolower($name)) . ".jpg"; // Generating the file path based on the opera's name
                $operas[] = array('titolo' => $name, 'file_path' => $file_path); // Adding each opera's name and file path to the $operas array
            }
        }
    
        return $operas;
    }
    

    public function closeConnection() {
        $this->connection->close();
    }
}




?>