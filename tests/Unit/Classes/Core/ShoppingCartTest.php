<?php

namespace Tests\Unit;

use App\Classes\Core\ShoppingCart;
use App\Classes\Core\ElectronicItem;
use App\Classes\Core\User;
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

        $shoppingCart->addEIToCart($electronicItem1);
        $shoppingCartList = $shoppingCart->getEIList();
        $size = count($shoppingCartList);
        $this->assertTrue($size == 1);

        //try adding other items
        $shoppingCart->addEIToCart($electronicItem2);
        $newSize= count($shoppingCart->getEIList());
        $this->assertTrue($newSize == 2);

        //try adding other items
        $shoppingCart->addEIToCart($electronicItem3);
        $newerSize= count($shoppingCart->getEIList());
        $this->assertTrue($newerSize == 3);
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

    public function testRemoveOutdatedEI(){
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

        //Create outdated Electronic Item

        $electronicItem1 = new ElectronicItem();
        $electronicItem2 = new ElectronicItem();


        $item1Data = new \stdClass();
        $item1Data->id="1";
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "1";
        $item1Data->User_id='1';
        $item1Data->expiryForUser='2017-10-10 12:12:12';
        $electronicItem1->set($item1Data);

        //Create a new electronic item, that isn't outdated
        $item2Data = new \stdClass();
        $item2Data->id="2";
        $item2Data->serialNumber = 234;
        $item2Data->ElectronicSpecification_id = "2";
        $item2Data->User_id ='1';
        $item2Data->expiryForUser='2017-12-25 12:12:12';
        $electronicItem2->set($item2Data);

        $electronicsList = array($electronicItem1,$electronicItem2);

        $shoppingCart = ShoppingCart::getInstance();
        $shoppingCart->setEIList($electronicsList);

        //the list should be composed of one item only, since the first one is outdated
        $this->assertTrue(count($shoppingCart->getEIList()) == 1);
    }

    public function testUpdateEIList(){

        $user = new User();

        $userData = new \stdClass();

        $userData->id = "1";
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
        $item1Data->expiryForUser='2017-12-12 12:12:12';
        $electronicItem1->set($item1Data);

        //Create a new electronic item, that isn't outdated
        $item2Data = new \stdClass();
        $item2Data->id="2";
        $item2Data->serialNumber = 234;
        $item2Data->ElectronicSpecification_id = "2";
        $item2Data->User_id ='1';
        $item2Data->expiryForUser='2017-12-25 12:12:12';
        $electronicItem2->set($item2Data);

        $electronicsList = array($electronicItem1,$electronicItem2);

        $shoppingCart = ShoppingCart::getInstance();
        $shoppingCart->setEIList($electronicsList);

        /*to remove an item from the shoppingCart, set UserID to null
        and set the ExpiryForUser to null*/

        $electronicItem1->setUserId(null);
        $electronicItem1->setExpiryForUser(null);

        $electronicsList = array($electronicItem1,$electronicItem2);
        $shoppingCart->setEIList($electronicsList);
        $itemsinCartAfterUpdate=count($shoppingCart->getEIList());

        //we should expect only one item in the cart
        $this->assertTrue($itemsinCartAfterUpdate == 1);

    }




}
