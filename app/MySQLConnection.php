<?php

class MySQLConnection {

    private $conn;

    public function __construct() {
        $this->conn = new PDO('mysql:host=localhost;dbname=conushop;charset=utf8', 'root', 'isY2metT');
    }

    public function query($query, $bindValues) {
        $localConn = $this->conn;

        $localConn->prepare($query);
        
        //We bind the values to make sure we are protected from injections
        foreach ($bindValues as $key => $value) {
            $localConn->bindValue(':' . $key, $value);
        }
        
        $result = $localConn->execute();
        
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function getPDOConnection(){
        return $this->conn;
    }

}
