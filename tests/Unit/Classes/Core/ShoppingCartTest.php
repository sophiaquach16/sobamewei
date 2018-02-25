<?php

namespace Tests\Unit;

use App\Classes\Core\ElectronicItem;
use App\Classes\Core\ShoppingCart;
use App\Classes\Core\User;
use Hash;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;


class ShoppingCartTest extends TestCase
{
    private $shoppingCart;
    private $electronicItem1;
    private $electronicItem2;


    public function setUp()
    {
        parent::setUp();

        //getting the actual cart instance
        $this->shoppingCart = ShoppingCart::getInstance(); //creating instance of ShoppingCart

        //creating a mock item with stub method get
        $this->electronicItemMock1 = $this
            ->getMockBuilder(ElectronicItem::class)
            ->setMethods(['get'])
            ->getMock();

        //creating a mock item with stub method get
        $this->electronicItemMock2 = $this
            ->getMockBuilder(ElectronicItem::class)
            ->setMethods(['get'])
            ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        //removing all items from the cart after each test execution
        $this->shoppingCart->setEIList(array());
    }

    public function testMockAddEIToCart()
    {

        //declare what to return when stub method is called on mock object
        $obj1 = new \stdClass();
        $obj1->expiryForUser = '2017-12-25 12:12:12';
        $obj1->User_id = 20;
        $this->electronicItemMock1->method('get')->willReturn($obj1);

        //add stub object to cart
        $retrievedItem = $this->shoppingCart->addEIToCart($this->electronicItemMock1);
        $this->assertTrue($retrievedItem->get()->User_id == '20');
        $this->assertTrue(sizeof($this->shoppingCart) == 1);
    }

    public function testMockGetEIList()
    {
        //object is expired,
        $obj1 = new \stdClass();
        $obj1->expiryForUser = '2017-12-25 12:12:12';
        $this->electronicItemMock1->method('get')->willReturn($obj1);

        //object not yet expired
        $obj2 = new \stdClass();
        $obj2->expiryForUser = date('Y-m-d H:i:s', strtotime('30 minute'));
        $this->electronicItemMock2->method('get')->willReturn($obj2);

        //adding all the mocks to the shopping cart
        ($this->shoppingCart->addEIToCart($this->electronicItemMock1));
        ($this->shoppingCart->addEIToCart($this->electronicItemMock2));
        ($this->shoppingCart->addEIToCart($this->electronicItemMock2));

        $itemsNotExpired = true;
        $cartSize = 0;
        //verifying that the cart does not contain any expired items
        //therefore should not contain the expired mock created above
        foreach ($this->shoppingCart->getEIList() as $item) {
            $cartSize++;
            if ($item->get()->expiryForUser < date('Y-m-d H:i:s')) {
                $itemsNotExpired = false;
                break;
            }//an expired item is one that is smaller than a future date or the current date
        }
        //added 3 items to cart, but one is expired so 2 items remaining in cart
        $this->assertTrue($cartSize == 2);
        $this->assertTrue($itemsNotExpired == true);

    }

    public function testMockUpdateEIList()
    {

        //declare what to return when stub method is called on mock object
        //object not attached to any user, it should be removed from the cart
        //using updateEIList, which will be tested later on in this test method
        $obj1 = new \stdClass();
        $obj1->expiryForUser = null;
        $obj1->userId = null;
        $this->electronicItemMock1->method('get')->willReturn($obj1);

        //declare what to return when stub method is called on mock object
        //object not yet expired, still in someone's cart
        $obj2 = new \stdClass();
        $obj2->expiryForUser = date('Y-m-d H:i:s', strtotime('30 minute'));
        $obj1->userId = 5;
        $this->electronicItemMock2->method('get')->willReturn($obj2);

        //adding all the mocks to the shopping cart
        ($this->shoppingCart->addEIToCart($this->electronicItemMock1));
        ($this->shoppingCart->addEIToCart($this->electronicItemMock2));
        ($this->shoppingCart->addEIToCart($this->electronicItemMock2));
        $this->shoppingCart->updateEIList();

        $itemsReleased = true;
        $cartSize = 0;

        //verifying that the cart does not contain any item without a userId and expiry date
        foreach ($this->shoppingCart->getEIList() as $item) {
            $cartSize++;
            if ($item->get()->expiryForUser == null && $item->get()->userId == null) {
                $itemsReleased = false;
                break;
            }//an expired item is one that is smaller than a future date or the current date
        }
        //added 3 items to cart, but one is not attached to any user so 2 items remaining in cart
        $this->assertTrue($cartSize == 2);
        $this->assertTrue($itemsReleased == true);

    }

    //since we cannot mock the setEIList, because it passes an std object to the method
    //there isnt anything to mock in that case for setEIList
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

    //we don't need to mock this method because it is called in the getEIList method
    //which is tested using mocks in test testMockGetEIList if you scroll up
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

}
