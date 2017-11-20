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

    private $timestamp;
    private $item_id;
    private $customer_id;
    private $serialNumber;
    private $ElectronicSpec_id;


    function __construct() {
        $argv = func_get_args();
        switch( func_num_args() ) {
            case 1:
                self::__construct1($argv[0]);
                break;
        }
    }

    function __construct1($data) {
        $this->set($data);
    }
//    public function __construct()
//    {
//        $this->timeStamp = null;
//        $this->customerId = 0;
//    }

    public function purchase($userId)
    {
        $EIList =  ShoppingCart::getInstance();
        $shoppingList = $EIList->getEIList();

        return $shoppingList;
    }

    public function setTimeStamp($time){
        $this->timestamp =$time;
    }

    public function getTimeStamp(){
        return $this->timestamp;
    }

    public function set($data) {
        if (isset($data->item_id)) {
            $this->item_id = $data->item_id;
        }
        if (isset($data->customer_id)) {
            $this->customer_id = $data->customer_id;
        }
        if (isset($data->serialNumber)) {
            $this->serialNumber = $data->serialNumber;
        }
        if (isset($data->ElectronicSpec_id)) {
            $this->ElectronicSpec_id = $data->ElectronicSpec_id;
        }
        if (isset($data->timestamp)) {
            $this->timestamp = $data->timestamp;
        }

    }

    public function get(){
        $returnData = new \stdClass();

        $returnData->item_id = $this->item_id;
        $returnData->customer_id = $this->customer_id;
        $returnData->serialNumber = $this->serialNumber;
        $returnData->ElectronicSpec_id = $this->ElectronicSpec_id;
        $returnData->timestamp = $this->timestamp;


        return $returnData;
    }



}
