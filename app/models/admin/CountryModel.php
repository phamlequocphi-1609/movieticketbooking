<?php
class CountryModel extends BaseModel{
    const TABLE = "country";
    public function getAll($select = ['*']){
        return $this->all(self::TABLE, $select);
    }
    public function store($data){
        $this->create(self::TABLE, $data);
    }
    public function deleteData($id){
        $this->delete(self::TABLE, $id);
    }
}
?>