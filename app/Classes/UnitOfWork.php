<?php

namespace App\Classes;

use App\Classes\Mappers\ElectronicCatalogMapper;
use App\Classes\Core\ElectronicSpecification;
use App\Classes\Core\ElectronicItem;
use App\Classes\Core\UserCatalog;
use App\Classes\Mappers\UserCatalogMapper;
use App\Classes\Core\User;

class UnitOfWork {

    private $newList;
    private $changedList;
    private $deletedList;
    private $electronicCatalogMapper;
    private $userCatalogMapper;
    private $shoppingCartMapper;

    function __construct($mappers) {
        $this->newList = array();
        $this->changedList = array();
        $this->deletedList = array();
        
        if (isset($mappers['electronicCatalogMapper'])) {
            $this->electronicCatalogMapper = $mappers['electronicCatalogMapper'];
        }
        
        if (isset($mappers['userCatalogMapper'])) {
            $this->userCatalogMapper = $mappers['userCatalogMapper'];
        }
        
        if (isset($mappers['shoppingCartMapper'])) {
            $this->shoppingCartMapper = $mappers['shoppingCartMapper'];
        }
        
    }

    function registerNew($object) {
        array_push($this->newList, $object);
    }

    function registerDirty($object) {
        array_push($this->changedList, $object);
    }

    function registerDeleted($object) {
        array_push($this->deletedList, $object);
    }

    function commit() {

        foreach ($this->newList as $new) {
            if ($new instanceof ElectronicSpecification) {
                $this->electronicCatalogMapper->saveES($new);
            }
            if ($new instanceof User) {
                $this->userCatalogMapper->saveUser($new);
            }
            if ($new instanceof ElectronicItem) {
                $this->shoppingCartMapper->saveTransactionList($new);

            }
        }
        foreach ($this->changedList as $changed) {
            if ($changed instanceof ElectronicSpecification) {
                $this->electronicCatalogMapper->updateES($changed);
            }
            if ($changed instanceof ElectronicItem) {
                $this->shoppingCartMapper->updateEI($changed);
            }
        }
        foreach ($this->deletedList as $deleted) {
            if ($deleted instanceof ElectronicItem) {
                $this->electronicCatalogMapper->deleteEI($deleted);
            }
        }


        $this->newList = array();
        $this->changedList = array();
        $this->deletedList = array();

        return null;
    }

}
