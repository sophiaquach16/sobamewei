<?php

namespace App\Classes\Mappers;


use App\Classes\TDG\TransactionTDG;
use App\Classes\Core\TransactionCatalog;
use App\Classes\UnitOfWork;
use App\Classes\IdentityMap;

class TransactionMapper{

    private $unitOfWork;
    private $identityMap;
    private $transactionCatalog;
    private $transactionTDG;

    function __construct() {

        $this->transactionTDG = new TransactionTDG();
        $this->transactionCatalog = new TransactionCatalog($this->transactionTDG->findAllTransactions());
        $this->unitOfWork = new UnitOfWork(['transactionMapper' => $this]);
        $this->identityMap = new IdentityMap();
    }
    function getAllTransactions(){
      //  dd('wow');
        $transactions = $this->transactionCatalog->getTransactionList();
        return $transactions;

    }

    function savePurchase($new){
    }

}
