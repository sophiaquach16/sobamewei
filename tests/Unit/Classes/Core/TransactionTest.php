<?php
/**
 * Created by PhpStorm.
 * User: Batoul
 * Date: 2017-11-20
 * Time: 1:12 PM
 */

namespace Tests\Unit;

use App\Classes\Core\ShoppingCart;
use App\Classes\Core\ElectronicItem;
use App\Classes\Core\User;
use Tests\TestCase;
use App\Classes\Core\Transaction;
use Hash;
use Illuminate\Support\Facades\Auth;

class TransactionTest extends TestCase {
    //This tests get, set, and purchase from the Transaction class


    public function setUp(){

        parent::setUp();

        $this-> userMock = $this
            ->getMockBuilder(User::class)
            ->setMethods(['get'])
            ->getMock();


        $this->shoppingCart = ShoppingCart::getInstance();

        $this->electronicItemMock1 = $this
            ->getMockBuilder(ElectronicItem::class)
            ->setMethods(['get'])
            ->getMock();

    }
    public function testGetAndSet(){
        //create a transaction
        $transaction = new Transaction();
        $transactionData = new \stdClass();
        $transactionData->timestamp = "2017-12-12 12:12:12";
        $transactionData->item_id = '1';
        $transactionData->customer_id='1';
        $transactionData->serialNumber="123";
        $transactionData->ElectronicSpec_id='1';

        $transaction->set($transactionData);

        $result = true;
        foreach ($transactionData as $key => $value) {
            if ($transactionData->$key !== $transaction->get()->$key) {
                $result = false;
            }
        }
        $this->assertTrue($result);
    }

    public function testPurchase(){
        //Create user

        $userData = new \stdClass();

        $userData->id = '1';
        $userData->firstName = 'John';
        $userData->lastName = 'Doe';
        $userData->email = 'johndoe123@gmail.com';
        $userData->phone = '123-456-7890';
        $userData->admin = '0';
        $userData->physicalAddress = '1234 Wallstreet';
        $userData->password = 'password123';

        $this-> userMock->method('get') ->willReturn($userData);

        $this->be($this->userMock);

        $shoppingCart = ShoppingCart::getInstance();
        //create an item
        $item1Data = new \stdClass();
        $item1Data->id="1";
        $item1Data->serialNumber = 123;
        $item1Data->ElectronicSpecification_id = "1";
        $item1Data->User_id='1';
        $item1Data->expiryForUser='2017-12-25 12:12:12';

        $this->electronicItemMock1->method('get')->willReturn($item1Data);



        ($this->shoppingCart->addEIToCart($this->electronicItemMock1));



        $shoppingList = $this->shoppingCart->getEIList();

        //create a transaction
        $transaction = new Transaction();
        $transactionData = new \stdClass();
        $transactionData->timestamp = "2017-12-12 12:12:12";
        $transactionData->item_id = '1';
        $transactionData->customer_id='1';
        $transactionData->serialNumber="123";
        $transactionData->ElectronicSpec_id='1';

        $transaction->set($transactionData);

        dump($this->electronicItemMock1);

        $purchaseItems = $transaction->purchase('1'); //list of purchased items

        //tests if the transaction and the shopping cart items are matching
        $this->assertTrue($purchaseItems == $shoppingList);
    }

    public function testGetSetTimestamp(){
        //create a transaction
        $transaction = new Transaction();
        $transactionData = new \stdClass();
        $transactionData->item_id = '1';
        $transactionData->customer_id='1';
        $transactionData->serialNumber="123";
        $transactionData->ElectronicSpec_id='1';

        $transaction->set($transactionData);

        $transaction->setTimeStamp("2017-12-12 12:12:12");
        $this->assertTrue($transaction->getTimeStamp() == "2017-12-12 12:12:12");
    }


}