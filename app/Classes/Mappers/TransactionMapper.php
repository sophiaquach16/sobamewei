<?php

namespace App\Classes\Mappers;

use App\Classes\TDG\TransactionTDG;
use App\Classes\TDG\ShoppingCartTDG;
use App\Classes\Core\TransactionCatalog;
use App\Classes\Core\ShoppingCart;
use App\Classes\UnitOfWork;
use App\Classes\IdentityMap;
use Hash;

class TransactionMapper
{

    private $transactionCatalog;
    private $shoppingCart;
    private $shoppingCartTDG;
    private $transactionTDG;
    private $unitOfWork;
    private $identityMap;

    function __construct($user_id)
    {
        $this->transactionTDG = new transactionTDG();
        $this->transactionCatalog = new transactionCatalog($this->transactionTDG->findAll());
        $this->identityMap = new IdentityMap();
        $this->shoppingCart = ShoppingCart::getInstance();
        $this->shoppingCartTDG = new ShoppingCartTDG();
        $this->shoppingCart->setEIList($this->shoppingCartTDG->findAllEIFromUser($user_id));
        $this->unitOfWork = new UnitOfWork(['transactionMapper' => $this]);
    }

    function getAllTransactions($user_id)
    {

        $transactions = $this->transactionCatalog->getTransactionListForUser($user_id);

        return $transactions;
    }

    function getTransactionByItemId($tr_id)
    {
        $transactions = $this->transactionCatalog->getTransactionByItemId($tr_id);

        return $transactions;
    }

    function makeNewTransaction($timestamp, $user_id)
    {
        $eiList = $this->shoppingCart->getEIList();
        $trListData = array();
        //the foreach loop is used to convert an ei object to a transaction object
        foreach ($eiList as $ei) {
            $trData = new \stdClass();
            $trData->item_id = $ei->getId();
            $trData->customer_id = $user_id;
            $trData->serialNumber = $ei->getSerialNumber();
            $trData->ElectronicSpec_id = $ei->getElectronicSpecification_id();
            $trData->timestamp = $timestamp;
            array_push($trListData, $trData);
        }
        $this->transactionCatalog->setTransactionList($trListData);
        $trObjectsList = $this->transactionCatalog->getTransactionsByUserIdAndTimestamp($user_id, $timestamp);
        foreach ($trObjectsList as $tr) {
            $this->unitOfWork->registerNew($tr);
            $this->unitOfWork->commit();
        }


    }

    function saveTransaction($transaction)
    {

        $timeStamp = $transaction->getTimeStamp();
        return $this->transactionTDG->addTransaction($transaction, $timeStamp);
    }
}
