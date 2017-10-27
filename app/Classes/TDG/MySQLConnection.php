<?php

namespace App\Classes\TDG;

use PDO;

class MySQLConnection {

    private $conn;

    public function __construct() {
        $this->conn = new PDO('mysql:host=localhost;dbname=conushop;charset=utf8', 'root', 'isY2metT');
    }

    public function query($query, $bindValues) {
        $localConn = $this->conn;




        $stmt = $localConn->prepare($query);

        //We bind the values to make sure we are protected from injections
        foreach ($bindValues as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $result;
        } catch (PDOException $e) {
            return false;

            die($e->getMessage());
        }
    }

    public function directQuery($query) {
        $localConn = $this->conn;

        $stmt = $localConn->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPDOConnection() {
        return $this->conn;
    }

}
