<?php

namespace App;

class ElectronicCatalog {

    private $eSList;

    function __construct($eSListData) {
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
            foreach ($eS->get()->electronicItems as $eIData) {
                if ($eIData->id === $id) {
                    $eS->deleteElectronicItem($id);
                }
            }
        }
    }

    function findElectronicSpecification($modelNumber) {
        $modelNumberExists = false;
        //dd($this->eSList);
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

        //dd($eS);

        array_push($this->eSList, $eS);
        return true;
    }

    function makeElectronicItem($modelNumber, $electronicItemData) {
        foreach ($this->eSList as $key => $value) {
            if ($this->eSList[$key]->getModelNumber() === $modelNumber) {
                $this->eSList[$key]->addElectronicItem($electronicItemData);

                break;
            }
        }
    }
    
    function modifyElectronicSpecification($eSId, $newESData){
        foreach($this->eSList as &$eS){
            if($eS->get()->id === $eSId){
                $eS->set((object)$newESData);
            }
        }
        //dd($this->eSList);
    }

}
