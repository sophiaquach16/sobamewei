<?php

namespace App\Classes\Core;
use PhpDeal\Annotation as Contract;

/**
 * Class Transaction
 * @Contract\Invariant("Auth::check() && Auth::user()->admin === 0")
 */
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

    /**
     * @param $userId
     * @return array
     * @Contract\Verify("Auth::check() && Auth::user()->admin === 0 && (count(Auth::user()) == 1)") //pre-condition
     * @Contract\Ensure("$this->getTimeStamp()!= null") //post-condition
     */
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
