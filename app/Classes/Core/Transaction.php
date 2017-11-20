<?php
/**
 * Created by PhpStorm.
 * User: Wei
 * Date: 11/12/2017
 * Time: 1:23 PM
 */

namespace App\Classes\Core;




class Transaction
{
    private $item_id;
    private $customer_id;
    private $timestamp;
    private $serialNumber;
    private $ElectronicSpec_id;
    function __construct() {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;
            case 1:
                self::__construct1($argv[0]);
                break;
        }
    }
    public function __construct0()
    {

        $this->timestamp = '';
        $this->customer_id = 0;
        $this->item_id = 0;
        $this->serialNumber = 0;
        $this->ElectronicSpec_id = 0;
    }
    function __construct1($data) {
        $this->set($data);
    }



    public function set($data)
    {

        if (isset($data->timestamp)) {
            $this->timestamp = $data->timestamp;
        }
        if (isset($data->customer_id)) {
            $this->customer_id = $data->customer_id;
        }
        if (isset($data->item_id)) {
            $this->item_id = $data->item_id;
        }
        if (isset($data->serialNumber)) {
            $this->serialNumber = $data->serialNumber;
        }
        if (isset($data->ElectronicSpec_id)) {
            $this->ElectronicSpec_id = $data->ElectronicSpec_id;
        }
    }


    public function get() {
        $returnData = new \stdClass();

        $returnData->timestamp = $this->timestamp;
        $returnData->customer_id = $this->customer_id;
        $returnData->item_id = $this->item_id;
        $returnData->serialNumber = $this->serialNumber;
        $returnData->ElectronicSpec_id = $this->ElectronicSpec_id;
        return $returnData;
    }

    public function setTimeStamp($time){
        $this->timestamp =$time;
    }

    public function getTimeStamp(){
        return $this->timestamp;
    }
    public function getElectronicSpecId(){
        return $this->ElectronicSpec_id;

    }
    public function setElectronicSpecId($specId){
        $this->ElectronicSpec_id = $specId;
    }

    public function getItemId(){
        return $this->item_id;

    }
    public function setItemId($id){
        $this->item_id=$id;

    }
    public function getSerialNumber(){
        return $this->serialNumber;
    }
    public function setSerialNumber($serialNum){
        $this->serialNumber=$serialNum;

    }


}
