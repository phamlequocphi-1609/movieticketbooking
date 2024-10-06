<?php
class SeatTypeModel extends BaseModel{
    const TABLE = "seat_type";
    public function store($data){
        $this->create(self::TABLE, $data);
    }
    public function getAll($select = ['*']){
        return $this->all(self::TABLE, $select);
    }
    public function deleteData($id){
        $this->delete(self::TABLE, $id);
    }
}


?>