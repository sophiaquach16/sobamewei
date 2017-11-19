<?php

namespace App\Classes\Mappers;

use App\Classes\TDG\ElectronicCatalogTDG;
use App\Classes\TDG\TransactionTDG;
use App\Classes\Core\ElectronicCatalog;
use App\Classes\Core\Transaction;
use App\Classes\UnitOfWork;
use App\Classes\IdentityMap;

class TransactionMapper{
    private $electronicCatalog;
    private $electronicCatalogTDG;
    private $unitOfWork;
    private $identityMap;
    private $transactionList;
    private $transactionTDG;
    private $lockFilePointer;
    private $_userId;

    function __construct()
    {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;
        }
    }
    function __construct0() {
        $this->transactionTDG = new TransactionTDG();
        $this->unitOfWork = new UnitOfWork(['transactionMapper' => $this]);
        $this->identityMap = new IdentityMap();
    }

    function getAllElectronicSpecifications($userId){
        $transactionList = $this->transactionTDG->findAll($userId);
        foreach ($transactionList as $oneTransaction){
            $this->identityMap->add('Transaction', $oneTransaction);
        }
        //dd($transactionList);
        return $transactionList; //TODO
    }

    function savePurchase($new){

    }

}
