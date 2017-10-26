<?php

namespace App\Classes\TDG;

class UserCatalogTDG {

    private $conn;

    public function __construct() {
        $this->conn = new MySQLConnection();
    }

    /**
     *
     * @param type $parameters "Associative array with the SQL field and the wanted value. Ex: $parameter['id'] = 4; $parameter['email'] = 'admin@admin.com';
     */
    public function find($parameters) {

        $queryString = 'SELECT id, firstname, lastName, email, phone, admin,
                physicalAddress, password FROM User
                WHERE ';

        //For each key, (ex: id, email, etc.), we build the query
        foreach ($parameters as $key => $value) {

            $queryString .= $key . ' = :' . $key;
            $queryString .= ' AND ';
        }
        //We delete the last useless ' AND '
        $queryString = substr($queryString, 0, -5);

        //We send to MySQLConnection the associative array, to bind values to keys
        //Please mind that stdClass and associative arrays are not the same data structure, althought being both based on the big family of hashtables
        return $this->conn->query($queryString, $parameters);
    }

    public function findAll() {

        $queryString = 'SELECT * FROM User';

        $userDataList = $this->conn->directQuery($queryString);

        return $userDataList;
    }

    public function insertLoginLog($userId, $timestamp) {
        $parameters = new \stdClass();
        $parameters->User_id = $userId;
        $parameters->timestamp = $timestamp;

        $queryString = 'INSERT INTO LoginLog SET ';

        foreach ($parameters as $key => $value) {
            if ($value !== null) {
                $queryString .= $key . ' = :' . $key;
                $queryString .= ' , ';
            }
        }

        //We delete the last useless ' , '
        $queryString = substr($queryString, 0, -2);

        return $this->conn->query($queryString, $parameters);
    }

    public function login($parameters) {
        $localConn = $this->conn->getPDOConnection();

        $localConn->prepare('SELECT id FROM User WHERE email = :email AND password = :password');

        $localConn->bindValue(':email', $parameters->email);
        $localConn->bindValue(':password', $parameters->password);

        $localConn->execute();

        var_dump($localConn->fetchAll(PDO::FETCH_OBJ));
        if (count($localConn->fetchAll(PDO::FETCH_OBJ)) > 0) {
            return true;
        }

        return false;
    }

    public function add($parameter){
      $localConn = $this->conn->getPDOConnection();

      $localConn->prepare('INSERT INTO User ( firstName, lastName, email, password, phone, physicalAddress ) VALUES ( :firstName, :lastName, :email, :password, :phone, :physicalAddress)');


      $localConn->bindValue(':firstName', $parameters->firstName);
      $localConn->bindValue(':lastName', $parameters->lastName);
      $localConn->bindValue(':email', $parameters->email);
      $localConn->bindValue(':password', $parameters->password);
      $localConn->bindValue(':phone', $parameters->phone);
      $localConn->bindValue(':physicalAddress', $parameters->physicalAddress);

      $localConn->execute();

      // if (count($localConn->fetchAll(PDO::FETCH_OBJ)) > 0) {
      //     return true;
      // }
      //
      // return false;
    }


}
