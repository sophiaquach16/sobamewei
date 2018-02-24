<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Classes\Mappers\ShoppingCartMapper;

class ShoppingCartMapperTest extends TestCase{
    public function setUp(){
        $this->shoppingCartMapper = new ShoppingCartMapper(-1);
        $this->shoppingCartMapper->shoppingCart = new MockShoppingCart();
        $this->shoppingCartMapper->shoppingCartTDG = new MockShoppingCartTDG();
        $this->shoppingCartMapper->unitOfWork = new MockUnitOfWork();
        $this->shoppingCartMapper->identityMap = new MockIdentityMap();
        $this->shoppingCartMapper->electronicCatalog = new MockElectronicCatalog(); 
    }

    public function testAddToCart(){
        $esid = 5;
        $userId = 5;
        $expire ='never';
        $result = $this->shoppingCartMapper->addToCart($esid, $userId, $expire); 
        $expected_result = 'shoppingCartFull';
        $this->assertTrue($result === $expected_result);
    }

    public function testUpdateEI(){
        $ei = new MockElectronicItem;
        $result = $this->shoppingCartMapper->updateEI($ei);
        $this->assertTrue($result);
    }

    public function testViewCart(){
        $result = $this->shoppingCartMapper->viewCart();
        $es = new MockElectronicSpecification();
        $this->assertTrue($result->id === $es->id);
    }

    public function testRemoveFromCart(){
        $eSId = 55;
        $userId = 4;
        $result = $this->shoppingCartMapper->removeFromCart($eSId, $userId);
        $expected_result = "Item Removed";
        $this->assertTrue($result === $expected_result);
    }
}
 
