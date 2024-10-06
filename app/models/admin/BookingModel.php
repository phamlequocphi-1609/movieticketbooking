<?php
class BookingModel extends BaseModel{

    const TABLE = "booking";

    public function store($data){
        return $this->create(self::TABLE, $data);
    }

    public function findbycondition($value = []){
        return $this->findwhere(self::TABLE, $value);
    }

}
?>