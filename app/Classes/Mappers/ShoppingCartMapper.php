<?php

/* New Class Helen */

namespace App\Classes\Mappers;

use App\Classes\Core\ElectronicCatalog;
use App\Classes\Core\ShoppingCart;
use App\Classes\TDG\ShoppingCartTDG;
use App\Classes\TDG\ElectronicCatalogTDG;
use App\Classes\UnitOfWork;
use App\Classes\IdentityMap;

class ShoppingCartMapper {

    private $electronicCatalog;
    private $electronicCatalogTDG;
    private $shoppingCart;
    private $shoppingCartTDG;
    private $unitOfWork;
    private $identityMap;

    function __construct() {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 1:
                self::__construct1($argv[0]);
                break;
        }
    }

    function __construct1($userId) {
        $this->electronicCatalogTDG = new ElectronicCatalogTDG();
        $this->electronicCatalog = new ElectronicCatalog($this->electronicCatalogTDG->findAll());
        $this->shoppingCart = ShoppingCart::getInstance();
        $this->shoppingCartTDG = new ShoppingCartTDG();
        $this->unitOfWork = new UnitOfWork(['shoppingCartMapper' => $this]);
        $this->identityMap = new IdentityMap();

        $this->shoppingCart->setEIList($this->shoppingCartTDG->findAllEIFromUser($userId));
    }

    /* New method Helen */

    function addToCart($eSId, $userId, $expiry) {
        $eI = $this->electronicCatalog->reserveFirstEIFromES($eSId, $userId, $expiry);

        if ($eI != null) {
            $this->shoppingCart->addEIToCart($eI);
            
            $this->unitOfWork->registerDirty($eI);
            $this->unitOfWork->commit();
            
            return true;
        } else {
            return false;
        }
    }

    function updateEI($eI) {
        $this->shoppingCartTDG->updateEI($eI);
    }

}
