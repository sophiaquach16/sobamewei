<?php

namespace App\Classes\Core;

class ElectronicSpecification  {

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
    private $displaySize;
    private $ElectronicType_id;
    private $ElectronicType_name;
    private $ElectronicType_dimensionUnit;
    private $ElectronicType_displaySizeUnit;
    private $image;
    private $electronicItems;

    function __construct() {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;
            case 1:
                self::__construct1($argv[0]);
                break;
        }
    }

    function __construct0() {
        $this->electronicItems = array();
    }

    function __construct1($data) {
        $this->electronicItems = array();
        $this->set($data);
    }

    public function addElectronicItem($electronicItemData) {
        $electronicItem = new ElectronicItem($electronicItemData);

        array_push($this->electronicItems, $electronicItem);

        return $electronicItem;
    }

    public function deleteElectronicItem($id) {
        foreach ($this->electronicItems as $key => $value) {
            if ($id === $this->electronicItems[$key]->getId()) {
                unset($this->electronicItems[$key]);
            }
        }
    }

    public function set($data) {
        //mettre isset pour
        if (isset($data->id)) {
            $this->id = $data->id;
        }
        if (isset($data->dimension)) {
            $this->dimension = $data->dimension;
        }
        if (isset($data->weight)) {
            $this->weight = $data->weight;
        }
        if (isset($data->modelNumber)) {
            $this->modelNumber = $data->modelNumber;
        }
        if (isset($data->brandName)) {
            $this->brandName = $data->brandName;
        }
        if (isset($data->hdSize)) {
            $this->hdSize = $data->hdSize;
        }
        if (isset($data->price)) {
            $this->price = $data->price;
        }
        if (isset($data->processorType)) {
            $this->processorType = $data->processorType;
        }
        if (isset($data->ramSize)) {
            $this->ramSize = $data->ramSize;
        }
        if (isset($data->cpuCores)) {
            $this->cpuCores = $data->cpuCores;
        }
        if (isset($data->batteryInfo)) {
            $this->batteryInfo = $data->batteryInfo;
        }
        if (isset($data->os)) {
            $this->os = $data->os;
        }
        if (isset($data->camera)) {
            $this->camera = $data->camera;
        }
        if (isset($data->touchScreen)) {
            $this->touchScreen = $data->touchScreen;
        }
        if (isset($data->displaySize)) {
            $this->displaySize = $data->displaySize;
        }
        if (isset($data->image)) {
            $this->image = $data->image;
        }

        if (isset($data->electronicItems)) {
            //must delete current list of items, otherwise
            //the modifyElectronicSpecification will add the existing items again
            //even if you haven't modified their values
            foreach ($this->electronicItems as $electronicItemIndex => $singleItem) {
                $this->deleteElectronicItem($this->electronicItems[$electronicItemIndex]->getId());
            }
            foreach ($data->electronicItems as $key => $value) {
                $this->addElectronicItem($data->electronicItems[$key]);
            }
        }

        if (isset($data->ElectronicType_id)) {
            $this->ElectronicType_id = $data->ElectronicType_id;
            switch ($data->ElectronicType_id) {
                case 1:
                    $this->ElectronicType_name = 'Desktop';
                    $this->ElectronicType_displaySizeUnit = 'inch';
                    break;
                case 2:
                    $this->ElectronicType_name = 'Laptop';
                    $this->ElectronicType_displaySizeUnit = 'inch';
                    break;
                case 3:
                    $this->ElectronicType_name = 'Monitor';
                    $this->ElectronicType_displaySizeUnit = 'inch';
                    break;
                case 4:
                    $this->ElectronicType_name = 'Tablet';
                    $this->ElectronicType_displaySizeUnit = 'inch';
                    break;
            }
        }
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
        $returnData->displaySize = $this->displaySize;
        $returnData->ElectronicType_id = $this->ElectronicType_id;
        $returnData->ElectronicType_name = $this->ElectronicType_name;
        $returnData->ElectronicType_dimensionUnit = $this->ElectronicType_dimensionUnit;
        $returnData->ElectronicType_displaySizeUnit = $this->ElectronicType_displaySizeUnit;
        $returnData->image = $this->image;

        $electronicItemsData = array();
        foreach ($this->electronicItems as $electronicItem) {
            array_push($electronicItemsData, $electronicItem->get());
        }

        $returnData->electronicItems = $electronicItemsData;

        return $returnData;
    }

    public function getElectronicItems() {
        return $this->electronicItems;
    }

    public function getModelNumber() {
        return $this->modelNumber;
    }

    public function getId() {
        return $this->id;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getImage() {
        return $this->image;
    }


    public function reserveFirstAvailableEI($userId, $expiry) {
        $eI = $this->findNextAvailableEI();

        if($eI!=null){
        $eI->setUserId($userId);
        $eI->setExpiryForUser($expiry);
        }


        return $eI;
    }

    /**
     * Helper function to find next available EI of the electronic specification
     *
     * return type
     */
    private function &findNextAvailableEI() {
        foreach ($this->electronicItems as &$eI) {
            if (($eI->getExpiryForUser() === null) || ($eI->getUserId() === null) || (strtotime($eI->getExpiryForUser()) < strtotime(date("Y-m-d H:i:s")))) {
                return $eI;
            }
        }

        $result = null;

        return $result;
    }

    public function unsetUserAndExpiry($userId){
        $eIToRemove = null;

        foreach ($this->electronicItems as $eI){
            if($eI->getUserId() == $userId) {
                $eIToRemove = $eI;
                break;
            }
        }

        $eIToRemove->setUserId("null");
        $eIToRemove->setExpiryForUser(null);
        return $eIToRemove;
    }
}
