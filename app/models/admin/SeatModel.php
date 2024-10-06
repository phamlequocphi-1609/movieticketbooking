<?php
class SeatModel extends BaseModel{
    const TABLE = "seat";

    public function store($data){
        $this->create(self::TABLE, $data);
    }

    public function getAll($select = ['*']){
        return $this->all(self::TABLE, $select);
    }

    public function findById($id){
        return $this->find(self::TABLE, 'id', $id);
    }

    public function updateData($id, $data){
        $this->update(self::TABLE, $id, $data);
    }

    public function deleteData($id){
        $this->delete(self::TABLE, $id);
    }

    public function joinData($tableJoin = [], $condition = [], $select = ['*'], $where = [], $order = []){
        return $this->join(self::TABLE, $tableJoin, $select, $condition, $where, $order);
    }

}



?>