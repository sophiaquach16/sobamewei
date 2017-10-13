<?php

namespace App;

class ElectronicCatalog
{
    private $eSList;
    //private $eIList;

    function __construct()
    {
        $this->eSList = array();
        //$eIList = array();

        $this->updateESList();
    }

    function updateESList(){
        $electronicCatalogTDG = new ElectronicCatalogTDG();
        $items = $electronicCatalogTDG->getAll();

        foreach($items as $item){
            $eS = new ElectronicSpecification($item);
            array_push($this->eSList, $eS);
        }
    }

    function findElectronicSpecification($modelNumber)
    {
        $modelNumberExists = false;
        foreach($this->eSList as $eS){
            if(is_a($eS,'ElectronicSpecification')){
                if($eS->getModelNumber() ===  $modelNumber) {
                    $modelNumberExists = true;
                }
            }
        }

        return $modelNumberExists;
    }

    function makeElectronicSpecification($electronicSpecificationData)
    {
        $eS = new ElectronicSpecification($electronicSpecificationData);

        array_push($this->eSList, $eS);
        return $this->addES($eS);
    }

    function addES($eS){
        $electronicCatalogTDG = new ElectronicCatalogTDG();
        $parameters = array();

        foreach($eS->get() as $key => $value)
        {
            if($value !== null) {
                $parameters[$key] = $value;
            }
        }
        return $electronicCatalogTDG->add($parameters);
    }

}