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
    //
    // function __construct() {
    //       $this->eSList = array();
    //       $argv = func_get_args();
    //       switch (func_num_args()) {
    //           case 0:
    //               self::__construct0();
    //               break;
    //           case 1:
    //               self::__construct1($argv[0]);
    //               break;
    //
    //
    //       }
    //     }

    function __construct($userCatalogMapper){
      $this->userCatalogMapper = $userCatalogMapper;
      $this->newList = array();
      $this->changedList = array();
      $this->deletedList = array();

    }
    //
    // function __construct1($electronicCatalogMapper){
    //     $this->electronicCatalogMapper = $electronicCatalogMapper;
    //     $this->newList = array();
    //     $this->changedList = array();
    //     $this->deletedList = array();
    //
    // }


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
            if($new instanceof User){
                $this->userCatalogMapper->saveUser($new);
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
