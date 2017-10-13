<?php

namespace App;

use App\MySQLConnection;

class ElectronicSpecificationTDG {

    private $conn;

    public function __construct() {
        $this->conn = new MySQLConnection();
    }

    /**
     * 
     * @param type $parameters "Associative array with the SQL field and the wanted value. Ex: $parameter['id'] = 4; $parameter['modelNumber'] = 'NFDSGF767';
     */
    public function find($parameters) {

        $queryString = 'SELECT id, dimension, weight, modelNumber, brandName, hdSize, price, processorType, ramSize, cpuCores, batteryInfo, os, camera, touchScreen, Electronictype_id
            FROM Electronic
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

	public function getAll() {

        $queryString = 'SELECT * FROM Electronic LEFT JOIN ElectronicType ON ElectronicType.id = Electronic.ElectronicType_id';
		
        return $this->conn->directQuery($queryString);
    }

	public function add($parameters) {
		$queryString = 'INSERT INTO Electronic SET ';

        foreach ($parameters as $key => $value) {

            $queryString .= $key . ' = :' . $key;
            $queryString .= ' , ';
        }

        //We delete the last useless ' AND '
        $queryString = substr($queryString, 0, -2);
		
        return $this->conn->query($queryString, $parameters);
	}
}
