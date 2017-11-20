<?php

namespace App\Classes\Core;
use Hash;
class TransactionCatalog
{

    private $transactionList;

    function __construct0() {
        $this->transactionList=[];
        $argv = func_get_args();
        switch (func_num_args()) {
            case 1:
                self::__construct1($argv[0]);
                break;
        }
    }
    function __construct1($trList) {
        //$this->transactionList = array();
        $this->setTransactionList($trList);
    }

    function setTransactionList($trList) {

        foreach ($trList as $oneTransaction) {
            $transaction = new Transaction($oneTransaction);
            //$this->transactionList->append($transaction);
           array_push($this->transactionList, $transaction);
        }
    }
    function getTransactionList() {
        $returnObject = array();
     if(is_array ($this->transactionList)) {
         foreach ($this->transactionList as $oneTransaction) {
            // $returnObject[] = $oneTransaction->get();
             array_push($returnObject, $oneTransaction->get());
         }
     }
        return $returnObject;
    }


}
