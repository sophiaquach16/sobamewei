<?php

namespace App;

class UserTDG {

    private $conn;

    public function __construct() {
        $this->conn = new \MySQLConnection();
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

    public function login($parameters) {

        $localConn = $this->conn->getPDOConnection();

        $localConn->prepare('SELECT id FROM User WHERE email = :email AND password = :password');

        $localConn->bindValue(':email', $parameters->email);
        $localConn->bindValue(':password', $parameters->password);

        $localConn->execute();

        if (count($localConn->fetchAll(PDO::FETCH_OBJ)) > 0) {
            return true;
        }

        return false;
    }

}
