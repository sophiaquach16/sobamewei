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
    public function testMockAddEIToCart()
    {

        $shoppingCart = ShoppingCart::getInstance(); //creating instance of ShoppingCart

        //creating mock object and declaring stub method for mocked class
        $electronicItemMock1 = $this
            ->getMockBuilder(ElectronicItem::class)
            ->setMethods(['getId'])
            ->getMock();

        //declare what to return when stub method is called on mock object
        $electronicItemMock1->method('getId')->willReturn('20');

        //add stub object to cart
        $retrievedItem = $shoppingCart->addEIToCart($electronicItemMock1);
        $this->assertTrue($retrievedItem->getId() == '20');
        $this->assertTrue(sizeof($shoppingCart) == 1);
    }

    public function testMockGetEIList()
    {
        //getting the actual cart instance
        $shoppingCart = ShoppingCart::getInstance(); //creating instance of ShoppingCart

        //creating a mock item with sub method get
        $electronicItemMock1 = $this
            ->getMockBuilder(ElectronicItem::class)
            ->setMethods(['get'])
            ->getMock();

        //creating a mock item with sub method get
        $electronicItemMock2 = $this
            ->getMockBuilder(ElectronicItem::class)
            ->setMethods(['get'])
            ->getMock();

        //object is expired,
        $obj1 = new \stdClass();
        $obj1->expiryForUser = '2017-12-25 12:12:12';
        $electronicItemMock1->method('get')->willReturn($obj1);

        //object not yet expired
        $obj2 = new \stdClass();
        $obj2->expiryForUser = date('Y-m-d H:i:s', strtotime('30 minute'));
        $electronicItemMock2->method('get')->willReturn($obj2);

        //adding all the mocks to the shopping cart
        ( $shoppingCart->addEIToCart($electronicItemMock1));
        ( $shoppingCart->addEIToCart($electronicItemMock2));
        ( $shoppingCart->addEIToCart($electronicItemMock2));
        var_dump($shoppingCart->getEIList());

        $itemsNotExpired = true;
        $cartSize = 0;
        //verifying that the cart does not contain any expired items
        //therefore should not contain the expired mock created above
        foreach ($shoppingCart->getEIList() as $item)
        {
            $cartSize++;
            if ($item->get()->expiryForUser < date('Y-m-d H:i:s'))
            {
                $itemsNotExpired = false;
                break;
            }//an expired item is one that is smaller than a future date or the current date
        }
        //added 3 items to cart, but one is expired so 2 items remaining in cart
        $this->assertTrue($cartSize == 2);
        $this->assertTrue($itemsNotExpired == true);

    }
    public function testGetSetEIList()
    {

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
        $item1Data->id = "1";
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "1";
        $item1Data->User_id = '1';
        $item1Data->expiryForUser = date('Y-m-d H:i:s', strtotime('30 minute'));

        $electronicItem1->set($item1Data);

        $item2Data = new \stdClass();
        $item2Data->id = "2";
        $item2Data->serialNumber = 234;
        $item2Data->ElectronicSpecification_id = "2";
        $item2Data->User_id = '1';
        $item2Data->expiryForUser = date('Y-m-d H:i:s', strtotime('30 minute'));

        $electronicItem2->set($item2Data);

        $itemsList = array($electronicItem1, $electronicItem2);

        //create an array of the input data
        $itemDataArray = array((array)$item1Data, (array)$item2Data);

        //Creation of a shopping cart
        $ShoppingCart = ShoppingCart::getInstance();
        $ShoppingCart->setEIList($itemsList);

        $ShoppingCartList = $ShoppingCart->getEIList();

        $this->assertTrue($itemsList == $ShoppingCartList);
    }

    public function testRemoveOutdatedEI()
    {
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
        $item1Data->id = "1";
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "1";
        $item1Data->User_id = '1';
        $item1Data->expiryForUser = '2017-10-10 12:12:12';
        $electronicItem1->set($item1Data);

        //Create a new electronic item, that isn't outdated
        $item2Data = new \stdClass();
        $item2Data->id = "2";
        $item2Data->serialNumber = 234;
        $item2Data->ElectronicSpecification_id = "2";
        $item2Data->User_id = '1';
        $item2Data->expiryForUser = date('Y-m-d H:i:s', strtotime('30 minute'));
        $electronicItem2->set($item2Data);

        $electronicsList = array($electronicItem1, $electronicItem2);

        $shoppingCart = ShoppingCart::getInstance();
        $shoppingCart->setEIList($electronicsList);

        $notExpired = true;
        foreach ($shoppingCart->getEIList() as $item) {
            if ($item->get()->expiryForUser < date('Y-m-d H:i:s'))//expired date is smaller than future/current date
                $notExpired = false;
        }

        $this->assertTrue($notExpired == true);
    }

    public function testUpdateEIList()
    {

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
        $item1Data->id = "1";
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "1";
        $item1Data->User_id = '1';
        $item1Data->expiryForUser = date('Y-m-d H:i:s', strtotime('30 minute'));
        $electronicItem1->set($item1Data);

        //Create a new electronic item, that isn't outdated
        $item2Data = new \stdClass();
        $item2Data->id = "2";
        $item2Data->serialNumber = 234;
        $item2Data->ElectronicSpecification_id = "2";
        $item2Data->User_id = '1';
        $item2Data->expiryForUser = date('Y-m-d H:i:s', strtotime('30 minute'));
        $electronicItem2->set($item2Data);

        $electronicsList = array($electronicItem1, $electronicItem2);

        $shoppingCart = ShoppingCart::getInstance();
        $shoppingCart->setEIList($electronicsList);

        /*to remove an item from the shoppingCart, set UserID to null
        and set the ExpiryForUser to null*/
        $electronicItem1->setUserId(null);
        $electronicItem1->setExpiryForUser(null);

        $electronicsList = array($electronicItem1, $electronicItem2);
        $shoppingCart->setEIList($electronicsList);
        $itemsinCartAfterUpdate = count($shoppingCart->getEIList());

        //we should expect only one item in the cart
        $this->assertTrue($itemsinCartAfterUpdate == 1);

    }


}
