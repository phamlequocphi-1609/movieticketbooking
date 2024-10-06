<?php
class CinemaModel extends BaseModel{
    const TABLE = 'cinemas';
    
    public function getAll($select = ['*'])
    {
        return $this->all(self::TABLE, $select);
    }
    public function store($data){
        $this->create(self::TABLE, $data);
    }
    public function deleteData($id){
        $this->delete(self::TABLE, $id);
    }
    public function findById($id){
        return $this->find(self::TABLE, 'id', $id);
    }
    public function updateData($id, $data){
        $this->update(self::TABLE, $id, $data);
    }
}
?>