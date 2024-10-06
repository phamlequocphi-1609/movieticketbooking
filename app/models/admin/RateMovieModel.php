<?php
class RateMovieModel extends BaseModel{

    const TABLE = "rate_movie";

    public function store($data){
        return $this->create(self::TABLE, $data);
    }

    public function findById($id){
        return $this->find(self::TABLE, 'id', $id);
    }

    
}
?>