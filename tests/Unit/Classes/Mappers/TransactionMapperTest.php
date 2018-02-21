<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Classes\Mappers\TransactionMapper;

class TransactionMapperTest extends TestCase{
    public function setUp(){
        $this->transactionMapper = new TransactionMapper(-1);
        $this->transactionMapper->transactionCatalog = new MockTransactionCatalog();
        $this->transactionMapper->transactionTDG = new MockTransactionTDG();
        $this->transactionMapper->unitOfWork = new MockUnitOfWork();
        $this->transactionMapper->identityMap = new MockIdentityMap();
    }

    public function testGetAllTransactions(){
        $user_id = 459;
        $mockTransaction = new MockTransaction();
        $result = $this->transactionMapper->getAllTransactions($user_id);
        $this->assertTrue($mockTransaction->serialNumber === $result->serialNumber);
    }

    public function testGetTransactionByItemId(){
        $tr_id = 3232;
        $mockTransaction = new MockTransaction();
        $result = $this->transactionMapper->transactionCatalog->getTransactionByItemId($tr_id);
        $this->assertTrue($mockTransaction->serialNumber === $result->serialNumber);
    }

    public function testMakeNewTransaction(){
        $timestamp = 9999;
        $ei = new MockElectronicItem();
        $result = $this->transactionMapper->makeNewTransaction($timestamp, array($ei));
        $this->assertTrue($result === "transactionFailed");
    }

    public function testSaveTransaction(){
        $mockTransaction = new MockTransaction();
        $result = $this->transactionMapper->saveTransaction($mockTransaction);
        $this->assertNotFalse($result);
    }

    public function testReturnPurchase(){
        $item_id = 43;
        $result = $this->transactionMapper->ReturnPurchase($item_id);
        $this->assertTrue($result === "purchaseReturned");
    }

    public function testDeleteTransaction(){
        $tr = 323;
        $result = $this->transactionMapper->deleteTransaction($tr);
        $this->assertTrue($result);
    } 
}

