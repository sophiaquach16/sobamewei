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
    //tests purchase, get, set

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


}