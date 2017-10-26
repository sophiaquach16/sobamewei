<?php

namespace App\Classes\Mappers;

use App\Classes\TDG\UserCatalogTDG;
use App\Classes\Core\UserCatalog;
use App\Classes\UnitOfWork;
use App\Classes\IdentityMap;

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
        $this->userCatalogTDG = new userCatalogTDG();
        $this->userCatalog = new userCatalog($this->userCatalogTDG->findAll());
    }

    function makeLoginLog($id) {
        date_default_timezone_set('EST');
        $timestamp = date("Y-m-d H:i:s");

        $this->userCatalogTDG->insertLoginLog($id, $timestamp);
    }

  function makeNewCustomer($userData){
    $emailExists = $this->userCatalog->findUser($userData->email);

    if (!$emailExists) {
        //Add to userList of the catalog
        $user = $this->userCatalog->makeNewCustomer($userData);

        //Add to database
        $this->unitOfWork->registerNew($user);
        $this->unitOfWork->commit();
        //?    $electronicItemData = new \stdClass();

          $this->userCatalogTDG->add($userData);

        //Add to identity map
        $this->identityMap->add('User', $user);

        return true;
    } else {
        return false;
    }
  }
}
