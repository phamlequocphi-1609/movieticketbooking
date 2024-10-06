<?php
class UserModel extends BaseModel{
    const TABLE = "users";

    public function findData($value){
        return $this->find(self::TABLE, 'email', $value);
    }
    
    public function store($data){
        return $this->create(self::TABLE, $data);
    }

    public function updateData($id, $data){
        $this->update(self::TABLE, $id, $data );
    }

    public function findById($id){
        return $this->find(self::TABLE, 'id', $id);
    }

    public function findbycondition($value = []){
        return $this->findwhere(self::TABLE, $value);
    }

    public function deleteData($id){
        $this->delete(self::TABLE, $id);
    }

}
?>