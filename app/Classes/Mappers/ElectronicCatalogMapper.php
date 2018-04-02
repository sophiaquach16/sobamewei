<?php

namespace App\Classes\Mappers;

use App\Classes\Core\ElectronicCatalog;
use App\Classes\IdentityMap;
use App\Classes\TDG\ElectronicCatalogTDG;
use App\Classes\UnitOfWork;

class ElectronicCatalogMapper
{

    public $electronicCatalog;
    public $electronicCatalogTDG;
    public $unitOfWork;
    public $identityMap;
    public $lockFilePointer;

    function __construct()
    {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;

            case 4:
                self::__construct4($argv[0], $argv[1], $argv[2], $argv[3]);
                break;
        }

    }

    function __construct0()
    {
        $this->electronicCatalogTDG = new ElectronicCatalogTDG();
        $this->electronicCatalog = new ElectronicCatalog($this->electronicCatalogTDG->findAll());
        $this->unitOfWork = new UnitOfWork(['electronicCatalogMapper' => $this]);
        $this->identityMap = new IdentityMap();
    }

    //constructor created for the purpose of mocking
    function __construct4($electronicCatalogTDGMock, $electronicCatalogMock, $unitOfWorkMock,
                          $identityMapMock)
    {
        $this->electronicCatalogTDG = $electronicCatalogTDGMock;
        $this->electronicCatalog = $electronicCatalogMock;
        $this->unitOfWork = $unitOfWorkMock;
        $this->identityMap = $identityMapMock;
    }

    function saveES($electronicSpecification)
    {
        return $this->electronicCatalogTDG->insertElectronicSpecification($electronicSpecification);
    }

    function updateES($electronicSpecification)
    {
        return $this->electronicCatalogTDG->updateElectronicSpecification($electronicSpecification);
    }

    function deleteEI($electronicItem)
    {
        return $this->electronicCatalogTDG->deleteElectronicItem($electronicItem);
    }

    function makeNewElectronicSpecification($quantity, $electronicSpecificationData)
    {
        $this->lockDataAccess();
        //add image path to ESData

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

    function modifyElectronicSpecification($quantity, $eS, $eSData)
    {
        $eSId = $eS->id;

        $this->lockDataAccess();
        // verify if the newly entered model number exists
        $newModelNumberExists = $this->electronicCatalog->findElectronicSpecification($eSData->modelNumber);
        $this->unlockDataAccess();

        if (!$newModelNumberExists || $this->electronicCatalog->getElectronicSpecificationById($eSId)->modelNumber === $eSData->modelNumber) {
            $this->lockDataAccess();

            //Delete old file
            $splitLink = explode("/", $eS->image);
            $fileName = end($splitLink);
            try {
                if ($fileName !== "" && file_exists(public_path('images/' . $fileName))) {
                    unlink(public_path('images/' . $fileName));
                }
            } catch (\Exception $e) {
            }

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

    function deleteElectronicItems($eIIds)
    {
        $this->lockDataAccess();

        foreach ($eIIds as $eIId) {
            $this->identityMap->delete('ElectronicItem', 'id', $eIId);

            $electronicItem = $this->electronicCatalog->deleteElectronicItem($eIId);

            $this->unitOfWork->registerDeleted($electronicItem);
        }
        $this->unitOfWork->commit();

        $this->unlockDataAccess();
        return true;
    }

    function getAllElectronicSpecifications()
    {
        $this->lockDataAccess();

        $electronicSpecifications = $this->electronicCatalog->getESList();

        $this->unlockDataAccess();

        return $electronicSpecifications;
    }

    function getElectronicSpecification($id)
    {
        $this->lockDataAccess();

        $electronicSpecification = $this->electronicCatalog->getElectronicSpecificationById($id);

        $this->unlockDataAccess();

        return $electronicSpecification;
    }

    private function generateSerialNumber()
    {
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $serialNumber = '';

        for ($i = 0; $i < 12; $i++) {
            $serialNumber .= $chars[rand(0, strlen($chars) - 1)];
        }

        return $serialNumber;
    }

    private function lockDataAccess()
    {
        try {
            $this->lockFilePointer = fopen(app_path('Locks/dataAccess'), 'c'); //set file pointer
            flock($this->lockFilePointer, LOCK_EX); //lock file
        } catch (\Exception $e) {
        }
    }

    private function checkLock()
    {
        try {
            flock($this->lockFilePointer, LOCK_NB);
        } catch (\Exception $e) {
        }
    }

    private function unlockDataAccess()
    {
        try {
            flock($this->lockFilePointer, LOCK_UN); //unlock file
            fclose($this->lockFilePointer); //close file
        } catch (\Exception $e) {
        }
    }

    function getESFilteredAndSortedByCriteria($eSType, $criteriaArray, $sortBy)
    {
        // parameter is an array of criterion to be applied to the initial array: "$array"

        $eSArray = $this->electronicCatalog->getESList();

        // Filter By Electronic Type
        if (!is_null($eSType)) {
            foreach ($eSArray as $key => $value) {
                if ($eSArray[$key]->ElectronicType_name !== $eSType) {
                    unset($eSArray[$key]);
                }
            }
        }

        // Filter By Price Range
        $filteredByPrice = array();
        $containsPriceRange = false;

        foreach ($criteriaArray as $key => $value) {
            if (strpos($key, 'priceRange') !== false) {
                $containsPriceRange = true;
            }
        }

        if ($containsPriceRange) {
            foreach ($criteriaArray as $key => $value) { // filter out
                if (strpos($key, 'priceRange') !== false) { //if the criteria contains a "-" then it's a criteria
                    $price = explode("-", $value);

                    foreach ($eSArray as $eS) {
                        if ($eS->price >= $price[0] && $eS->price < $price[1]) {
                            array_push($filteredByPrice, $eS);
                        }
                    }
                }
            }
        } else {
            $filteredByPrice = $eSArray;
        }

        // Filter by Brand Name
        $filteredByBrandName = array();
        $containsBrandName = false;

        foreach ($criteriaArray as $key => $value) {
            if (strpos($key, 'brandName') !== false) {
                $containsBrandName = true;
            }
        }

        if ($containsBrandName) {
            foreach ($criteriaArray as $key => $value) { // filter out
                if (strpos($key, 'brandName') !== false) { //if the criteria contains a "-" then it's a criteria
                    foreach ($filteredByPrice as $eS) {
                        if ($eS->brandName === $value) {
                            array_push($filteredByBrandName, $eS);
                        }
                    }
                }
            }
        } else {
            $filteredByBrandName = $filteredByPrice;
        }

        // Filter by Display Size
        $filteredByDisplaySize = array();
        $containsDisplaySize = false;

        foreach ($criteriaArray as $key => $value) {
            if (strpos($key, 'displaySize') !== false) {
                $containsDisplaySize = true;
            }
        }

        if ($containsDisplaySize) {
            foreach ($criteriaArray as $key => $value) { // filter out
                if (strpos($key, 'displaySize') !== false) { //if the criteria contains a "-" then it's a criteria
                    foreach ($filteredByBrandName as $eS) {
                        if ($eS->displaySize === $value) {
                            array_push($filteredByDisplaySize, $eS);
                        }
                    }
                }
            }
        } else {
            $filteredByDisplaySize = $filteredByBrandName;
        }

        // Filter by TouchScreen
        $filteredByTouchScreen = array();
        $containsTouchScreen = false;

        foreach ($criteriaArray as $key => $value) {
            if (strpos($key, 'touchScreen') !== false) {
                $containsTouchScreen = true;
            }
        }

        if ($containsTouchScreen) {
            foreach ($criteriaArray as $key => $value) { // filter out
                if (strpos($key, 'touchScreen') !== false) { //if the criteria contains a "-" then it's a criteria
                    foreach ($filteredByDisplaySize as $eS) {
                        if ($eS->touchScreen === $value) {
                            array_push($filteredByTouchScreen, $eS);
                        }
                    }
                }
            }
        } else {
            $filteredByTouchScreen = $filteredByDisplaySize;
        }

        $filteredDone = $filteredByTouchScreen;

        // Sort By
        if (!is_null($sortBy)) {
            if ($sortBy === "priceAscending") {
                usort($filteredDone, function ($a, $b) {
                    return $a->price <=> $b->price;
                });
            } else {
                if ($sortBy === "priceDescending") {
                    usort($filteredDone, function ($a, $b) {
                        return $b->price <=> $a->price;
                    });
                }
            }
        }

        return $filteredDone;
    }

    function getESByType($eSType)
    {

        $eSArray = $this->electronicCatalog->getESList();

        if (!is_null($eSType)) {
            foreach ($eSArray as $key => $value) {
                if ($eSArray[$key]->ElectronicType_name !== $eSType) {
                    unset($eSArray[$key]);
                }
            }
        }

        return $eSArray;
    }

    function getAllEIForOnePurchaseForUser($user_id)
    {
        $this->lockDataAccess();
        $eIListForUser = array();
        $electronicSpecifications = $this->electronicCatalog->getESList();
        //  dd($electronicSpecifications);
        foreach ($electronicSpecifications as $eS) {
            $eIList = $eS->electronicItems;
            foreach ($eIList as $eI) {
                //dd($eI);
                if ($eI->User_id == $user_id)
                    array_push($eIListForUser, $eI);
            }
        }

        $this->unlockDataAccess();
        return $eIListForUser;
    }

    /**
     * @param $item_id
     * @param $serialNumber
     * @param $ElectronicSpecification_id
     *
     * @Contract\Verify("Auth::check() && Auth::user()->admin === 0 && $item_id != null && $serialNumber !=null && $ElectronicSpecification_id !=null ") //pre-condition
     * @Contract\Ensure ("($this->getElectronicSpecification($ElectronicSpecification_id)->get()->electronicItems)!=null") //post-condition
     */

    function addReturnedEI($item_id, $serialNumber, $ElectronicSpecification_id)
    {
        $this->lockDataAccess();
        $EI = $this->electronicCatalog->addReturnedEI($item_id, $serialNumber, $ElectronicSpecification_id);
        $this->identityMap->add('ElectronicItem', 'id', $item_id);
        $this->unitOfWork->registerNew($EI);
        $this->unitOfWork->commit();
        $this->unlockDataAccess();
        return true;
    }

    function saveEI($ei)
    {
        $this->electronicCatalogTDG->saveReturnedEI($ei);
        return true;
    }
}
