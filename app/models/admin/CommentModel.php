<?php
class CommentModel extends BaseModel{

    const TABLE = "comments";

    public function findbycondition($value = []){
        return $this->findwhere(self::TABLE, $value);
    }

    public function store($data){
        return $this->create(self::TABLE, $data);
    }
}
?>