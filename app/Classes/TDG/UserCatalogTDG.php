<?php

namespace App\Classes\TDG;

use Hash;

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

    public function login($email, $password) {
        $parameters = new \stdClass();
        $parameters->email = $email;

        $queryString = 'SELECT * FROM User WHERE ';

        //For each key, (ex: id, email, etc.), we build the query
        foreach ($parameters as $key => $value) {

            $queryString .= $key . ' = :' . $key;
            $queryString .= ' AND ';
        }
        //We delete the last useless ' AND '
        $queryString = substr($queryString, 0, -5);

        //We send to MySQLConnection the associative array, to bind values to keys
        //Please mind that stdClass and associative arrays are not the same data structure, althought being both based on the big family of hashtables
        $array = $this->conn->query($queryString, $parameters);

        if (count($array) > 0 && Hash::check($password, $array[0]->password)) {
            return true;
        } else {
            return false;
        }
    }

    public function add($user) {

        $objectData = (array) ( $user->get());

        foreach ($objectData as $key => $value) {
            if (is_array($objectData[$key]) || is_null($objectData[$key])) {
                unset($objectData[$key]);
            }
        }

        $parameters = (object) $objectData;

        $queryString = 'INSERT INTO User SET ';


        foreach ((array) $parameters as $key => $value) {
            $queryString .= $key . ' = :' . $key;
            $queryString .= ' , ';
        }

        //We delete the last useless ' , '
        $queryString = substr($queryString, 0, -2);


        return $this->conn->query($queryString, $parameters);
    }

    public function deleteUser($user){

        $queryString = 'DELETE FROM User WHERE ';
        $queryString .= 'id' . ' = :' . 'id';

        $parameters = new \stdClass();
        $parameters->id = $user->get()->id;

        return $this->conn->query($queryString, $parameters);

    }

    public function deleteLoginLog($userId) {

          $queryString = 'DELETE FROM LoginLog WHERE ';
          $queryString .= 'User_id' . ' = :' . 'User_id';

          $parameters = new \stdClass();
          $parameters->User_id = $userId;

          return $this->conn->query($queryString, $parameters);
    }

    public function deleteUserTransaction($userId){
        $queryString = 'DELETE FROM Transaction WHERE ';
        $queryString .= 'customer_id' . ' = :' . 'customer_id';

        $parameters = new \stdClass();
        $parameters->customer_id = $userId;

        return $this->conn->query($queryString, $parameters);
    }

    public function unsetUserEI($userId){

        $queryString = 'SELECT * FROM ElectronicItem';
        $eis = $this->conn->directQuery($queryString);

        foreach ($eis as $ei) {
            if ($ei->User_id === $userId) {
                $parameters = new \stdClass();
                $parameters->User_id = null;
                $parameters->expiryForUser = "0000-00-00 00:00:00";

                $queryString = 'UPDATE ElectronicItem SET ';
                $queryString .= 'User_id' . ' = :' . 'User_id';
                $queryString .= ' , ';
                $queryString .= 'expiryForUser' . ' = :' . 'expiryForUser';

                $this->conn->query($queryString, $parameters);
            }
        }


    }

}
