<?php

class Database{
    
    const servername = "localhost";
    const username = "root";
    const password = "";
    const database = "movieticketbook";
    
    public function connectDB(){
        $con = mysqli_connect(self::servername, self::username, self::password, self::database);
        mysqli_set_charset($con, 'utf8');
        if(mysqli_connect_errno() === 0){
            return $con;
        }
        return false;
    }   
}
?>