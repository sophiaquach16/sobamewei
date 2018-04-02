<?php

namespace App\Classes\Core;
use PhpDeal\Annotation as Contract;
use Auth;

class ElectronicCatalog  {

    private $eSList;

    function __construct() {
          $this->eSList = array();
          $argv = func_get_args();
          switch (func_num_args()) {
              case 1:
                  self::__construct1($argv[0]);
                  break;
          }
      }
    function __construct1($eSListData) {
        $this->eSList = array();
        $this->setESList($eSListData);
    }

    function setESList($eSListData) {
        //dd($eSListData);
        foreach ($eSListData as $eSData) {
            $eS = new ElectronicSpecification($eSData);
            array_push($this->eSList, $eS);
        }
    }

    function getESList() {
        $returnObject = array();

        foreach ($this->eSList as $eS) {
            array_push($returnObject, $eS->get());
        }

        return $returnObject;
    }

    function deleteElectronicItem($id) {
        //dd($ids);
        foreach ($this->eSList as $eS) {
            foreach ($eS->getElectronicItems() as $eI) {
                if ($eI->get()->id === $id) {
                    $eS->deleteElectronicItem($id);
                    return $eI;
                }
            }
        }

        return null;
    }

    function findElectronicSpecification($modelNumber) {
        $modelNumberExists = false;

        foreach ($this->eSList as $eS) {
            if ($eS->getModelNumber() === $modelNumber) {
                $modelNumberExists = true;
            }
        }

        return $modelNumberExists;
    }

    function getElectronicSpecificationById($id) {
        foreach ($this->eSList as $eS) {
            if ($eS->getId() === $id) {
                return $eS->get();
            }
        }

        return null;
    }

    function makeElectronicSpecification($electronicSpecificationData) {
        $eS = new ElectronicSpecification($electronicSpecificationData);

        array_push($this->eSList, $eS);
        return $eS;
    }

    function makeElectronicItem($modelNumber, $electronicItemData) {
        foreach ($this->eSList as $key => $value) {
            if ($this->eSList[$key]->getModelNumber() === $modelNumber) {
                return $this->eSList[$key]->addElectronicItem($electronicItemData);

                break;
            }
        }
    }

    function modifyElectronicSpecification($eSId, $newESData){
        foreach($this->eSList as &$eS){
            if($eS->get()->id === $eSId){
                $eS->set((object)$newESData);
                return $eS;
            }
        }

        return null;
    }

    function reserveFirstEIFromES($eSId, $userId, $expiry) {
        $firstAvailableEI = null;

        //dd($this->eSList);

        foreach ($this->eSList as &$eS) {
            if ($eS->get()->id === $eSId) {
                $firstAvailableEI = $eS->reserveFirstAvailableEI($userId, $expiry);
                break;
            }
        }
        return $firstAvailableEI;
    }

    function getESListFromEIList($eIList){

        $ESList = array();
        foreach ($eIList as $eI){
            $eS = new ElectronicSpecification();
            $eSData = $this->getElectronicSpecificationById($eI->get()->ElectronicSpecification_id);
            $eS->set($eSData);
            array_push($ESList, $eS);
        }
        return $ESList;
    }

    function unsetUserAndExpiryFromEI($eSId, $userId){
        $removedEI = null;
        foreach ($this->eSList as $eS) {
            if($eS->get()->id == $eSId) {
                $removedEI = $eS->unsetUserAndExpiry($userId);
                break;
            }
        }
        return $removedEI;
    }



    /**
     * @param $item_id
     * @param $serialNumber
     * @param $ElectronicSpecification_id
     * @Contract\Verify("Auth::check() === true && Auth::user()->admin === 0")
     * @Contract\Ensure("($__result->getID() == $item_id) && ($__result->getSerialNumber()==$serialNumber) && ($__result->getElectronicSpecification_id==$ElectronicSpecification_id)");
     */
    function addReturnedEI($item_id,$serialNumber,$ElectronicSpecification_id){

        $EIData = new \stdClass();
        $EIData-> id = $item_id;
        $EIData->serialNumber =$serialNumber;
        $EIData->ElectronicSpecification_id = $ElectronicSpecification_id;

        $newEI=new ElectronicItem();
        $newEI->set($EIData);


        foreach ($this->eSList as $es) {
            if ($es->get()->id == $ElectronicSpecification_id){
                $es->addElectronicItem($EIData);

               break;
            }
        }

        return $newEI;
    }
}
