<?php

namespace App\Classes\Mappers;

use App\Classes\TDG\TransactionTDG;
use App\Classes\TDG\ShoppingCartTDG;
use App\Classes\TDG\ElectronicCatalogTDG;
use App\Classes\Core\TransactionCatalog;
use App\Classes\Core\ELectronicCatalog;
use App\Classes\Core\ShoppingCart;
use App\Classes\UnitOfWork;
use App\Classes\IdentityMap;
use Hash;

class TransactionMapper
{

    private $transactionCatalog;
    private $electronicCatalog;
    private $shoppingCart;
    private $shoppingCartTDG;
    private $transactionTDG;
    private $unitOfWork;
    private $identityMap;
    private $electronicCatalogTDG;

    function __construct($user_id)
    {
        $this->transactionTDG = new TransactionTDG();
        $this->electronicCatalogTDG = new ElectronicCatalogTDG();
        $this->shoppingCartTDG = new ShoppingCartTDG();
        $this->transactionCatalog = new TransactionCatalog($this->transactionTDG->findAll());
        $this->electronicCatalog = new ElectronicCatalog($this->electronicCatalogTDG->findAll());
        $this->shoppingCart = ShoppingCart::getInstance();
        $this->shoppingCart->setEIList($this->shoppingCartTDG->findAllEIFromUser($user_id));
        $this->identityMap = new IdentityMap();
        $this->unitOfWork = new UnitOfWork(['transactionMapper' => $this]);
    }

    function getAllTransactions($user_id)
    {

        $transactions = $this->transactionCatalog->getTransactionListForUser($user_id);

        return $transactions;
    }

    function getTransactionByItemId($tr_id)
    {
        $transaction = $this->transactionCatalog->getTransactionByItemId($tr_id);

        return $transaction;
    }

    function makeNewTransaction($timestamp, $eiList)
    {
        $trListData = array();
        $user_id = null;
        //the foreach loop is used to convert an ei object to a transaction object
        foreach ($eiList as $ei) {
            $trData = new \stdClass();
            $trData->item_id = $ei->id;
            $trData->customer_id = $ei->User_id;
            $trData->serialNumber = $ei->serialNumber;
            $trData->ElectronicSpec_id = $ei->ElectronicSpecification_id;
            $trData->timestamp = $timestamp;
            $user_id = $ei->User_id;
            array_push($trListData, $trData);
        }
        $this->transactionCatalog->setTransactionList($trListData);
        $trObjectsList = $this->transactionCatalog->getTransactionsByUserIdAndTimestamp($user_id, $timestamp);
        foreach ($trObjectsList as $tr) {
            $this->unitOfWork->registerNew($tr);
            $this->unitOfWork->commit();
            $this->identityMap->add('Transaction', $tr);
        }
        return $trObjectsList;
    }

    function saveTransaction($transaction)
    {

        $timeStamp = $transaction->getTimeStamp();
        return $this->transactionTDG->addTransaction($transaction, $timeStamp);
    }

}
