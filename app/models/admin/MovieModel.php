<?php
class MovieModel extends BaseModel{

    const TABLE = "movies";

    public function store($data){
        $this->create(self::TABLE, $data);
    }

    public function getAll($select = ['*']){
        return $this->all(self::TABLE, $select);
    }

    public function deleteData($id){
        $this->delete(self::TABLE, $id);
    }

    public function updateData($id, $data){
        return $this->update(self::TABLE, $id, $data);
    }
    
    public function findById($id){
        return $this->find(self::TABLE, 'id', $id);
    }

    public function joinData($tableJoin = [], $condition = [], $select = ['*'], $where = []){
        return $this->join(self::TABLE, $tableJoin, $select, $condition, $where);
    }

    public function findByLike($select = ['*'] ,$like = []){
        return $this->findLike(self::TABLE,$select, $like);
    }
}
?>