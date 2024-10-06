<?php
class CommentMovieModel extends BaseModel{

    const TABLE = "comments_movie";

    public function getAll($select = ['*']){
        return $this->all(self::TABLE, $select);
    }

    public function findbycondition($value = []){
        return $this->findwhere(self::TABLE, $value);
    }

    public function store($data){
        return $this->create(self::TABLE, $data);
    }
}
?>