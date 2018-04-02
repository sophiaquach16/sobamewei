<?php

namespace App\Classes\Mappers;

use App\Classes\TDG\TransactionTDG;
use App\Classes\Core\TransactionCatalog;
use App\Classes\Core\ShoppingCart;
use App\Classes\UnitOfWork;
use App\Classes\IdentityMap;
use PhpDeal\Annotation as Contract;
use Auth;

use Hash;

class TransactionMapper
{

    public $transactionCatalog;
    public $transactionTDG;
    public $unitOfWork;
    public $identityMap;

    function __construct($user_id)
    {
        if ($user_id > -1){
            $this->transactionTDG = new TransactionTDG();
            $this->transactionCatalog = new TransactionCatalog($this->transactionTDG->findAll());
            $this->identityMap = new IdentityMap();
            $this->unitOfWork = new UnitOfWork(['transactionMapper' => $this]);
        }
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

    /**
     * @param $timestamp
     * @param $eiList
     * @return string
     * @Contract\Verify("Auth::check() && Auth::user()->admin === 0 && $eiList != null") //pre-condition
     * @Contract\Ensure("$this->getAllTransactions($user_id) != null") //post-condition
     * //Number of transactions corresponds to the number of objects that the customer has purchased
     *
     */

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
        if($trObjectsList != null) {
            foreach ($trObjectsList as $tr) {
                $this->unitOfWork->registerNew($tr);
                $this->unitOfWork->commit();
                $this->identityMap->add('Transaction', $tr);
            }
            return "transactionMade";
        }
        else{
            return "transactionFailed";
        }

    }

    function saveTransaction($transaction)
    {

        $timeStamp = $transaction->getTimeStamp();
        return $this->transactionTDG->addTransaction($transaction, $timeStamp);
    }

    /**
     * @param $item_id
     * @return string
     * @Contract\Ensure("($this->getTransactionByItemId($item_id))==null")
     */
     function ReturnPurchase($item_id){
         $transaction = $this->transactionCatalog->getTransactionObjectByItemId($item_id);

         if($transaction != null) {
             $this->identityMap->delete('Transaction', 'item_id', $item_id);
             $this->unitOfWork->registerDeleted($transaction);
             $this->unitOfWork->commit();

             return "purchaseReturned";
         }
         else{
             return "returnFailed";
         }
     }
    function deleteTransaction($tr){
        $this->transactionTDG->deleteTransaction($tr);
        return true;
    }
}
