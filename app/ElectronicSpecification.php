<?php

namespace App;

class ElectronicSpecification {

    private $id;
    private $dimension;
    private $weight;
    private $modelNumber;
    private $brandName;
    private $hdSize;
    private $price;
    private $processorType;
    private $ramSize;
    private $cpuCores;
    private $batteryInfo;
    private $os;
    private $camera;
    private $touchScreen;
    private $ElectronicType_id;
    private $ElectronicType_name;
    private $ElectronicType_dimensionUnit;


  function __construct() {
        $argv = func_get_args();
        switch( func_num_args() ) {
            case 1:
                self::__construct1($argv[0]);
                break;
         }
    }

    function __construct1($data) {
        $this->set($data);
    }

    public function set($data) {
      //mettre isset pour
        if(isset($data->id))
        $this->id = $data->id;
        if(isset($data->dimension))
        $this->dimension = $data->dimension;
        if(isset($data->weight))
        $this->weight = $data->weight;
        if(isset($data->modelNumber))
        $this->modelNumber = $data->modelNumber;
        if(isset($data->brandName))
        $this->brandName = $data->brandName;
        if(isset($data->hdSize))
        $this->hdSize = $data->hdSize;
        if(isset($data->price))
        $this->price = $data->price;
        if(isset($data->processorType))
        $this->processorType = $data->processorType;
        if(isset($data->ramSize))
        $this->ramSize = $data->ramSize;
        if(isset($data->cpuCores))
        $this->cpuCores = $data->cpuCores;
        if(isset($data->batteryInfo))
        $this->batteryInfo = $data->batteryInfo;
        if(isset($data->os))
        $this->os = $data->os;
        if(isset($data->camera))
        $this->camera = $data->camera;
        if(isset($data->touchScreen))
        $this->touchScreen = $data->touchScreen;
        if(isset($data->ElectronicType_id))
        $this->ElectronicType_id = $data->ElectronicType_id;
        if(isset($data->ElectronicType_name))
        $this->ElectronicType_name = $data->ElectronicType_name;
        if(isset($data->ElectronicType_dimensionUnit))
        $this->ElectronicType_dimensionUnit = $data->ElectronicType_dimensionUnit;
    }

    public function get() {
        $returnData = new \stdClass();

        $returnData->id = $this->id;
        $returnData->dimension = $this->dimension;
        $returnData->weight = $this->weight;
        $returnData->modelNumber = $this->modelNumber;
        $returnData->brandName = $this->brandName;
        $returnData->hdSize = $this->hdSize;
        $returnData->price = $this->price;
        $returnData->processorType = $this->processorType;
        $returnData->ramSize = $this->ramSize;
        $returnData->cpuCores = $this->cpuCores;
        $returnData->batteryInfo = $this->batteryInfo;
        $returnData->os = $this->os;
        $returnData->camera = $this->camera;
        $returnData->touchScreen = $this->touchScreen;
        $returnData->ElectronicType_id = $this->ElectronicType_id;
        $returnData->ElectronicType_name = $this->ElectronicType_name;
        $returnData->ElectronicType_dimensionUnit = $this->ElectronicType_dimensionUnit;

        return $returnData;
    }

    public function getModelNumber() {
      return $this->modelNumber;
    }

}
