<?php

namespace App\Classes;

use App\Classes\Mappers\ElectronicCatalogMapper;
use App\Classes\Core\ElectronicSpecification;
use App\Classes\Core\ElectronicItem;
use App\Classes\Core\UserCatalog;
use App\Classes\Mappers\UserCatalogMapper;

class UnitOfWork {
    private $newList;
    private $changedList;
    private $deletedList;
    private $electronicCatalogMapper;

    function __construct($electronicCatalogMapper){
        $this->electronicCatalogMapper = $electronicCatalogMapper;
        $this->newList = array();
        $this->changedList = array();
        $this->deletedList = array();
    }

    function registerNew($object){
        array_push($this->newList, $object);
    }

    function registerDirty($object){
        array_push($this->changedList, $object);
    }

    function registerDeleted($object){
        array_push($this->deletedList, $object);
    }

    function commit(){

        foreach($this->newList as $new){
            if($new instanceof ElectronicSpecification){
                $this->electronicCatalogMapper->saveES($new);
            }
        }
        foreach($this->changedList as $changed){
            if($changed instanceof ElectronicSpecification){
                $this->electronicCatalogMapper->updateES($changed);
            }
        }
        foreach($this->deletedList as $deleted){
            if($deleted instanceof ElectronicItem){
                $this->electronicCatalogMapper->deleteEI($deleted);
            }
        }

        $this->newList = array();
        $this->changedList = array();
        $this->deletedList = array();

        return null;
    }

}
