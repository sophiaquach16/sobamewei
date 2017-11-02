<?php

namespace App\Classes\Core;

class ElectronicItem {

    private $id;
    private $serialNumber;
    private $ElectronicSpecification_id;
    private $User_id;
    private $expiryForUser;
    
    function __construct() {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 1:
                self::__construct1($argv[0]);
                break;
        }
    }

    function __construct1($data) {
        $this->set($data);
    }

    function set($data) {
        if (isset($data->serialNumber)) {
            $this->serialNumber = $data->serialNumber;
        }
        if (isset($data->id)) {
            $this->id = $data->id;
        }
        if (isset($data->ElectronicSpecification_id)) {
            $this->ElectronicSpecification_id = $data->ElectronicSpecification_id;
        }
        
        /*New Helen*/
        if (isset($data->User_id)){
            $this->User_id = $data->User_id;
        }
        
        if (isset($data->expiryForUser)){
            $this->expiryForUser= $data->expiryForUser;
        }
    }

    function get() {
        $returnData = new \stdClass();

        $returnData->id = $this->id;
        $returnData->serialNumber = $this->serialNumber;
        $returnData->ElectronicSpecification_id = $this->ElectronicSpecification_id;
        /*New Helen*/
        $returnData->User_id = $this->User_id;
        $returnData->expiryForUser= $this->expiryForUser;
        return $returnData;
    }
    
    function getId(){
        return $this->id;
    }

    function setSerialNumber($serialNumber) {
        $this->serialNumber = $serialNumber;
    }

    function getSerialNumber() {
        return $this->serialNumber;
    }
    function getElectronicSpecification_id() {
        return $this->ElectronicSpecification_id;
    }

    /* New method Helen*/
    function getUserId(){
        return $this->User_id;
    }
    
    function getExpiryForUser(){
        return $this->expiryForUser;
    }
    function setUserId($userId){
        $this->User_id=$userId;
    }
    
    function setExpiryForUser($expiry){
        $this->expiryForUser=$expiry;
    }
}
