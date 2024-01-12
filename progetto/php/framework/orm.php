<?php
class ORM {
    protected $pdo;
    protected $table;
    protected $fields = [];
    protected $primaryKey = 'id';

    public function __construct($table) {
        $this->pdo = new PDO('mysql:host=127.0.0.1;dbname=arte', 'root', '');
        $this->table = $table;
    }

    public function findOne($query, $data){
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);
        $values = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($values)){
            return null;
        }

        return $values;
    }

    public function find($query, $data){
        // return an array with multiple lines
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($values)){
            return null;
        }
        return $values;
    }

    public function findById($id) {
        return $this->findOne("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id", ['id' => $id]);
    }

    public function findAll() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $stmt->execute(['id' => $id]);
    }

    public function save() {
        // foreach field in fields set $data[field] = $this->field
        $data = [];
        foreach ($this->fields as $field) {
            if (isset($this->$field)){
                $data[$field] = $this->$field;
            }
        }

        if (isset($data[$this->primaryKey]) && $data[$this->primaryKey]) {
            return $this->update($data);
        } else {
            return $this->insert($data);
        }
    }

    private function insert($data) {
        $keys = array_keys($data);
        $query = "INSERT INTO {$this->table} (" . implode(', ', $keys) . ") VALUES (:" . implode(', :', $keys) . ")";
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($data);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            die("Errore on query execution: " . $e->getMessage());
        }
    }

    private function update($data) {
        $keys = array_keys($data);
        $fields = array_map(function($key) {
            return "$key = :$key";
        }, $keys);

        $query = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE {$this->primaryKey} = :" . $this->primaryKey;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);
        return $data[$this->primaryKey];
    }
}
?>