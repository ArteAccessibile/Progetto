<?php
class DBAccess {
    private $connection;

    public function __construct($host, $username, $password, $database) {
        $this->connection = new mysqli($host, $username, $password, $database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getOperas() {
        $query = "SELECT titolo FROM opera"; // Selecting name of the opera from the 'opera' table
        $result = $this->connection->query($query);
    
        $operas = array();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = $row['titolo'];
                $file_path = "immagini/" . str_replace(" ", "_", strtolower($name)) . ".jpg"; // Generating the file path based on the opera's name
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