<?php
/**
 * Created by PhpStorm.
 * User: Wei
 * Date: 11/12/2017
 * Time: 1:23 PM
 */

namespace App\Classes\Core;

use App\Classes\Core\ElectronicItem;
use App\Classes\Core\User;
use App\Classes\Core\ShoppingCart;




class Transaction
{
    //  private $itemId;
    private $customerId;
    private $timeStamp;
    // private $serialNumber;
    private $transactionItems;
    // private $ElectronicSpecification_id;

    private function __construct()
    {
        //   $this->eIList = array();
        $this->timeStamp = null;
        $this->customerId = 0;
//        $this->itemId = 0;
//        $this->serialNumber = 0;
//        $this->ElectronicSpecification_id=0;
        $this->transactionItems = new arrayList();

    }

    public function purchase($userId)
    {
        $EIList = new ShoppingCart();
        $shoppingList = $EIList->getEIList();

        foreach ($shoppingList as $ei) {
            $tempItem = new \stdClass();
            $tempItem->customerId = $userId;
            $tempItem->itemId = $ei->getId();
            $tempItem->serialNumber = $ei->getSerialNumber();
            $tempItem->ElectronicSpecification_id = $ei->getElectronicSpecification_id();
            $tempItem->timeStamp =$this->timeStamp;
            array_push($transactionItems, $tempItem);
            //get the electronic specification for each electronic item, and unset the items for that specification
            //$ei = new ElectronicItem();
        }

        return $transactionItems;
    }

    public function setTimeStamp($time){
        $this->timeStamp =$time;
    }

    public function getTimeStamp(){
        return $this->timeStamp;
    }





}
