<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\Core\User;
use App\Classes\Core\ElectronicItem;

class ElectroniItemTests extends TestCase{

  public function testSetGet(){
    $itemData=new \stdClass();
    $itemData->id=1;
    $itemData->serialNumber=123;
    $itemData->ElectronicSpecification_id="123";

    $electronicItem = new ElectronicItem();
    $electronicItem->set($itemData);
    $electronicItem->get();
    var_dump($electronicItem->get());
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

}
