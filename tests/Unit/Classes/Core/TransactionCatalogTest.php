<?php
/**
 * Created by PhpStorm.
 * User: Batoul
 * Date: 2017-11-20
 * Time: 1:17 PM
 */

namespace Tests\Unit;

use App\Classes\Core\TransactionCatalog;
use Tests\TestCase;
use App\Classes\Core\Transaction;
use Hash;


class TransactionCatalogTest extends TestCase
{
    public function setUp(){
        parent::setUp();


        $this-> transactionCatalog = new TransactionCatalog();

        $this->transaction1 = $this
            ->getMockBuilder(Transaction::class)
            ->setMethods(['get'])
            ->getMock();

        $this->transaction2 = $this
            ->getMockBuilder(Transaction::class)
            ->setMethods(['get'])
            ->getMock();
    }

    //Didn't Mock anything in testGetandSet as testing Getters and Setters is trivial. On top of that,
    // The method in transasctionCatalog setTransactionList($InputArray) returns a transaction itself which would
    //defeat the point of mocking this one method.
    public function testGetAndSet()
    {


        $transactionCatalog = new TransactionCatalog();

        $data1 = new \stdClass();
        $data2 = new \stdClass();

        $data1->item_id = '1';
        $data1->customer_id = '1';
        $data1->serialNumber = "123";
        $data1->ElectronicSpec_id = '1';
        $data1->timestamp = "2017-12-12 11:11:11";


        $data2->item_id = '2';
        $data2->customer_id = '1';
        $data2->serialNumber = "345";
        $data2->ElectronicSpec_id = '2';
        $data2->timestamp = "2017-12-12 11:11:11";


        $transactionList = array($data1 , $data2);
        //convert each std object to another array

        //set values to the catalog
        $this -> transactionCatalog->setTransactionList($transactionList);
        $gettingTransactions = $this -> transactionCatalog->getTransactionList();

        //convert retrieved list to array
        foreach ($gettingTransactions as $key => $value) {
            $gettingTransactions[$key] = (array)$gettingTransactions[$key];
        }

        //convert each data to array
        $array1 = (array)$data1;
        $array2 = (array)$data2;
        //put both datas in another array
        $inputDataArray = array($array1, $array2);

        $same = true;
        //compare 2 arrays for same attribute values
        foreach ($gettingTransactions as $key => $value) {
            foreach ($value as $innerkey => $innervalue) {
                if ($gettingTransactions[$key][$innerkey] == $inputDataArray[$key][$innerkey]) {
                } else {
                    $same = false;
                    break;
                }
            }
        }
        $this->assertTrue($same);
    }

    //only need 1 return object, which can be mocked using one of the mocked instance in the Setup()
    function MockGetTransactionObjectByItemId()
    {

        $data1 = new \stdClass();
        $data2 = new \stdClass();
        $data1->item_id = '1';
        $data1->customer_id = '1';
        $data1->serialNumber = "123";
        $data1->ElectronicSpec_id = '1';
        $data1->timestamp = "2017-12-12 11:11:11";

        $data2->item_id = '2';
        $data2->customer_id = '1';
        $data2->serialNumber = "345";
        $data2->ElectronicSpec_id = '2';
        $data2->timestamp = "2017-12-12 11:11:11";

        $this->transaction2 ->method('get') -> willReturn($data1);
        $this -> transactionList = array($this -> $data1, $this->$data2);
        //set values to the catalog

        $this -> transactionCatalog->setTransactionList($this ->transactionList);

        $item_id = '1';
        $this->transaction1 -> method('get') -> willReturn($this -> transactionCatalog->getTransactionObjectByItemId($item_id));
        $this->assertTrue($this->transaction2 == $this->transaction1  );
    }

    //Didn't mock this method because the return value is an Array of n Transactions for a certain item
    //This means that it can't be known in advance how many mock this method will need, making it impossible to mock the return value
    public function testGetTransactionByItemId()
    {

        $transactionCatalog = new TransactionCatalog();

        $data1 = new \stdClass();
        $data2 = new \stdClass();

        $data1->item_id = '1';
        $data1->customer_id = '1';
        $data1->serialNumber = "123";
        $data1->ElectronicSpec_id = '1';
        $data1->timestamp = "2017-12-12 11:11:11";



        $data2->item_id = '2';
        $data2->customer_id = '1';
        $data2->serialNumber = "345";
        $data2->ElectronicSpec_id = '2';
        $data2->timestamp = "2017-12-12 11:11:11";


        $transactionList = array($data1, $data2);

        //set values to the catalog
        $transactionCatalog->setTransactionList($transactionList);
        $transactions = $transactionCatalog->getTransactionObjectByItemId($data1->item_id);

        //ensure the item id of the retrieved transaction is equal to the item id of the passed transaction
        $sameitemId = true;

        foreach ($transactions as $transaction) {
            if ($transaction->get()->item_id == $data1->item_id) {
            } else {
                $sameitemId = false;
                break;
            }
        }
        $this->assertTrue($sameitemId);

    }

    //Didn't mock this method because the return value is an Array of n Transactions for a certain item
    //This means that it can't be known in advance how many mock this method will need, making it impossible to mock the return value
    public function testGetTransactionsByUserIdAndTimestamp()
    {

        $transactionCatalog = new TransactionCatalog();

        $data1 = new \stdClass();
        $data2 = new \stdClass();

        $data1->item_id = '1';
        $data1->customer_id = '1';
        $data1->serialNumber = "123";
        $data1->ElectronicSpec_id = '1';
        $data1->timestamp = "2017-12-12 11:11:11";


        $data2->item_id = '2';
        $data2->customer_id = '1';
        $data2->serialNumber = "345";
        $data2->ElectronicSpec_id = '2';
        $data2->timestamp = "2017-12-12 11:11:11";


        $transactionList = array($data1, $data2);

        //set values to the catalog
        $transactionCatalog->setTransactionList($transactionList);

        $gettingTransaction = $transactionCatalog->getTransactionsByUserIdAndTimestamp($data1->customer_id, $data1->timestamp);

        //ensure all timestamps and customer_id for purchases are identical and we know there are 2 purchases with
        // the same timestamp and customer id therefore size of purchase is 2
        $sameCustomerIdAndTimeStamp = true;

        foreach ($gettingTransaction as $transaction) {
            if ($transaction->get()->customer_id == $data1->customer_id &&
                $transaction->get()->timestamp == $data1->timestamp) {
            } else {
                $sameCustomerIdAndTimeStamp = false;
                break;
            }
        }
        $this->assertTrue($sameCustomerIdAndTimeStamp && sizeof($gettingTransaction) == 2);
    }

    function testGetTransactionListForUser()
    {
        //create 2 transactions with the same user id

        $transactionCatalog = new TransactionCatalog();
        $data1 = new \stdClass;
        $data2 = new \stdClass;
        $data1->item_id = '1';
        $data1->customer_id = '1';
        $data1->serialNumber = "123";
        $data1->ElectronicSpec_id = '1';
        $data1->timestamp = "2017-12-12 11:11:11";


        $data2->item_id = '2';
        $data2->customer_id = '12';
        $data2->serialNumber = "345";
        $data2->ElectronicSpec_id = '2';
        $data2->timestamp = "2017-12-12 11:11:11";

        $transactionList = array($data1, $data2);
        //set values to the catalog
        $transactionCatalog->setTransactionList($transactionList);

        //returns an array std object wiht all transactions for the id $data1->customer_id
        $transactionListForUser = $transactionCatalog->getTransactionListForUser($data1->customer_id);

        //convert each std object to another array
        foreach ($transactionListForUser as $key => $value) {
            $transactionListForUser[$key] = ((array)$transactionListForUser[$key]);
        }

        $sameCustomerId = true;

        foreach ($transactionListForUser as $key => $value) {
            foreach ($value as $innerkey => $innervalue) {
                //check if all transactions have the same customer_id as given to the method getTransactionListForUser
                if (($transactionListForUser[$key]['customer_id'] == $data1->customer_id)) {
                } else {
                    $sameCustomerId = false;
                    break;
                }
            }
        }
        //asserting all purchases have the same customer id as given and in this case this should only return 1 purchase
        // corresponding to that id
        $this->assertTrue($sameCustomerId && sizeof($transactionListForUser) == 1);
    }
}