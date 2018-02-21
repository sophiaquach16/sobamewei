<?php

namespace Tests\Unit;
use Tests\TestCase;
use App\Classes\Mappers\ElectronicCatalogMapper;

class ElectronicCatalogMapperTest extends TestCase {
    public function setUp(){
        $this->electronicCatalogMapper = new ElectronicCatalogMapper();
        $this->electronicCatalogMapper->electronicCatalog = new MockElectronicCatalog();
        $this->electronicCatalogMapper->electronicCatalogTDG  = new MockElectronicCataLogTDG();
        $this->electronicCatalogMapper->unitOfWork = new MockUnitOfWork();
        $this->electronicCatalogMapper->identityMap = new MockIdentityMap();

        $this->mockEI = new MockElectronicItem();
        $this->mockES = new MockElectronicSpecification();
    }        

    public function testSaveES(){
        $result = $this->electronicCatalogMapper->saveES($this->mockES);
        $this->assertNotFalse($result);
    }   

    public function testUpdateES(){
        $result = $this->electronicCatalogMapper->updateES($this->mockES);
        $this->assertNotFalse($result); 
    }

    public function testDeleteEI(){
        $result = $this->electronicCatalogMapper->deleteEI($this->mockEI);
        $this->assertNotFalse($result);
    }

    public function testMakeNewElectronicSpecification(){
        $quantity = 1;
        $result = $this->electronicCatalogMapper->makeNewElectronicSpecification($quantity, $this->mockES); 
        $this->assertFalse($result);    
    }

    public function testModifyElectronicSpecification(){
        $quantity = 1;
        $ES1 = new MockElectronicSpecification();
        $ES2 = new MockElectronicSpecification();
        $result = $this->electronicCatalogMapper->modifyElectronicSpecification($quantity, $ES1, $ES2);
        $this->assertTrue($result);
    }

    public function testDeleteElectronicItems(){
        $ei = new MockElectronicItem();
        $eiList = array($ei);
        $result = $this->electronicCatalogMapper->deleteElectronicItems($eiList);
        $this->assertTrue($result);
    }

    public function testGetAllElectronicSpecifications(){
        $result = $this->electronicCatalogMapper->getAllElectronicSpecifications();
        $this->assertTrue($result === array());
    }

    public function testGetElectronicSpecification(){        
        $result = $this->electronicCatalogMapper->getElectronicSpecification($this->mockES->id);
        $this->assertTrue($result->id === $this->mockES->id);
        $this->assertTrue($result->modelNumber === $this->mockES->modelNumber);
        $this->assertTrue($result->ElectronicType_id === $this->mockES->ElectronicType_id);
    }

    public function testGetESFilteredAndSortedByCriteria(){
        $result = $this->electronicCatalogMapper->getESFilteredAndSortedByCriteria(null, array(), null);
        $this->assertTrue(array() === $result);
    }

    public function testGetESByType(){
        $result = $this->electronicCatalogMapper->getESByType(null);
        $this->assertTrue(array() === $result);
    }

    public function testGetAllEIForOnePurchaseForUser(){
        $userId = 9242;
        $result = $this->electronicCatalogMapper->getAllEIForOnePurchaseForUser($userId);
        $this->assertTrue(array() === $result);
    }

    public function testAddReturnedEI(){
        $item_id = 99;
        $sn = 99;
        $es = "example_es";
        $result = $this->electronicCatalogMapper->addReturnedEI($item_id, $sn, $es);
        $this->assertTrue($result);
    }

    public function testSaveEI(){
        $result = $this->electronicCatalogMapper->saveEI($this->mockEI);
        $this->assertTrue($result);
    }
}

