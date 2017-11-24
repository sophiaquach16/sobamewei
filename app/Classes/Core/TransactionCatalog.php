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

    function getTransactionByItemId($it_id)
    {
        $transaction = new \stdClass();
        foreach ($this->transactionList as $tr) {
            if ($tr->get()->item_id == $it_id){
                $transaction = $tr->get();
            }
        }
        return $transaction;
    }

    function getTransactionsByUserIdAndTimestamp($user_id, $timestamp)
    {
        $transactions = array();

        foreach ($this->transactionList as $transaction) {
            if ($transaction->get()->customer_id == $user_id && $transaction->get()->timestamp == $timestamp){
                array_push($transactions, $transaction);
            }
        }

        return $transactions;
    }

    function getTransactionObjectByItemId($item_id){
        $transaction = new Transaction();
        foreach ($this->transactionList as $tr) {
            if ($tr->get()->item_id == $item_id){
                $transaction->set($tr->get());
            }
        }
        return $transaction;
    }
}
