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

        $electronicItem1 = new ElectronicItem();
        $electronicItem2 = new ElectronicItem();


        $shoppingCart = ShoppingCart::getInstance(); //creating instance of ShoppingCart
        $item1Data = new \stdClass();
        $item2Data = new \stdClass();

        $item1Data->id="1";
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "1";
        $item1Data->User_id='1';
        $item1Data->expiryForUser='2017-12-25 12:12:12';

        $electronicItem1->set($item1Data);


        $item2Data->id="2";
        $item2Data->serialNumber = 234;
        $item2Data->ElectronicSpecification_id = "2";
        $item2Data->User_id ='1';
        $item2Data->expiryForUser='2017-12-25 12:12:12';

        $electronicItem2->set($item2Data);

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
        $this->assertTrue($size == 1);


    }


    public function testGetSetEIList(){

        //Creation of a user
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

        $electronicItem1 = new ElectronicItem();
        $electronicItem2 = new ElectronicItem();

        $item1Data = new \stdClass();
        $item1Data->id="1";
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "1";
        $item1Data->User_id='1';
        $item1Data->expiryForUser='2017-12-25 12:12:12';

        $electronicItem1->set($item1Data);

        $item2Data = new \stdClass();
        $item2Data->id="2";
        $item2Data->serialNumber = 234;
        $item2Data->ElectronicSpecification_id = "2";
        $item2Data->User_id ='1';
        $item2Data->expiryForUser='2017-12-25 12:12:12';

        $electronicItem2->set($item2Data);

        $itemsList = array($electronicItem1,$electronicItem2); //use this for assert
        //Creation of a shopping cart
        $ShoppingCart = ShoppingCart::getInstance();
        $ShoppingCart->setEIList($itemsList);

        $ShoppingCartList = $ShoppingCart->getEIList();

        $this->assertTrue($itemsList == $ShoppingCartList);




    }






}
