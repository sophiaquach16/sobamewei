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
    public function testAddEIToCart()
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
        $electronicItem3 = new ElectronicItem();


        $shoppingCart = ShoppingCart::getInstance(); //creating instance of ShoppingCart
        $item1Data = new \stdClass();
        $item2Data = new \stdClass();
        $item3Data = new \stdClass();

        $item1Data->id = "1";
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "1";
        $item1Data->User_id = '1';
        //since items are removed from the user's cart if they are expired, set a item expiry date that is 30
        // minutes ahead of current time
        $item1Data->expiryForUser = date('Y-m-d H:i:s', strtotime('30 minute'));
        $electronicItem1->set($item1Data);


        $item2Data->id = "2";
        $item2Data->serialNumber = 234;
        $item2Data->ElectronicSpecification_id = "2";
        $item2Data->User_id = '1';
        $item2Data->expiryForUser = date('Y-m-d H:i:s', strtotime('30 minute'));
        $electronicItem2->set($item2Data);

        $item3Data->id = "3";
        $item3Data->serialNumber = 345;
        $item3Data->ElectronicSpecification_id = "3";
        $item3Data->User_id = "1";
        $item3Data->expiryForUser = date('Y-m-d H:i:s', strtotime('30 minute'));
        $electronicItem3->set($item3Data);

        //create an array of the input data
        $itemDataArray = array((array)$item1Data, (array)$item2Data, (array)$item3Data);

        $shoppingCart->addEIToCart($electronicItem1);
        $shoppingCart->addEIToCart($electronicItem2);
        $shoppingCart->addEIToCart($electronicItem3);

        $key = 0;
        $same = true;
        $shoppingCartList = $shoppingCart->getEIList();

        //compare each input data to the retrieved data from getEIList. they should have identical values
        foreach ($shoppingCartList as $item) {
            if ($itemDataArray[$key]['id'] == $item->get()->id &&
                $itemDataArray[$key]['serialNumber'] == $item->get()->serialNumber &&
                $itemDataArray[$key]['ElectronicSpecification_id'] == $item->get()->ElectronicSpecification_id &&
                $itemDataArray[$key]['User_id'] == $item->get()->User_id &&
                $itemDataArray[$key]['expiryForUser'] == $item->get()->expiryForUser) {
                $key++;
            } else {
                $same = false;
                break;
            }
        }
        $this->assertTrue($same && sizeof($shoppingCartList) == 3);

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
