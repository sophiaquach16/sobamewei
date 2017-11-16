<?php

namespace Tests\Unit;

use App\Classes\Core\ShoppingCart;
use App\Classes\Core\ElectronicItem;
use App\Classes\Core\User;
use App\Classes\Core\ElectronicSpecification;
use Tests\TestCase;
use Hash;

class ShoppingCartTest extends TestCase
{
    public function testAddEIToCart(){

        $electronicSpecification1 = new ElectronicSpecification();
        $electronicSpecification2 = new ElectronicSpecification();
        $electronicItem1 = new ElectronicItem();
        $electronicItem2 = new ElectronicItem();
        $electronicItem3 = new ElectronicItem();
        $item1Data = new \stdClass();
        $item2Data = new \stdClass();
        $ShoppingCart =new ShoppingCart();

        $item1Data->id = "1";
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "1";

        $item2Data->id = "2";
        $item2Data->serialNumber = 456;
        $item2Data->ElectronicSpecification_id = "1";

        $electronicItems = array($item1Data, $item2Data);
        $electronicItem1->set($item1Data);
        $electronicItem2->set($item2Data);

        $electronicData1 = new \stdClass();

        $electronicData1->id = '1';
        $electronicData1->dimension = '2X3X4';
        $electronicData1->weight = '100';
        $electronicData1->modelNumber = '123model';
        $electronicData1->brandName = '123';
        $electronicData1->hdSize = '123';
        $electronicData1->price = '123';
        $electronicData1->processorType = 'intel';
        $electronicData1->ramSize = '16';
        $electronicData1->cpuCores = '4';
        $electronicData1->batteryInfo = 'infinite';
        $electronicData1->os = 'ubuntu';
        $electronicData1->camera = true;
        $electronicData1->touchScreen = true;
        $electronicData1->ElectronicType_id = '1';
        $electronicData1->displaySize = '1';
        $electronicData1->electronicItems = $electronicItems;
        $electronicSpecification1->set($electronicData1);


        $ShoppingCartList = array($electronicItem1,$electronicItem2);
        $ShoppingCart->setEIList($ShoppingCartList);

        //adding one more EI using addEIToCart
        $item3Data = new \stdClass();
        $item3Data->id = "3";
        $item3Data->serialNumber = 789;
        $item3Data->ElectronicSpecification_id = "2";

        $electronicItem3->set($item3Data);

        $electronicData2 = new \stdClass();

        $electronicData2->id = '2';
        $electronicData2->dimension = '2X3X5';
        $electronicData2->weight = '100';
        $electronicData2->modelNumber = '4563model';
        $electronicData2->brandName = '456';
        $electronicData2->hdSize = '456';
        $electronicData2->price = '456';
        $electronicData2->processorType = 'intel';
        $electronicData2->ramSize = '32';
        $electronicData2->cpuCores = '4';
        $electronicData2->batteryInfo = 'infinite';
        $electronicData2->os = 'ubuntu';
        $electronicData2->camera = true;
        $electronicData2->touchScreen = true;
        $electronicData2->ElectronicType_id = '2';
        $electronicData2->displaySize = '2';
        $electronicData2->electronicItems = $electronicItem3;
        $electronicSpecification2->set($electronicData2);

        $ShoppingCart->addEIToCart($item3Data);
        $newShoppingCart =$ShoppingCart->getEIList();
        $this->assertTrue(count($newShoppingCart) == 3);

    }

    public function testSetGetEIList(){
        $electronicSpecification1 = new ElectronicSpecification();
        $electronicSpecification2 = new ElectronicSpecification();
        $electronicItem1 = new ElectronicItem();
        $electronicItem2 = new ElectronicItem();
        $electronicItem3 = new ElectronicItem();

        $item1Data = new \stdClass();
        $item1Data->id = "123";
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "1";

        $item2Data = new \stdClass();
        $item2Data->id = "456";
        $item2Data->serialNumber = 456;
        $item2Data->ElectronicSpecification_id = "2";

        $item3Data = new \stdClass();
        $item3Data->id = "789";
        $item3Data->serialNumber = 789;
        $item3Data->ElectronicSpecification_id = "2";

        $electronicItem1->set($item1Data);
        $electronicItem2->set($item2Data);
        $electronicItem2->set($item3Data);
        $ShoppingCartElectronicItems = array($electronicItem1,$electronicItem2, $electronicItem3);


        $electronicData1 = new \stdClass();

        $electronicData1->id = '1';
        $electronicData1->dimension = '2X3X4';
        $electronicData1->weight = '100';
        $electronicData1->modelNumber = '123model';
        $electronicData1->brandName = '123';
        $electronicData1->hdSize = '123';
        $electronicData1->price = '123';
        $electronicData1->processorType = 'intel';
        $electronicData1->ramSize = '16';
        $electronicData1->cpuCores = '4';
        $electronicData1->batteryInfo = 'infinite';
        $electronicData1->os = 'ubuntu';
        $electronicData1->camera = true;
        $electronicData1->touchScreen = true;
        $electronicData1->ElectronicType_id = '1';
        $electronicData1->displaySize = '1';
        $electronicData1->electronicItems = $electronicItem1;
        $electronicSpecification1->set($electronicData1);

        $electronicData2 = new \stdClass();

        $electronicData2->id = '2';
        $electronicData2->dimension = '2X3X5';
        $electronicData2->weight = '100';
        $electronicData2->modelNumber = '4563model';
        $electronicData2->brandName = '456';
        $electronicData2->hdSize = '456';
        $electronicData2->price = '456';
        $electronicData2->processorType = 'intel';
        $electronicData2->ramSize = '32';
        $electronicData2->cpuCores = '4';
        $electronicData2->batteryInfo = 'infinite';
        $electronicData2->os = 'ubuntu';
        $electronicData2->camera = true;
        $electronicData2->touchScreen = true;
        $electronicData2->ElectronicType_id = '2';
        $electronicData2->displaySize = '2';
        $electronicData2->electronicItems = array($electronicItem2,$electronicItem3);
        $electronicSpecification2->set($electronicData2);

        $ShoppingCart =new ShoppingCart();
        $ShoppingCart->setEIList(array($item1Data));
        $ShoppingCart->setEIList(array($item2Data));
        $ShoppingCart->setEIList(array($item3Data));
        $shippingCartEIList = $ShoppingCart->getEIList();
        $this->assertTrue(sizeof($shippingCartEIList) == sizeof($ShoppingCartElectronicItems));
    }



  


}
