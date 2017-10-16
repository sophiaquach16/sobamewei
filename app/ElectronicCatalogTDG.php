<?php

namespace App;

class ElectronicCatalogTDG {

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
            FROM ElectronicSpecification
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

        //$queryString = 'SELECT * FROM ElectronicSpecification JOIN ElectronicType ON ElectronicType.id = ElectronicSpecification.ElectronicType_id JOIN ElectronicItem ON ElectronicSpecification.id = ElectronicItem.ElectronicSpecification_id';
        $queryString = 'SELECT * FROM ElectronicSpecification';

        $eSDataList = $this->conn->directQuery($queryString);

        //dd($eSDataList);

        foreach ($eSDataList as &$eSData) {
            //dd($eSData);

            $queryString = 'SELECT *
            FROM ElectronicItem
            WHERE ';

            $parameters = array('ElectronicSpecification_id' => $eSData->id);

            //For each key, (ex: id, email, etc.), we build the query
            foreach ($parameters as $key => $value) {
                $queryString .= $key . ' = :' . $key;
                $queryString .= ' AND ';
            }
            //We delete the last useless ' AND '
            $queryString = substr($queryString, 0, -5);

            //We send to MySQLConnection the associative array, to bind values to keys
            //Please mind that stdClass and associative arrays are not the same data structure, althought being both based on the big family of hashtables
            $eIDataList = $this->conn->query($queryString, $parameters);
            //dd($eIDataList);
            $eSData->electronicItems = $eIDataList;
        }

        return $eSDataList;
        //dd($eSDataList);
    }

    public function insert($parameters) {
        $queryString = 'INSERT INTO ElectronicSpecification SET ';

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

    public function deleteElectronicItem($id) {
        $queryString = 'DELETE FROM ElectronicItem WHERE ';

        $queryString .= 'id' . ' = :' . 'id';
        
        $parameters = new \stdClass();
        $parameters->id = $id;

        return $this->conn->query($queryString, $parameters);
    }
    
    public function updateElectronicSpecification($id, $parameters) {
        $queryString = 'UPDATE ElectronicSpecification SET ';
        
        foreach ($parameters as $key => $value) {
            if ($value !== null) {
                $queryString .= $key . ' = :' . $key;
                $queryString .= ' , ';
            }
        }

        //We delete the last useless ' , '
        $queryString = substr($queryString, 0, -2);
        
        $queryString .= ' WHERE id = :id';
        $parameters->id = $id;

        return $this->conn->query($queryString, $parameters);
    }

    public function insertElectronicItem($modelNumber, $parameters) {
        $queryString = 'SELECT * FROM ElectronicSpecification';

        $electronicSpecifications = $this->conn->directQuery($queryString);

        $electronicSpecificationId = -1;
        foreach ($electronicSpecifications as $electronicSpecification) {
            //var_dump($electronicSpecification->modelNumber);
            if ($electronicSpecification->modelNumber === $modelNumber) {
                $electronicSpecificationId = $electronicSpecification->id;
            }
        }

        $parameters->ElectronicSpecification_id = $electronicSpecificationId;

        $queryString = 'INSERT INTO ElectronicItem SET ';

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

}
