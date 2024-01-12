<?php
class ArtistModel extends ORM {
    protected $table = 'artist';
    protected $primaryKey = 'id';

    protected $fields = [
        'id',
        'user_id',
        'alias',
        'contact_mail'
    ];

    public function get_artist_by_user_id($user_id){
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id";
        $data = [
            'user_id' => $user_id
        ];
        return $this->findOne($query, $data);
    }

    public function __construct() {
        parent::__construct($this->table);
    }
}