<?php

namespace Tests\Unit;
use Tests\TestCase;
use App\Classes\TDG\TransactionTDG;

class TransactionTDGTest extends TestCase {
    public function setUp(){
        $this->mockTransaction = new MockTransaction();
        $this->transactionTDG = new TransactionTDG();
        $this->transactionTDG->conn = new MockMySQLConnection();
    }

    public function testFindAll(){
        $this->transactionTDG->findAll();
        $result_query = $this->transactionTDG->conn->query_string;
        $expected_query = "SELECT * FROM Transaction";
        $this->assertTrue($result_query === $expected_query);
    }
    
    public function testAddTransaction(){
        $timestamp = 888888;
        $this->transactionTDG->addTransaction($this->mockTransaction, $timestamp);
        $result_query = $this->transactionTDG->conn->query_string;
        $expected_query = "INSERT INTO Transaction SET ElectronicSpec_id = :ElectronicSpec_id , item_id = :item_id , serialNumber = :serialNumber , timestamp = :timestamp , customer_id = :customer_id ";
        $this->assertTrue($result_query === $expected_query);
    }

    public function testDeleteTransaction(){
        $this->transactionTDG->deleteTransaction($this->mockTransaction);
        $result_query = $this->transactionTDG->conn->query_string;
        $expected_query = "DELETE FROM Transaction WHERE item_id = :item_id";
        $this->assertTrue($result_query === $expected_query);
    } 
} 
