<?php

class DBAccess {
    private $connection;

    public function __construct($host, $username, $password, $database) {
        $this->connection = new mysqli($host, $username, $password, $database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getFiles() {
        $query = "SELECT * FROM files";
        $result = $this->connection->query($query);

        $files = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $files[] = $row;
            }
        }

        return $files;
    }

    public function closeConnection() {
        $this->connection->close();
    }
}


?>