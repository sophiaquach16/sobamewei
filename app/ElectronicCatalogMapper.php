<?php

namespace App;

use App\ElectronicCatalog;

class ElectronicCatalogMapper {
    private $electronicCatalog;

    function __construct() {
        $argv = func_get_args();
        switch( func_num_args() ) {
            case 0:
                self::__construct0();
                break;
            case 1:
                self::__construct1($argv[0]);
                break;
        }
    }

    function __construct0() {
        $this->electronicCatalog = new ElectronicCatalog();
    }

    function __construct1($electronicCatalog) {
        $this->electronicCatalog = $electronicCatalog;
    }

    function makeNewElectronicSpecification($electronicSpecificationData){
        $modelNumberExists = $this->electronicCatalog->findElectronicSpecification($electronicSpecificationData->modelNumber);
            if(!$modelNumberExists){
                $this->electronicCatalog->makeElectronicSpecification($electronicSpecificationData);
            return true;
        }else{
            return false;
        }
    }

}