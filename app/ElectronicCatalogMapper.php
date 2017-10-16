<?php

namespace App;

class ElectronicCatalogMapper {

    private $electronicCatalog;
    private $electronicCatalogTDG;

    function __construct() {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;
        }
    }

    function __construct0() {
        $electronicCatalogTDG = new ElectronicCatalogTDG();
        $this->electronicCatalogTDG = new ElectronicCatalogTDG();
        $this->electronicCatalog = new ElectronicCatalog($this->electronicCatalogTDG->findAll());
    }

    function makeNewElectronicSpecification($quantity, $electronicSpecificationData) {
        $modelNumberExists = $this->electronicCatalog->findElectronicSpecification($electronicSpecificationData->modelNumber);
        //$serialNumberPosition = $this->electronicCatalog->findSerialNumberPosition();

        if (!$modelNumberExists) {
            //Add to eSList of the catalog
            $this->electronicCatalog->makeElectronicSpecification($electronicSpecificationData);

            //Add to database
            $this->electronicCatalogTDG->insert($electronicSpecificationData);

            $serialNumber = $this->generateSerialNumber();
            for ($i = 1; $i <= $quantity; $i++) {
                $electronicItemData = new \stdClass();
                $electronicItemData->serialNumber = $serialNumber . $i;

                $this->electronicCatalog->makeElectronicItem($electronicSpecificationData->modelNumber, $electronicItemData);

                $this->electronicCatalogTDG->insertElectronicItem($electronicSpecificationData->modelNumber, $electronicItemData);
            }
            //dd($this->electronicCatalog->getESList());
            return true;
        } else {
            return false;
        }
    }

    function modifyElectronicSpecification($quantity, $eS, $eSData) {
        $eSId = $eS->id;
        // verify if the newly entered model number exists
        $newModelNumberExists = $this->electronicCatalog->findElectronicSpecification($eSData->modelNumber);

        if (!$newModelNumberExists || $this->electronicCatalog->getElectronicSpecificationById($eSId)->modelNumber === $eSData->modelNumber) {
            $this->electronicCatalog->modifyElectronicSpecification($eSId, $eSData);
            $this->electronicCatalogTDG->updateElectronicSpecification($eSId, $eSData);

            if (sizeOf($eS->electronicItems) === 0) {
                $serialNumber = $this->generateSerialNumber();
                for ($i = 1; $i <= $quantity; $i++) {
                    $electronicItemData = new \stdClass();
                    $electronicItemData->serialNumber = $serialNumber . $i;

                    $this->electronicCatalog->makeElectronicItem($eSData->modelNumber, $electronicItemData);

                    $this->electronicCatalogTDG->insertElectronicItem($eSData->modelNumber, $electronicItemData);
                }
            } else {
                for ($i = 1; $i <= $quantity; $i++) {
                    //dd(substr(end($eS->electronicItems)->serialNumber, 0, -1));
                    //$rest = substr("abcdef", 0, -1);  // returns "abcde"
                    $lastChar = substr(end($eS->electronicItems)->serialNumber, -1);
                    $serialNumber = substr(end($eS->electronicItems)->serialNumber, 0, -1);
                    //dd($serialNumber);

                    $electronicItemData = new \stdClass();
                    $electronicItemData->serialNumber = $serialNumber . ($lastChar + $i);

                    $this->electronicCatalog->makeElectronicItem($eSData->modelNumber, $electronicItemData);

                    $this->electronicCatalogTDG->insertElectronicItem($eSData->modelNumber, $electronicItemData);
                }
            }

            return true;
        } else {
            return false;
        }
    }

    function deleteElectronicItems($eIIds) {
        foreach ($eIIds as $eIId) {
            $this->electronicCatalog->deleteElectronicItem($eIId);

            $this->electronicCatalogTDG->deleteElectronicItem($eIId);
        }
    }

    private function generateSerialNumber() {
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $serialNumber = '';

        for ($i = 0; $i < 12; $i++) {
            $serialNumber .= $chars[rand(0, strlen($chars) - 1)];
        }

        return $serialNumber;
    }

    function getAllElectronicSpecifications() {
        //dd($this->electronicCatalog->getESList());
        $electronicSpecifications = $this->electronicCatalog->getESList();

        return $electronicSpecifications;
    }

    function getElectronicSpecification($id) {
        $electronicSpecification = $this->electronicCatalog->getElectronicSpecificationById($id);

        return $electronicSpecification;
    }

}
