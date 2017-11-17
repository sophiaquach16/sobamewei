<?php

namespace App\Classes\TDG;

use PDO;

class MySQLConnection {

    private $conn;

    public function __construct() {
        $connectionString =
          'mysql:host='.env('DB_HOST').';dbname='.env('DB_DATABASE').';charset=utf8';
        $this->conn = new PDO(
          $connectionString,
          env('DB_USERNAME'),
          env('DB_PASSWORD')
        );
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
//var_dump($stmt);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPDOConnection() {
        return $this->conn;
    }

}
