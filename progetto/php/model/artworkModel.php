<?php

require_once '../framework/orm.php';

class ArtworkModel extends ORM {
    protected $table = 'artwork';
    protected $primaryKey = 'id';

    protected $fields = [
        'id',
        'artist_id',
        'title',
        'short_description',
        'description',
        'creation_date',
        'image'
    ];

    
    public function get_artwork_by_artist_id($artist_id){
        $query = "SELECT * FROM {$this->table} WHERE artist_id = :artist_id";
        $data = [
            'artist_id' => $artist_id
        ];
        return $this->find($query, $data);
    }
    public function get_all_artworks(){
        $query = "SELECT * FROM {$this->table}";
        return $this->find($query, []);
      }
      

    public function __construct() {
        parent::__construct($this->table);
    }
}