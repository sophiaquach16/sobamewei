<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\Core\User;
use App\Classes\Core\ElectronicItem;

class ElectroniItemTests extends TestCase{

  public function testsetGet(){
    $itemData=new \stdClass();
    $itemData->id=1;
    $itemData->serialNumber=123;
    $itemData->ElectronicSpecification_id=123;

    $electronicItem = new ElectronicItem();
    $electronicItem->set($itemData);
    $electronicItem->get();
    $electronicItemJson=(json_decode(json_encode($electronicItem->get()),true));

    //flag for value comparison. if items don't match, $valuesMatch becomes false
    $valuesMatch=false;

    if ($electronicItemJson["id"]==$itemData->id &&
        $electronicItemJson["serialNumber"]==$itemData->serialNumber &&
        $electronicItemJson["ElectronicSpecification_id"]== $itemData->ElectronicSpecification_id)
      $valuesMatch=true;
    else
      $valuesMatch=false;
    $this->assertTrue($valuesMatch);
  }//end of testSetGet

  public function testgetId (){
    $itemData=new \stdClass();
    $itemData->id=1;
    $itemData->serialNumber=123;
    $itemData->ElectronicSpecification_id=123;
    $electronicItem = new ElectronicItem();
    $electronicItem->set($itemData);
    $retrievedId=$electronicItem->getId();
    $this->assertTrue($retrievedId==$itemData->id);
  }

  //test for both setSerialNumber and getSerialNumber
  public function testsetGetSerialNumber (){
    $itemData=new \stdClass();
    $itemData->id=1;
    $itemData->serialNumber=123;
    $itemData->ElectronicSpecification_id=123;
    $electronicItem = new ElectronicItem();
    $electronicItem->setSerialNumber($itemData->serialNumber);
    $retrievedSerialNumber=$electronicItem->getSerialNumber();
    $this->assertTrue($retrievedSerialNumber==$itemData->serialNumber);
  }

  public function testgetElectronicSpecification_id(){
    $itemData=new \stdClass();
    $itemData->id=1;
    $itemData->serialNumber=123;
    $itemData->ElectronicSpecification_id=123;
    $electronicItem = new ElectronicItem();
    $electronicItem->set($itemData);
    $retrievedElectronicSpecificationId=$electronicItem->getElectronicSpecification_id();
    $this->assertTrue($retrievedElectronicSpecificationId==$itemData->ElectronicSpecification_id);
  }
  
  //tests for both setExpiryforUser and getExpiryforUser
  public function testsetgetExpiryforUser (){
       $itemData=new \stdClass();
       $itemData->id=1;
       $itemData->serialNumber=123;
       $itemData->ElectronicSpecification_id=123;
       $electronicItem = new ElectronicItem();
       $electronicItem->setExpiryForUser($itemData->ExpiryForUser);
       $retrievedExpiry=$electronicItem->getExpiryForUser();
       $this->assertTrue($retrievedExpiry==$itemData->ExpiryForUser);
 }
}
