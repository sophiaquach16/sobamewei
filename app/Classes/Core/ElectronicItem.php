<?php

namespace App\Classes\Core;

class ElectronicItem {

    private $id;
    private $serialNumber;
    private $ElectronicSpecification_id;

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
    }

    function get() {
        $returnData = new \stdClass();

        $returnData->id = $this->id;
        $returnData->serialNumber = $this->serialNumber;
        $returnData->ElectronicSpecification_id = $this->ElectronicSpecification_id;

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

}
