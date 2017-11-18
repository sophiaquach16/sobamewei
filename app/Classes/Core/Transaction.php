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
   // private $transactionItems;
    // private $ElectronicSpecification_id;

    public function __construct()
    {
        $this->timeStamp = null;
        $this->customerId = 0;
    }

    public function purchase($userId)
    {
        $EIList =  ShoppingCart::getInstance();
        $shoppingList = $EIList->getEIList();

        return $shoppingList;
    }

    public function setTimeStamp($time){
        $this->timeStamp =$time;
    }

    public function getTimeStamp(){
        return $this->timeStamp;
    }

}
