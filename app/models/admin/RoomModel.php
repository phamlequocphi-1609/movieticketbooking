<?php
class RoomModel extends BaseModel{

    const TABLE = "room";

    public function getAll($select = ['*']){
        return $this->all(self::TABLE, $select);
    }

    public function store($data){
        $this->create(self::TABLE, $data);
    }

    public function deletData($id){
        $this->delete(self::TABLE, $id);
    }

    public function findById($id){
        return $this->find(self::TABLE, 'id', $id);
    }
    
    public function updateData($id, $data){
        return $this->update(self::TABLE, $id, $data);
    }
}
?>