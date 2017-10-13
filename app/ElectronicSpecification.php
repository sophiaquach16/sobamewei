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

    function __construct($data) {
        $this->set($data);
    }

    public function set($data) {
        $this->id = $data->id;
        $this->dimension = $data->dimension;
        $this->weight = $data->weight;
        $this->modelNumber = $data->modelNumber;
        $this->brandName = $data->brandName;
        $this->hdSize = $data->hdSize;
        $this->price = $data->price;
        $this->processorType = $data->processorType;
        $this->ramSize = $data->ramSize;
        $this->cpuCores = $data->cpuCores;
        $this->batteryInfo = $data->batteryInfo;
        $this->os = $data->os;
        $this->camera = $data->camera;
        $this->touchScreen = $data->touchScreen;
        $this->ElectronicType_id = $data->ElectronicType_id;
        $this->ElectronicType_name = $data->ElectronicType_name;
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

}
