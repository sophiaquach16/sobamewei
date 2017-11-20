<?php

namespace Tests\Unit;

use App\Classes\Core\ShoppingCart;
use App\Classes\TDG\ShoppingCartTDG;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\Core\ElectronicItem;
use Illuminate\Support\Facades\Auth;
use App\Classes\Core\User;

class ShoppingCartTDGTest extends TestCase {
    //Tests for: updateEI, findAllEIFromUser,addTransaction

    public function testUpdateEI(){

        $ShoppingCartTDG = new ShoppingCartTDG();
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

        //Creation of a ShoppingCart
        $ShoppingCart = ShoppingCart::getInstance();
        //Logging in the user
        Auth::login($user);
        Auth::check();

        //Creation of an electronic item
        $electronicItem1 = new ElectronicItem();

        $item1Data = new \stdClass();
        $item1Data->id='1';
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "1";
        $item1Data->User_id='1';
        $item1Data->expiryForUser='2017-12-25 12:12:12';

        $electronicItem1->set($item1Data);

        $listOfItems = array($electronicItem1);
        $ShoppingCart->setEIList($listOfItems);

        $ShoppingCartTDG->updateEI($electronicItem1);
        //var_dump($ShoppingCartTDG);

        $this->assertDatabaseHas('electronicitem',[
            'id'=>'1',
            'serialNumber'=>123,
            'ElectronicSpecification_id'=>"1",
            'User_id'=>'1',
            'expiryForUser'=>"2017,12,25 12:12:12",
        ]);
    }
    public function testFindAllEIFromUser(){
        $ShoppingCartTDG = new ShoppingCartTDG();
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

        //Creation of a ShoppingCart
        $ShoppingCart = ShoppingCart::getInstance();
        //Logging in the user
        Auth::login($user);
        Auth::check();

        //Creation of Items
        $electronicItem1 = new ElectronicItem();
        $electronicItem2 = new ElectronicItem();
        $electronicItem3 = new ElectronicItem();

        $item1Data = new \stdClass();
        $item1Data->id='1';
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "1";
        $item1Data->User_id='1';
        $item1Data->expiryForUser='2017-12-25 12:12:12';

        $electronicItem1->set($item1Data);

        $item2Data = new \stdClass();

        $item2Data->id='2';
        $item2Data->serialNumber = 234;
        $item2Data->ElectronicSpecification_id = "2";
        $item2Data->User_id='1';
        $item2Data->expiryForUser='2017-12-25 12:12:12';

        $electronicItem2->set($item2Data);

        $item3Data = new \stdClass();
        $item3Data->id='3';
        $item3Data->serialNumber = 345;
        $item3Data->ElectronicSpecification_id = "1";
        $item3Data->User_id='1';
        $item3Data->expiryForUser='2017-12-25 12:12:12';

        $electronicItem3->set($item3Data);
        $itemsList = array($electronicItem1,$electronicItem2,$electronicItem3);
        $ShoppingCart->setEIList($itemsList);
        $itemsFromUser = $ShoppingCartTDG->findAllEIFromUser('1');
        //var_dump($itemsFromUser);
        $this->assertTrue($itemsFromUser == $itemsList);
    }

}