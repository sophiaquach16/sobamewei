<?php

namespace App\Classes\Mappers;

use App\Classes\TDG\ElectronicCatalogTDG;
use App\Classes\Core\ElectronicCatalog;
use App\Classes\UnitOfWork;
use App\Classes\IdentityMap;

class ElectronicCatalogMapper {

    private $electronicCatalog;
    private $electronicCatalogTDG;
    private $unitOfWork;
    private $identityMap;
    private $lockFilePointer;

    function __construct() {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;
        }
    }

    function __construct0() {
        $this->electronicCatalogTDG = new ElectronicCatalogTDG();
        $this->electronicCatalog = new ElectronicCatalog($this->electronicCatalogTDG->findAll());
        $this->unitOfWork = new UnitOfWork($this);
        $this->identityMap = new IdentityMap();
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
        $this->lockDataAccess();
        $modelNumberExists = $this->electronicCatalog->findElectronicSpecification($electronicSpecificationData->modelNumber);
        $this->unlockDataAccess();

        if (!$modelNumberExists) {
            $this->lockDataAccess();

            //Add to eSList of the catalog
            $electronicSpecification = $this->electronicCatalog->makeElectronicSpecification($electronicSpecificationData);

            //Add to database
            $this->unitOfWork->registerNew($electronicSpecification);
            $this->unitOfWork->commit();

            $serialNumber = $this->generateSerialNumber();
            for ($i = 1; $i <= $quantity; $i++) {
                $electronicItemData = new \stdClass();
                $electronicItemData->serialNumber = $serialNumber . $i;

                $this->electronicCatalog->makeElectronicItem($electronicSpecificationData->modelNumber, $electronicItemData);

                $this->electronicCatalogTDG->insertElectronicItem($electronicSpecificationData->modelNumber, $electronicItemData);
            }

            //Add to identity map
            $this->identityMap->add('ElectronicSpecification', $electronicSpecification);

            $this->unlockDataAccess();

            return true;
        } else {
            return false;
        }
    }

    function modifyElectronicSpecification($quantity, $eS, $eSData) {
        $eSId = $eS->id;

        $this->lockDataAccess();
        // verify if the newly entered model number exists
        $newModelNumberExists = $this->electronicCatalog->findElectronicSpecification($eSData->modelNumber);
        $this->unlockDataAccess();

        if (!$newModelNumberExists || $this->electronicCatalog->getElectronicSpecificationById($eSId)->modelNumber === $eSData->modelNumber) {
            $this->lockDataAccess();
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

            $this->unlockDataAccess();

            return true;
        } else {
            return false;
        }
    }

    function deleteElectronicItems($eIIds) {
        $this->lockDataAccess();

        foreach ($eIIds as $eIId) {
            $this->identityMap->delete('ElectronicItem', 'id', $eIId);

            $electronicItem = $this->electronicCatalog->deleteElectronicItem($eIId);

            $this->unitOfWork->registerDeleted($electronicItem);
        }
        $this->unitOfWork->commit();

        $this->unlockDataAccess();
    }

    function getAllElectronicSpecifications() {
        $this->lockDataAccess();

        $electronicSpecifications = $this->electronicCatalog->getESList();

        $this->unlockDataAccess();

        return $electronicSpecifications;
    }

    function getElectronicSpecification($id) {
        $this->lockDataAccess();

        $electronicSpecification = $this->electronicCatalog->getElectronicSpecificationById($id);

        $this->unlockDataAccess();

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

    private function lockDataAccess() {
        $this->lockFilePointer = fopen(app_path('Locks/dataAccess'), 'c'); //set file pointer
        flock($this->lockFilePointer, LOCK_EX); //lock file
    }

    private function checkLock() {
        flock($this->lockFilePointer, LOCK_NB);
    }

    private function unlockDataAccess() {
        flock($this->lockFilePointer, LOCK_UN); //unlock file
        fclose($this->lockFilePointer); //close file
    }

    function getESFilteredAndSortedByCriteria($criteriaArray) {
      // parameter is an array of criterion to be applied to the initial array: "$array"

      $array = $this->electronicCatalog->getESList();

      foreach($criteriaArray as $criteria){ // filter out

      switch($criteria) {

        case "desktop":
          foreach($array as $key => $value) {
            if($value != 'desktop') {
              unset($array[$key]);
            }
          }
          break;

        case "monitor":
        foreach($array as $key => $value) {
          if($value != 'monitor') {
            unset($array[$key]);
          }
        }
        break;

        case "tablet":
        foreach($array as $key => $value) {
          if($value != 'tablet') {
            unset($array[$key]);
          }
        }
        break;

        case "priceAscending":

        case "priceDescending":

        case "ascendingSize":

        case "descending size":

    }
  }


}

}
