<?php
class GenderModel extends BaseModel{
    const TABLE = "gender";
    public function getAll($select = ['*']){
        return $this->all(self::TABLE, $select);
    }

    public function store($data){
        $this->create(self::TABLE, $data);
    }


    
}




?>