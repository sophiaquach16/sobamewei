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


class TransactionCatalogTest extends TestCase {

    public function testGetAndSet(){
        //Create new transaction and TransactionCatalog
        $transaction1 = new Transaction();
        $transaction2 = new Transaction();
        $transactionCatalog = new TransactionCatalog();

        $data1 = new \stdClass();
        $data2 = new \stdClass();

        $data1->item_id='1';
        $data1->customer_id='1';
        $data1->serialNumber="123";
        $data1->ElectronicSpec_id='1';
        $data1->timestamp="2017-12-12 11:11:11";

        $transaction1->set($data1);

        $data2->item_id='2';
        $data2->customer_id='1';
        $data2->serialNumber="345";
        $data2->ElectronicSpec_id='2';
        $data2->timestamp="2017-12-12 11:11:11";

        $transaction2->set($data2);

        $transactionList = array($transaction1,$transaction2);

        //set values to the catalog
        $transactionCatalog->setTransactionList($transactionList);
        $gettingTransactions = $transactionCatalog->getTransactionList();

        //Check if size is same for both
        $this->assertTrue(sizeOf($gettingTransactions) == sizeOf($transactionList));
    }
    
    function testGetTransactionObjectByItemId(){

        $transaction1 = new Transaction();
        $transaction2 = new Transaction();
        $transactionCatalog = new TransactionCatalog();
        $data1 = new \stdClass();
        $data2 = new \stdClass();
        $data1->item_id='1';
        $data1->customer_id='1';
        $data1->serialNumber="123";
        $data1->ElectronicSpec_id='1';
        $data1->timestamp="2017-12-12 11:11:11";
        $transaction1->set($data1);
        $data2->item_id='2';
        $data2->customer_id='1';
        $data2->serialNumber="345";
        $data2->ElectronicSpec_id='2';
        $data2->timestamp="2017-12-12 11:11:11";
        $transaction2->set($data2);
        $transactionList = array($transaction1,$transaction2);
        //set values to the catalog
        $transactionCatalog->setTransactionList($transactionList);

        $item_id='1';
        $transaction = $transactionCatalog->getTransactionObjectByItemId($item_id);
        $this->assertTrue($transaction == $transaction1);
         }

    public function testGetTransactionByItemId(){
        $transaction1 = new Transaction();
        $transaction2 = new Transaction();
        $transactionCatalog = new TransactionCatalog();

        $data1 = new \stdClass();
        $data2 = new \stdClass();

        $data1->item_id='1';
        $data1->customer_id='1';
        $data1->serialNumber="123";
        $data1->ElectronicSpec_id='1';
        $data1->timestamp="2017-12-12 11:11:11";

        $transaction1->set($data1);

        $data2->item_id='2';
        $data2->customer_id='1';
        $data2->serialNumber="345";
        $data2->ElectronicSpec_id='2';
        $data2->timestamp="2017-12-12 11:11:11";

        $transaction2->set($data2);

        $transactionList = array($transaction1,$transaction2);

        //set values to the catalog
        $transactionCatalog->setTransactionList($transactionList);
        $transaction = $transactionCatalog->getTransactionObjectByItemId($data1->item_id);
        $this->assertTrue($transaction->get()->item_id == $data1->item_id);


    }

}

