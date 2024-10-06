<?php
class BaseModel extends Database{

    protected $con;

    public function __construct()
    {
        $this->con = $this->connectDB();
    }

    public function all($table, $select = ['*']){
        $column = implode(',', $select);
        $sql = "SELECT $column FROM $table";
        $query = $this->query($sql);
        $data = [];
        while($row = mysqli_fetch_assoc($query)){
            array_push($data, $row);
        }
        return $data;
    }

    public function find($table, $condition , $value){
        $sql = "SELECT * FROM $table WHERE $condition = '$value'";
        $query = $this->query($sql);
        return mysqli_fetch_assoc($query);
    }

    public function findwhere($table, $value = []){
        $condition = [];
        foreach($value as $key => $val){
            array_push($condition, "$key = '".$val. "'");
        }
        if(count($condition) > 0 ){
            $conditionWhere = implode(" AND ", $condition);
        }else{
            $conditionWhere = implode('', $condition);
        }
        $sql = "SELECT * FROM $table WHERE $conditionWhere";
        $query  = $this->query($sql);
        $data = [];
        while($row = mysqli_fetch_assoc($query)){
            array_push($data, $row);
        }
        return $data;      
    }

    public function findLike($table, $select = ['*'] ,$like = []){
        $column = implode(',' , $select);
        $likeCondition = [];
        foreach($like as $key => $value){
            array_push($likeCondition, "$key LIKE '"."%".$value."%"."'");            
        }
        $likeWhere = implode(" AND ", $likeCondition);
        $sql = "SELECT $column FROM $table WHERE $likeWhere";
        $query = $this->query($sql);
        $data = [];
        while($row = mysqli_fetch_assoc($query)){
            array_push($data, $row);
        }
        return $data;
    }

    public function create($table, $data = []){
        $column = implode(',', array_keys($data));
        $value = array_map(function($value){
            return "'" . $value . "'";
        }, array_values($data));
        $newValue = implode(',', $value);
        $sql = "INSERT INTO $table($column) VALUES ($newValue)";
        return $this->query($sql);

    }

    public function update($table, $id, $data){
        $datas = [];
        foreach($data as $key=>$value){
            array_push($datas, "$key = '".$value."'");
        }
        $dataUpdate = implode(',', $datas);
        $sql = "UPDATE $table SET $dataUpdate WHERE id = $id";
        $this->query($sql);
    }

    public function delete($table, $id){
        $sql = "DELETE FROM $table WHERE id = $id";
        $this->query($sql);
    }

    public function join($table , $tablesToJoin, $select = ['*'], $condition , $where, $orderby = []){ 
        $orderString = implode(" ", $orderby);
        $column = implode(', ', $select); 
        $conditions = [];
        foreach($condition as $key => $value){
            array_push($conditions, "$key = $value");
        }
        $join = array_combine($tablesToJoin, $conditions);         
        $joinCondition = [];
        foreach($join as $key => $value){
            $joinCondition[] = "LEFT JOIN $key ON $value";
        }
        $whereCondition = [];
        foreach($where as $key => $value){
            array_push($whereCondition, "$key $value");
        }
        $whereString = implode(' AND ', $whereCondition);
        $joinCondition = implode(' ', $joinCondition);
        if($where){
            $sql = "SELECT $column FROM $table $joinCondition WHERE $whereString ORDER BY $orderString ";
        }else{
            $sql  = "SELECT $column FROM $table $joinCondition"; 
        }
        $query = $this->query($sql);
        $data = [];
        while($row = mysqli_fetch_assoc($query)){
            array_push($data, $row);
        }       
        return $data;
    }

   

    public function orderBy($table, $select = ['*'], $order, $limit){
        $column = implode(',', $select);
        $orderString = implode(' ', $order);
        if($limit != null){
            $sql = "SELECT DISTINCT $column FROM $table ORDER BY $orderString LIMIT $limit";
        }else{
            $sql = "SELECT DISTINCT $column FROM $table ORDER BY $orderString";
        }
        $query = $this->query($sql);
        $data = [];
        while($row = mysqli_fetch_assoc($query)){
            array_push($data, $row);
        }     
        return $data;      
    }

    public function max($table, $select = ['*'], $condition, $orderby, $limit){
        $column = implode(',', $select);
        $conditions = [];
        foreach($condition as $key => $value){
            array_push($conditions, "$key > $value");
        }
        $max = implode(' ', $conditions);
        $orderString = implode(' ', $orderby);
        $sql = "SELECT $column FROM $table WHERE $max ORDER BY $orderString LIMIT $limit";
        $query = $this->query($sql);
        $data = [];
        while($row = mysqli_fetch_assoc($query)){
            array_push($data, $row);
        }         
        return isset($data[0]) ? $data[0]['id'] : null;  
    }
    
    public function min($table, $select = ['*'], $condition, $orderby, $limit){
        $column = implode(',', $select);
        $conditions = [];
        foreach($condition as $key => $value){
            array_push($conditions, "$key < $value");
        }
        $min = implode(' ', $conditions);
        $orderString = implode(' ', $orderby);
        $sql = "SELECT $column FROM $table WHERE $min ORDER BY $orderString LIMIT $limit";
        $query = $this->query($sql);
        $data = [];
        while($row = mysqli_fetch_assoc($query)){
            array_push($data, $row);
        }
        if(isset($data[0])){
            return $data[0]['id'];
        }else{
            return null;
        }
    }

    private function query($sql){
        return mysqli_query($this->con, $sql);
    }
}
?>