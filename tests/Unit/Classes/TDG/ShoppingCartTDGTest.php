<?php

namespace Tests\Unit;

use App\Classes\TDG\ShoppingCartTDG;
use Tests\TestCase;

class ShoppingCartTDGTest extends TestCase {
    
    public function setUp(){
        $this->mockUser = new MockUser();
        $this->mockEI = new MockElectronicItem();
        $this->shoppingCartTDG = new ShoppingCartTDG();
        $this->shoppingCartTDG->conn = new MockMySQLConnection();
    }

    public function testFindAllEIFromUser(){
        $userId = $this->mockUser->id;
        $items = $this->shoppingCartTDG->findAllEIFromUser($userId);
        $expected_query = "SELECT ElectronicItem.id, serialNumber, ElectronicSpecification_id, User_id, expiryForUser FROM ElectronicItem  JOIN User ON ElectronicItem.User_id = User.id WHERE User.id = 999";
        $result_query = $this->shoppingCartTDG->conn->query_string;
        $this->assertTrue($expected_query === $result_query);
    }

    public function testUpdateEI(){
        $this->shoppingCartTDG->updateEI($this->mockEI);
        $result_query = $this->shoppingCartTDG->conn->query_string;
        $expected_query = "UPDATE ElectronicItem SET User_id = 58, expiryForUser= 'never' WHERE id= 1";
        $this->assertTrue($expected_query === $result_query);
    }
}
