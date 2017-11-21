<?php
/**
 * Created by PhpStorm.
 * User: Batoul
 * Date: 2017-11-20
 * Time: 1:17 PM
 */
namespace Tests\Unit;

use App\Classes\Core\ShoppingCart;
use App\Classes\Core\ElectronicItem;
use App\Classes\Core\TransactionCatalog;
use App\Classes\Core\User;
use Tests\TestCase;
use App\Classes\Core\Transaction;
use Hash;
use Illuminate\Support\Facades\Auth;

class TransactionTest extends TestCase {
    //tests purchase, set and get
    public function testGetAndSet(){
        //Create new transaction and transaction Catalog
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
        //var_dump($transactionList);
        //set values to the catalog
        $transactionCatalog->setTransactionList($transactionList);
        $gettingTransactions = $transactionCatalog->getTransactionList();
        var_dump($transactionList);

        var_dump($gettingTransactions);
        $this->assertTrue(sizeOf($gettingTransactions) == sizeOf($transactionList));
    }

}

