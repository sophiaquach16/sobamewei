<?php

namespace App\Classes;


use App\Classes\Mappers\ElectronicCatalogMapper;
use App\Classes\Core\ElectronicSpecification;
use App\Classes\Core\ElectronicItem;
use App\Classes\Core\Transaction;
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
    private $transactionMapper;

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

        if (isset($mappers['transactionMapper'])) {
            $this->transactionMapper = $mappers['transactionMapper'];
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
                $this->electronicCatalogMapper->saveEI($new);

            }
            if ($new instanceof Transaction) {
                $this->transactionMapper->saveTransaction($new);

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
            if ($deleted instanceof User) {
                $this->userCatalogMapper->deleteCurrentUser($deleted);
            }
            if ($deleted instanceof Transaction) {
                $this->transactionMapper->deleteTransaction($deleted);
            }
        }


        $this->newList = array();
        $this->changedList = array();
        $this->deletedList = array();

        return null;
    }

}
