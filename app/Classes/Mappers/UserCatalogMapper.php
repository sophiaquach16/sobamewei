<?php

namespace App\Classes\Mappers;

use App\Classes\TDG\UserCatalogTDG;
use App\Classes\Core\UserCatalog;

class UserCatalogMapper {

    private $userCatalog;
    private $userCatalogTDG;
    
    function __construct() {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;
        }
    }

    function __construct0() {
        $userCatalogTDG = new userCatalogTDG();
        $this->userCatalogTDG = new userCatalogTDG();
        $this->userCatalog = new userCatalog($this->userCatalogTDG->findAll());
    }
    
    function makeLoginLog($id) {
        date_default_timezone_set('EST');
        $timestamp = date("Y-m-d H:i:s");
        
        $this->userCatalogTDG->insertLoginLog($id, $timestamp);
    }
    
}