<?php

namespace App\Classes\Mappers;

use App\Classes\TDG\ElectronicCatalogTDG;
use App\Classes\Core\ElectronicCatalog;
use App\Classes\UnitOfWork;

class ElectronicCatalogMapper {

    private $electronicCatalog;
    private $electronicCatalogTDG;
    private $unitOfWork;

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
        $this->unitOfWork = new UnitOfWork($this);
    }

    function saveES($electronicSpecification) {
        return $this->electronicCatalogTDG->insertElectronicSpecification($electronicSpecification);
    }

    function updateES($electronicSpecification) {
        return $this->electronicCatalogTDG->updateElectronicSpecification($electronicSpecification);
    }

    function deleteEI($electronicItem) {
        return $this->electronicCatalogTDG->deleteElectronicItem($electronicItem);
    }

    function makeNewElectronicSpecification($quantity, $electronicSpecificationData) {
        $modelNumberExists = $this->electronicCatalog->findElectronicSpecification($electronicSpecificationData->modelNumber);
        //dd('1');
        if (!$modelNumberExists) {
            //Add to eSList of the catalog
            $electronicSpecification = $this->electronicCatalog->makeElectronicSpecification($electronicSpecificationData);
            //dd('2');
            //Add to database
            $this->unitOfWork->registerNew($electronicSpecification);
            $this->unitOfWork->commit();
            //dd('3');
            $serialNumber = $this->generateSerialNumber();
            for ($i = 1; $i <= $quantity; $i++) {
                $electronicItemData = new \stdClass();
                $electronicItemData->serialNumber = $serialNumber . $i;
                //dd('4');
                $this->electronicCatalog->makeElectronicItem($electronicSpecificationData->modelNumber, $electronicItemData);
                //dd('5');
                $this->electronicCatalogTDG->insertElectronicItem($electronicSpecificationData->modelNumber, $electronicItemData);
                //dd('6');
            }
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
            $electronicSpecification = $this->electronicCatalog->modifyElectronicSpecification($eSId, $eSData);

            $this->unitOfWork->registerDirty($electronicSpecification);
            $this->unitOfWork->commit();

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
                    $lastChar = substr(end($eS->electronicItems)->serialNumber, -1);
                    $serialNumber = substr(end($eS->electronicItems)->serialNumber, 0, -1);

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
            $electronicItem = $this->electronicCatalog->deleteElectronicItem($eIId);

            $this->unitOfWork->registerDeleted($electronicItem);
        }
        $this->unitOfWork->commit();
    }

    function getAllElectronicSpecifications() {
        $electronicSpecifications = $this->electronicCatalog->getESList();

        return $electronicSpecifications;
    }

    function getElectronicSpecification($id) {
        $electronicSpecification = $this->electronicCatalog->getElectronicSpecificationById($id);

        return $electronicSpecification;
    }

    private function generateSerialNumber() {
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $serialNumber = '';

        for ($i = 0; $i < 12; $i++) {
            $serialNumber .= $chars[rand(0, strlen($chars) - 1)];
        }

        return $serialNumber;
    }

}
