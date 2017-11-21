<?php

namespace App\Classes\Core;

use Hash;

class TransactionCatalog
{

    private $transactionList;

    function __construct()
    {
        $this->transactionList = array();
        $argv = func_get_args();
        switch (func_num_args()) {
            case 1:
                self::__construct1($argv[0]);
                break;
        }
    }

    function __construct1($transactionListData)
    {
        $this->transactionList = array();

        $this->setTransactionList($transactionListData);
    }

    function setTransactionList($transactionListData)
    {
        //dd($userListData);
        foreach ($transactionListData as $transactionData) {
            $transaction = new Transaction($transactionData);
            array_push($this->transactionList, $transaction);
        }
    }

    function getTransactionList()
    {
        $transactions = array();

        foreach ($this->transactionList as $transaction) {
            array_push($transactions, $transaction->get());
        }

        return $transactions;
    }

    function getTransactionListForUser($user_id)
    {
        $transactions = array();

        foreach ($this->transactionList as $transaction) {
            if ($transaction->get()->customer_id == $user_id){
                array_push($transactions, $transaction->get());
            }
        }

        return $transactions;
    }

}
