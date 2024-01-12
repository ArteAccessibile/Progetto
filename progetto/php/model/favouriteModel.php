<?php
class FavouriteModel extends ORM {
    protected $table = 'favourite';
    protected $primaryKey = 'id';

    protected $fields = [
        'id',
        'user_id',
        'artwork_id'
    ];

    public function __construct() {
        parent::__construct($this->table);
    }
}