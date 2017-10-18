<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Classes\Core\ElectronicCatalog;
use App\Classes\Core\ElectronicItem;
use App\Classes\Core\ElectronicSpecification;

class ElectronicCatalogTest extends TestCase
{
  public function testmakeElectronicSpecification(){
    $electronicSpecification = new ElectronicSpecification();

    $item1Data=new \stdClass();
    $item1Data->id=1;
    $item1Data->serialNumber=123;
    $item1Data->ElectronicSpecification_id="123";

    $item2Data=new \stdClass();
    $item2Data->id=2;
    $item2Data->serialNumber=456;
    $item2Data->ElectronicSpecification_id="456";
    $electronicItems=array($item1Data, $item2Data);

    $electronicData= new \stdClass();
    $electronicData->id = '1'; //electronic specification id
    $electronicData->dimension = '2X3X4';
    $electronicData->weight = '100';
    $electronicData->modelNumber = '123model';
    $electronicData->brandName = '123';
    $electronicData->hdSize = '123';
    $electronicData->price = '123';
    $electronicData->processorType = 'intel';
    $electronicData->ramSize = '16';
    $electronicData->cpuCores = '4';
    $electronicData->batteryInfo = 'infinite';
    $electronicData->os = 'ubuntu';
    $electronicData->camera = true;
    $electronicData->touchScreen = true;
    $electronicData->displaySize = '1';
    $electronicData->ElectronicType_id = '1';
    $electronicData->electronicItems = $electronicItems;

    $electronicCatalog = new ElectronicCatalog();
    $electronicCatalog->makeElectronicSpecification($electronicData);
    $catalogList=$electronicCatalog->getEsList();
    $catalogListJson = json_decode(json_encode($catalogList),true);
    $electronicDataJson = json_decode(json_encode($electronicData),true);

    var_dump($catalogListJson);
    var_dump($electronicData);
    $valid=false;

    foreach ($catalogListJson as $outerKey => $outerValue)
    {
      //dump($outerKey);
      foreach ($outerValue as $innerKey => $innerValue)
      {
        if (is_array($catalogListJson[$outerKey][$innerKey])==false)
        {
          if (  $innerKey != "ElectronicType_displaySizeUnit" && $innerKey != "ElectronicType_dimensionUnit" && $innerKey != "ElectronicType_name")
          {
            if ($catalogListJson[$outerKey][$innerKey]==$electronicDataJson[$innerKey])
            {
              //dump($innerKey);
              $valid=true;
            }
            else
            {
              $valid=false;
              break;
            }//else
          }//if2
        }//if is_array is false
        else if (is_array($catalogListJson[$outerKey][$innerKey])==true)
        {
          foreach ($catalogListJson[$outerKey][$innerKey] as $arrayindexKey => $singleItemArray )
          //  dump($arrayindexKey);
          //  dump($singleItemArray);
            //dump("bitch");
            //dump ($itemInfo);
            foreach($singleItemArray as $key => $eachItemInfo)
            {
              //dump ($eachItemInfo);
            }
        }//if is array is true
      }//foreach2
    }//foreach
     dump ($valid);

     dump($catalogListJson[0]["electronicItems"]);

    // {
    //   //dump($outerKey);
    //   foreach ($outerValue as $innerKey => $innerValue)//innerKey is '0' or '1'
    //   {
    //     dump($innerValue);
    //
    //   }//foreach2
    // }//foreach

}//test end

  public function testgetElectronicSpecificationByIdTest(){
    $electronicSpecification = new ElectronicSpecification();
    $electronicItem1 = new ElectronicItem();
    $electronicItem2 = new ElectronicItem();

    $item1Data=new \stdClass();
    $item1Data->id=1;
    $item1Data->serialNumber=123;
    $item1Data->ElectronicSpecification_id="123";

    $item2Data=new \stdClass();
    $item2Data->id=2;
    $item2Data->serialNumber=456;
    $item2Data->ElectronicSpecification_id="456";

    $electronicItem1->set($item1Data);
    $electronicItem2->set($item2Data);
    $electronicItems=array($electronicItem1, $electronicItem2);

    $electronicData= new \stdClass();
    $electronicData->id = '1'; //electronic specification id
    $electronicData->dimension = '2X3X4';
    $electronicData->weight = '100';
    $electronicData->modelNumber = '123model';
    $electronicData->brandName = '123';
    $electronicData->hdSize = '123';
    $electronicData->price = '123';
    $electronicData->processorType = 'intel';
    $electronicData->ramSize = '16';
    $electronicData->cpuCores = '4';
    $electronicData->batteryInfo = 'infinite';
    $electronicData->os = 'ubuntu';
    $electronicData->camera = true;
    $electronicData->touchScreen = true;
    $electronicData->displaySize = '1';
    $electronicData->ElectronicType_id = '1';
    $electronicData->electronicItems = $electronicItems;
    $electronicSpecification->set($electronicData);
    $electronicCatalog = new ElectronicCatalog();


    $electronicCatalog->setESList(array($electronicData));
    $electronicCatalog->getElectronicSpecificationById(1);

    $catalogList = $electronicCatalog->getESList();
    $catalogListJson = json_decode(json_encode($catalogList),true);
    $electronicDataJson = json_decode(json_encode($electronicData),true);
    $valid=false;
    //for each loop to check values of electronicSpecification against
    //electronic Data, skipping the array of items.
    foreach ($catalogListJson as $outerKey => $outerValue)
    {
      //dump($outerKey);
      foreach ($outerValue as $innerKey => $innerValue)
      {
        if (is_array($catalogListJson[$outerKey][$innerKey])==false)
        {
          if (  $innerKey != "ElectronicType_displaySizeUnit" && $innerKey != "ElectronicType_dimensionUnit" && $innerKey != "ElectronicType_name")
          {
            if ($catalogListJson[$outerKey][$innerKey]==$electronicDataJson[$innerKey])
            {
              //dump($innerKey);
              $valid=true;
            }
            else
            {
              $valid=false;
              break;
            }//else
          }//if2
        }//if
      }//foreach2
    }//foreach
     dump ($valid);
     $catalogList = $electronicCatalog->getESList();
     //dump($catalogList);
     $catalogListJson = json_decode(json_encode($catalogList),true);
     $electronicItemsJson=$catalogListJson[0]["electronicItems"];
     $electronicCount = 0;
     //compare electronicData item created int his test with
     // electronicItems from $catalogList->getESList
     foreach($electronicItems as $electronitArray => $innerArray)
     {
      $tempArray = array($innerArray->getId(), $innerArray->getSerialNumber(),$innerArray->getElectronicSpecification_id());
      $tempArray = array_values($tempArray);
      //dump($tempArray);
      $count = 0;

        foreach($electronicItemsJson[$electronicCount] as $innerKey => $innerValue)
         {
           if($tempArray[$count] != $innerValue)
           {
            $valid = false;
             break;
           }
           $count++;
         }
         $electronicCount++;
     }
      $this->assertTrue($valid);
  }//test
  public function testfindElectronicSpecificationTest(){
    $electronicSpecification = new ElectronicSpecification();
    $electronicItem1 = new ElectronicItem();
    $electronicItem2 = new ElectronicItem();

    $item1Data=new \stdClass();
    $item1Data->id=1;
    $item1Data->serialNumber=123;
    $item1Data->ElectronicSpecification_id="123";

    $item2Data=new \stdClass();
    $item2Data->id=2;
    $item2Data->serialNumber=456;
    $item2Data->ElectronicSpecification_id="456";

    $electronicItem1->set($item1Data);
    $electronicItem2->set($item2Data);
    $electronicItems=array($electronicItem1,$electronicItem2);
    $testModelNumber="123model";

    $electronicData= new \stdClass();
    $electronicData->id = '1';
    $electronicData->dimension = '2X3X4';
    $electronicData->weight = '100';
    $electronicData->modelNumber = $testModelNumber;
    $electronicData->brandName = '123';
    $electronicData->hdSize = '123';
    $electronicData->price = '123';
    $electronicData->processorType = 'intel';
    $electronicData->ramSize = '16';
    $electronicData->cpuCores = '4';
    $electronicData->batteryInfo = 'infinite';
    $electronicData->os = 'ubuntu';
    $electronicData->camera = true;
    $electronicData->touchScreen = true;
    $electronicData->ElectronicType_id = '1';
    $electronicData->displaySize = '1';
    $electronicData->electronicItems = $electronicItems;

    $electronicSpecification->set($electronicData);
    $electronicCatalog = new ElectronicCatalog();
    $electronicCatalog->setESList(array($electronicData));

    $modelFoundBool=$electronicCatalog->findElectronicSpecification($testModelNumber);
    $this->assertTrue($modelFoundBool);
  }
  public function testdeleteElectronicItemTest(){
    $electronicSpecification = new ElectronicSpecification();
    $electronicItem1 = new ElectronicItem();
    $electronicItem2 = new ElectronicItem();

    $item1Data=new \stdClass();
    $item1Data->id=1;
    $item1Data->serialNumber=123;
    $item1Data->ElectronicSpecification_id=123;

    $item2Data=new \stdClass();
    $item2Data->id=2;
    $item2Data->serialNumber=456;
    $item2Data->ElectronicSpecification_id=456;
    $electronicItem1->set($item1Data);
    $electronicItem2->set($item2Data);
    $electronicItems=array($electronicItem1,$electronicItem2);

    $electronicData= new \stdClass();
    $electronicData->id = '1';//all id are int
    $electronicData->dimension = '2X3X4';
    $electronicData->weight = '100';
    $electronicData->modelNumber = '123model';//string
    $electronicData->brandName = '123';
    $electronicData->hdSize = '123';
    $electronicData->price = '123';
    $electronicData->processorType = 'intel';
    $electronicData->ramSize = '16';
    $electronicData->cpuCores = '4';
    $electronicData->batteryInfo = 'infinite';
    $electronicData->os = 'ubuntu';
    $electronicData->camera = true;
    $electronicData->touchScreen = true;
    $electronicData->ElectronicType_id = '1';
    $electronicData->displaySize = '1';
    $electronicData->electronicItems = $electronicItems;

    $electronicSpecification->set($electronicData);

    $electronicCatalog = new ElectronicCatalog();
    $electronicCatalog->setESList(array($electronicData));
    $catalogList = $electronicCatalog->getESList();

    //"first turn your object into a json object,
    //this will return a string of your object into a JSON representative.
    //Take that result and decode with an extra parameter of true,
    //where it will convert to associative array"
    //https://stackoverflow.com/questions/19495068/convert-stdclass-object-to-array-in-php
    $array = json_decode(json_encode($catalogList),true);
    $sizeElectronicCatalogBefore=sizeof($array[0]["electronicItems"]);
    //dump ($sizeElectronicCatalogBefore);
    $electronicCatalog->deleteElectronicItem(1);

    //update the catalog json after the catalog has been modified
    $catalogList = $electronicCatalog->getESList();
    $array = json_decode(json_encode($catalogList),true);
    $sizeElectronicCatalogAfter=sizeof($array[0]["electronicItems"]);
    //dump ($sizeElectronicCatalogBefore);


    $this->assertTrue($sizeElectronicCatalogBefore!==$sizeElectronicCatalogAfter);
  }
  public function testSetTest(){

    $electronicSpecification = new ElectronicSpecification();
    $electronicItem1 = new ElectronicItem();
    $electronicItem2 = new ElectronicItem();

    $item1Data=new \stdClass();
    $item1Data->id="456";
    $item1Data->serialNumber=123;
    $item1Data->ElectronicSpecification_id="123abc";

    $item2Data=new \stdClass();
    $item2Data->id="456";
    $item2Data->serialNumber=456;
    $item2Data->ElectronicSpecification_id="456abc";
    $electronicItem1->set($item1Data);
    $electronicItem2->set($item2Data);
    $electronicItems=array($electronicItem1,$electronicItem2);

    $electronicData= new \stdClass();

    $electronicData->id = '1';
    $electronicData->dimension = '2X3X4';
    $electronicData->weight = '100';
    $electronicData->modelNumber = '123model';
    $electronicData->brandName = '123';
    $electronicData->hdSize = '123';
    $electronicData->price = '123';
    $electronicData->processorType = 'intel';
    $electronicData->ramSize = '16';
    $electronicData->cpuCores = '4';
    $electronicData->batteryInfo = 'infinite';
    $electronicData->os = 'ubuntu';
    $electronicData->camera = true;
    $electronicData->touchScreen = true;
    $electronicData->ElectronicType_id = '1';
    $electronicData->displaySize = '1';
    $electronicData->electronicItems = $electronicItems;

    $electronicSpecification->set($electronicData);

    $electronicCatalog = new ElectronicCatalog();
    $electronicCatalog->setESList(array($electronicData));
    $catalogList = $electronicCatalog->getESList();
    $this->assertTrue(sizeof($catalogList)==sizeof(array($electronicData)));
    }
}
