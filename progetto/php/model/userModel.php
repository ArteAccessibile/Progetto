<?php
class UserModel extends ORM {
    protected $table = 'user';
    protected $primaryKey = 'id';

    protected $fields = [
        'id',
        'email',
        'password',
        'name',
        'surname'
    ];

    public function __construct() {
        parent::__construct($this->table);
    }

    public function findByEmail($email) {
        $query = "SELECT * FROM {$this->table} WHERE email = :email";
        $data = [
            'email' => strtolower($email)
        ];
        return $this->findOne($query, $data);
    }

    public function findByEmailAndPassword($email, $password) {
        $query = "SELECT * FROM {$this->table} WHERE email = :email AND password = :password";
        $data = [
            'email' => strtolower($email),
            'password' => hash('sha256', $password)
        ];
        return $this->findOne($query, $data);
    }
}