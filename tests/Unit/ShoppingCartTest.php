<?php

namespace Tests\Unit;

use App\Classes\Core\ShoppingCart;
use App\Classes\Core\ElectronicItem;
use App\Classes\Core\User;
use App\Classes\Core\ElectronicSpecification;
use Tests\TestCase;
use Hash;
use Illuminate\Support\Facades\Auth;


class ShoppingCartTest extends TestCase
{
    public function testAddEIToCart(){

        /*  //creating the shopping cart
          $ShoppingCart = ShoppingCart::getInstance();

          $electronicSpecification1 = new ElectronicSpecification();
          $electronicSpecification2 = new ElectronicSpecification();
          $electronicItem1 = new ElectronicItem();
          $electronicItem2 = new ElectronicItem();
          $electronicItem3 = new ElectronicItem();

          $item1Data = new \stdClass();
          $item2Data = new \stdClass();

          //setting up attributes in shopping cart
          $item1Data->id = "1";
          $item1Data->serialNumber = 123;
          $item1Data->ElectronicSpecification_id = "1";

          $item2Data->id = "2";
          $item2Data->serialNumber = 456;
          $item2Data->ElectronicSpecification_id = "1";

          //electronicItems is the initial shopping cart with both(?)

          $electronicItem1->set($item1Data);
          $electronicItem2->set($item2Data);
          $electronicItems = array($electronicItem1, $electronicItem2);

          var_dump($electronicItems);

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
          //$electronicData1->electronicItems = $electronicItems;
          $electronicSpecification1->set($electronicData1);


          $ShoppingCartList = array($electronicItems);
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
          $numberOfItemsInCart = $ShoppingCart->getEIList();
          //var_dump($newShoppingCart);
          $this->assertTrue(count($numberOfItemsInCart) == 3);
        */

        $user = new User();

        $userData = new \stdClass();

        $userData->id = '1';
        $userData->firstName = 'John';
        $userData->lastName = 'Doe';
        $userData->email = 'johndoe123@gmail.com';
        $userData->phone = '123-456-7890';
        $userData->admin = '0';
        $userData->physicalAddress = '1234 Wallstreet';
        $userData->password = 'password123';


        $user->set($userData);

        Auth::login($user);
        Auth::check();
        //var_dump($user); //OK TRUE


        //Auth::login($user,true);





        $electronicItem1 = new ElectronicItem();
        $electronicItem2 = new ElectronicItem();
        // $ElectronicSpecification1 = new ElectronicSpecification();
        // $ElectronicSpecification2 = new ElectronicSpecification();

        $shoppingCart = ShoppingCart::getInstance(); //creating instance of ShoppingCart
        $item1Data = new \stdClass();
        $item2Data = new \stdClass();

        $item1Data->id="1";
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "1";
        $item1Data->User_id='1';
        $item1Data->expiryForUser='2017-12-25 12:12:12';

        $electronicItem1->set($item1Data);


       // var_dump($electronicItem1->getExpiryForUser());

        $item2Data->id="2";
        $item2Data->serialNumber = 234;
        $item2Data->ElectronicSpecification_id = "2";
        $item2Data->User_id ='1';
        $item2Data->expiryForUser='2017-12-25 12:12:12';

        $electronicItem2->set($item2Data);
//        var_dump($electronicItem2);




        $electronicItem3 = new ElectronicItem();
        $item3Data = new \stdClass();
        $item3Data->id="3";
        $item3Data->serialNumber= 345;
        $item3Data->User_id='1';
        $item3Data->expiryForUser='2017-12-25 12:12:12';

        $electronicItem3->set($item3Data);



        $shoppingCart->addEIToCart($electronicItem3);
        $shoppingCartList = $shoppingCart->getEIList();
        $size = count($shoppingCartList);
        var_dump($size);
        $this->assertTrue($size == 1);











    }








}
