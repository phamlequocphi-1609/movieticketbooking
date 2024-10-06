<?php
class BlogModel extends BaseModel{
    const TABLE = "blog";
    
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

    public function joinData($table2 = [], $onCondition = [], $select = ['*'], $where = []){
        return $this->join(self::TABLE,$table2, $select, $onCondition, $where);
    }

    public function orderData($select = ['*'], $orderby = [] , $limit = null){
        return $this->orderBy(self::TABLE, $select, $orderby, $limit);
    }

    public function getNextBlogId($select = ['*'], $condition = [] ,$orderby = [], $limit = null){
        return $this->max(self::TABLE,$select, $condition,$orderby, $limit );
    }

    public function previousBlogId($select = ['*'], $condition = [] ,$orderby = [], $limit = null){
        return $this->min(self::TABLE,$select, $condition,$orderby, $limit );
    }
    
}
?>