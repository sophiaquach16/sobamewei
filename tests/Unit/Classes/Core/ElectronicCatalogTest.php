<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\Core\ElectronicCatalog;
use App\Classes\Core\ElectronicItem;
use App\Classes\Core\ElectronicSpecification;

class ElectronicCatalogTest extends TestCase {


    public function testmodifyElectronicSpecification() {
        $electronicSpecification = new ElectronicSpecification();

        $item1Data = new \stdClass();
        $item1Data->id = 1;
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "123";
        $item1Data->User_id = 123;
        $item1Data->expiryForUser = date('Y-m-d H:i:s', strtotime('+5 minutes') );

        $item2Data = new \stdClass();
        $item2Data->id = 2;
        $item2Data->serialNumber = 456;
        $item2Data->ElectronicSpecification_id = "123";
        $item2Data->User_id = 123;
        $item2Data->expiryForUser = date('Y-m-d H:i:s', strtotime('+5 minutes') );
        $electronicItems = array($item1Data, $item2Data);

        $electronicData = new \stdClass();
        $electronicData->id = '123'; //electronic specification id
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
        $electronicData->image = 'C:/Users/Mel';
        $electronicData->electronicItems = $electronicItems;

        //update the os by overwriting previous os value
        $electronicData->os = 'windows';

        $electronicCatalog = new ElectronicCatalog();
        $electronicCatalog->setESList(array($electronicData));
        $electronicCatalog->modifyElectronicSpecification($electronicData->id, $electronicData);


        $catalogList = $electronicCatalog->getEsList();
        $catalogListJson = json_decode(json_encode($catalogList), true);
        $electronicDataJson = json_decode(json_encode($electronicData), true);

        //flag for value comparison. if items don't match, $valuesMatch becomes false
        $valuesMatch = false;

        //compare values added from electronicData with the actual
        //ElectronicSpecification object
        foreach ($catalogListJson as $outerKey => $outerValue) {
            foreach ($outerValue as $innerKey => $innerValue) {
                if (is_array($catalogListJson[$outerKey][$innerKey]) == false) {
                    if ($innerKey != "ElectronicType_displaySizeUnit" && $innerKey != "ElectronicType_dimensionUnit" && $innerKey != "ElectronicType_name") {
                        if (isset($catalogListJson[$outerKey][$innerKey]) && $catalogListJson[$outerKey][$innerKey] == $electronicDataJson[$innerKey])
                            $valuesMatch = true;
                        else {
                            $valuesMatch = false;
                            //if the values don't match for the first values,
                            //then this is enough to fail the test
                            //don't execute the rest of the code
                            $this->assertTrue($valuesMatch);
                            break;
                        }//else
                    }//if2
                }//if is_array is false
            }//foreach2
        }//foreach
        //foreach loop that checks if the ElectronicItems object attributes
        //match electronicData->electronicItems values added at the beginning of
        //the code

        foreach ($catalogListJson[0]["electronicItems"] as $itemIndex => $item) {
            foreach ($item as $attributeKey => $attributeValue) {
                if ($attributeValue == ($electronicDataJson["electronicItems"][$itemIndex][$attributeKey]))
                    $valuesMatch = true;
                else {
                    $valuesMatch = false;
                    //$this->assertTrue($valuesMatch);
                    break;
                }//else
            }//foreach inner
        }//foreach outer

        $this->assertTrue($valuesMatch);
    }

//test end

    public function testmakeElectronicItem() {
        $item1Data = new \stdClass();
        $item1Data->id = 1;
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "123";
        //$electronicItems=array($item1Data);

        $electronicData = new \stdClass();
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
        $electronicData->electronicItems = array();

        $electronicCatalog = new ElectronicCatalog();
        $electronicCatalog->makeElectronicSpecification($electronicData);
        $electronicCatalog->makeElectronicItem($electronicData->modelNumber, $item1Data);

        $catalogList = $electronicCatalog->getEsList();
        $catalogListJson = json_decode(json_encode($catalogList), true);

        $itemDataJson = json_decode(json_encode($item1Data), true);
        $valuesMatch = false;
        $valueOfItemIndex;
        //retrieve which array index is the item we have just added into the
        //specification
        foreach ($catalogListJson[0]["electronicItems"] as $itemIndex => $item) {
            foreach ($item as $attributeKey => $attributeValue) {
                if ($catalogListJson[0]["electronicItems"][$itemIndex]["id"] == $item1Data->id) {
                    $valueOfItemIndex = $itemIndex;
                }//if
            }//foreach inner
        }//foreach outer
        //compare values of object retrieved with the ones we used to add into
        //the specification
        foreach ($catalogListJson[0]["electronicItems"] as $itemIndex => $item) {
            foreach ($item as $attributeKey => $attributeValue) {
                if ($catalogListJson[0]["electronicItems"][$valueOfItemIndex]["id"] == $item1Data->id) {
                    if($attributeKey !== "User_id" && $attributeKey !== "expiryForUser") {
                        if ($attributeValue == $itemDataJson[$attributeKey]) {
                            $valuesMatch = true;
                        } else {
                            $valuesMatch = false;
                            $this->assertTrue($valuesMatch);
                            break;
                        }//else
                    }
                }//outer if
            }//foreach inner
        }//foreach outer
        $this->assertTrue($valuesMatch);
    }

//test end

    public function testmakeElectronicSpecification() {
        $electronicSpecification = new ElectronicSpecification();

        $item1Data = new \stdClass();
        $item1Data->id = 1;
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "123";

        $item2Data = new \stdClass();
        $item2Data->id = 2;
        $item2Data->serialNumber = 456;
        $item2Data->ElectronicSpecification_id = "456";
        $electronicItems = array($item1Data, $item2Data);

        $electronicData = new \stdClass();
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
        $catalogList = $electronicCatalog->getEsList();
        $catalogListJson = json_decode(json_encode($catalogList), true);
        $electronicDataJson = json_decode(json_encode($electronicData), true);

        //flag for value comparison. if items don't match, $valuesMatch becomes false
        $valuesMatch = false;
        //compare values added from electronicData with the actual
        //ElectronicSpecification object
        foreach ($catalogListJson as $outerKey => $outerValue) {
            foreach ($outerValue as $innerKey => $innerValue) {
                if (is_array($catalogListJson[$outerKey][$innerKey]) == false) {
                    if ($innerKey != "ElectronicType_displaySizeUnit" && $innerKey != "ElectronicType_dimensionUnit" && $innerKey != "ElectronicType_name") {
                        if (isset($catalogListJson[$outerKey][$innerKey]) && $catalogListJson[$outerKey][$innerKey] == $electronicDataJson[$innerKey]) {
                            $valuesMatch = true;
                        } else {
                            $valuesMatch = false;
                            break;
                        }//else
                    }//if2
                }//if is_array is false
            }//foreach2
        }//foreach
        //foreach loop that checks if the ElectronicItems object attributes
        //match electronicData->electronicItems values added at the beginning of
        //the code
        foreach ($catalogListJson[0]["electronicItems"] as $itemIndex => $item) {
            foreach ($item as $attributeKey => $attributeValue) {
                if($attributeKey !== "User_id" && $attributeKey !== "expiryForUser") {
                if ($attributeValue == ($electronicDataJson["electronicItems"][$itemIndex]["$attributeKey"]))
                    $valuesMatch = true;
                else {
                    $valuesMatch = false;
                    return;
                }//else
                }
            }//foreach inner
        }//foreach outer
        $this->assertTrue($valuesMatch);
    }

//test 'testmakeElectronicSpecification' end


    public function testgetElectronicSpecificationById() {
      $electronicSpecification = new ElectronicSpecification();

      $item1Data = new \stdClass();
      $item1Data->id = 1;
      $item1Data->serialNumber = 123;
      $item1Data->ElectronicSpecification_id = 123;
      $item1Data->User_id = 123;
      $item1Data->expiryForUser = date('Y-m-d H:i:s', strtotime('+5 minutes') );

      $item2Data = new \stdClass();
      $item2Data->id = 2;
      $item2Data->serialNumber = 456;
      $item2Data->ElectronicSpecification_id = 123;
      $item2Data->User_id = 123;
      $item2Data->expiryForUser = date('Y-m-d H:i:s', strtotime('+5 minutes') );
      $electronicItems = array($item1Data, $item2Data);

      $electronicData = new \stdClass();
      $electronicData->id = 123; //electronic specification id
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
      $electronicData->image = 'C:/Users/Mel';
      $electronicData->electronicItems = $electronicItems;

      $electronicCatalog = new ElectronicCatalog();
      $electronicCatalog->setESList(array($electronicData));
      $electronicCatalogbyId=$electronicCatalog->getElectronicSpecificationById(123);
      $catalogListJson = json_decode(json_encode($electronicCatalogbyId), true);

      $electronicDataJson = json_decode(json_encode($electronicData), true);
      $valuesMatch = false;
      var_dump($electronicDataJson);

      //compare values added from electronicData with the actual
      //ElectronicSpecification object
          foreach ($catalogListJson as $key => $value) {
              if (is_array($catalogListJson[$key]) == false) {
                  if ($key != "ElectronicType_displaySizeUnit" && $key != "ElectronicType_dimensionUnit" && $key != "ElectronicType_name") {
                      if (isset($catalogListJson[$key]) && $catalogListJson[$key] == $electronicDataJson[$key])
                          $valuesMatch = true;
                      else {
                          $valuesMatch = false;
                          //if the values don't match for the first values,
                          //then this is enough to fail the test
                          //don't execute the rest of the code
                          $this->assertTrue($valuesMatch);
                          break;
                      }//else
                  }//if2
              }//if is_array is false
          }//foreach2

      //foreach loop that checks if the ElectronicItems object attributes
      //match electronicData->electronicItems values added at the beginning of
      //the code
        foreach ($catalogListJson["electronicItems"] as $itemIndex => $item) {
          foreach ($item as $attributeKey => $attributeValue) {
              if ($attributeValue == ($electronicDataJson["electronicItems"][$itemIndex][$attributeKey]))
                  $valuesMatch = true;
              else {
                  $valuesMatch = false;
                  $this->assertTrue($valuesMatch);
                  break;
              }//else
          }//foreach inner
      }//foreach outer
      $this->assertTrue($valuesMatch);
   }

//test

    public function testfindElectronicSpecification() {
        $electronicSpecification = new ElectronicSpecification();
        $electronicItem1 = new ElectronicItem();
        $electronicItem2 = new ElectronicItem();

        $item1Data = new \stdClass();
        $item1Data->id = 1;
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "123";

        $item2Data = new \stdClass();
        $item2Data->id = 2;
        $item2Data->serialNumber = 456;
        $item2Data->ElectronicSpecification_id = "456";

        $electronicItem1->set($item1Data);
        $electronicItem2->set($item2Data);
        $electronicItems = array($electronicItem1, $electronicItem2);
        $testModelNumber = "123model";

        $electronicData = new \stdClass();
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

        $modelFoundBool = $electronicCatalog->findElectronicSpecification($testModelNumber);
        $this->assertTrue($modelFoundBool);
    }

    public function testdeleteElectronicItem() {
        $electronicSpecification = new ElectronicSpecification();
        $electronicItem1 = new ElectronicItem();
        $electronicItem2 = new ElectronicItem();

        $item1Data = new \stdClass();
        $item1Data->id = 1;
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = 123;

        $item2Data = new \stdClass();
        $item2Data->id = 2;
        $item2Data->serialNumber = 456;
        $item2Data->ElectronicSpecification_id = 456;
        $electronicItem1->set($item1Data);
        $electronicItem2->set($item2Data);
        $electronicItems = array($electronicItem1, $electronicItem2);

        $electronicData = new \stdClass();
        $electronicData->id = '1'; //all id are int
        $electronicData->dimension = '2X3X4';
        $electronicData->weight = '100';
        $electronicData->modelNumber = '123model'; //string
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
        $array = json_decode(json_encode($catalogList), true);
        $sizeElectronicCatalogBefore = sizeof($array[0]["electronicItems"]);
        //dump ($sizeElectronicCatalogBefore);
        $electronicCatalog->deleteElectronicItem(1);

        //update the catalog json after the catalog has been modified
        $catalogList = $electronicCatalog->getESList();
        $array = json_decode(json_encode($catalogList), true);
        $sizeElectronicCatalogAfter = sizeof($array[0]["electronicItems"]);
        //dump ($sizeElectronicCatalogBefore);


        $this->assertTrue($sizeElectronicCatalogBefore !== $sizeElectronicCatalogAfter);
    }

    public function testSetGet() {

        $electronicSpecification = new ElectronicSpecification();
        $electronicItem1 = new ElectronicItem();
        $electronicItem2 = new ElectronicItem();

        $item1Data = new \stdClass();
        $item1Data->id = "456";
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "123abc";

        $item2Data = new \stdClass();
        $item2Data->id = "456";
        $item2Data->serialNumber = 456;
        $item2Data->ElectronicSpecification_id = "456abc";
        $electronicItem1->set($item1Data);
        $electronicItem2->set($item2Data);
        $electronicItems = array($electronicItem1, $electronicItem2);

        $electronicData = new \stdClass();

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
        $this->assertTrue(sizeof($catalogList) == sizeof(array($electronicData)));
    }

    public function testReturnedEI() {
      $electronicCatalog = new ElectronicCatalog();

      $electronicItem = new ElectronicItem();
      $itemData = new \stdClass();
      $itemData-> id = 'abcc12345';
      $itemData-> serialNumber = 'cdee12345';
      $itemData-> ElectronicSpecification_id = '1';
      $electronicItem-> set($itemData);

      $returnedEI = $electronicCatalog->addReturnedEI('abcc12345', 'cdee12345', '1');
      $this->assertTrue($returnedEI == $electronicItem);
    }
}
