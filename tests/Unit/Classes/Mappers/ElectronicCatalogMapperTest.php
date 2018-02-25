<?php

namespace Tests\Unit;

use App\Classes\Core\ElectronicCatalog;
use App\Classes\Core\ElectronicSpecification;
use App\Classes\IdentityMap;
use App\Classes\Mappers\ElectronicCatalogMapper;
use App\Classes\TDG\ElectronicCatalogTDG;
use App\Classes\UnitOfWork;
use Tests\TestCase;

class ElectronicCatalogMapperTest extends TestCase
{
    private $electronicCatalogMapper;
    private $electronicCatalogTDGMock;
    private $electronicCatalogMock;
    private $unitOfWorkMock;
    private $identityMapMock;

    public function setUp()
    {
        parent::setUp();

        //creating an electronic catalog TDG mock
        $this->electronicCatalogTDGMock = $this
            ->getMockBuilder(ElectronicCatalogTDG::class)
            ->setMethods(
                ['insertElectronicSpecification',
                'updateElectronicSpecification'])
            ->getMock();


        //creating an electronic catalog TDG mock
        $this->electronicCatalogMock = $this
            ->getMockBuilder(ElectronicCatalog::class)
            ->disableOriginalConstructor()
            ->getMock();


        //creating a unit of work mock
        $this->unitOfWorkMock = $this
            ->getMockBuilder(UnitOfWork::class)
            ->disableOriginalConstructor()
            ->getMock();

        //creating an identity map mock
        $this->identityMapMock = $this
            ->getMockBuilder(IdentityMap::class)
            ->disableOriginalConstructor()
            ->getMock();


        //creating an actual ElectronicCatalogMapper and passing mock data
        $this->electronicCatalogMapper = new ElectronicCatalogMapper(
            $this->electronicCatalogTDGMock,
            $this->electronicCatalogMock,
            $this->unitOfWorkMock,
            $this->identityMapMock);
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->electronicCatalogMapper = null;

    }

    public function testMockSaveES()
    {
        //creating an ES and setting its data, this is not a mock
        $electronicSpecification = new ElectronicSpecification();
        $eSData = new \stdClass();
        $eSData->id = 1;
        $electronicSpecification->set($eSData);

        //insertElectronicSpecification is called in the saveES method of ElectronicCatalogMapper class
        $this->electronicCatalogTDGMock
            ->method('insertElectronicSpecification')
            ->willReturn($eSData);

        $returnedValue = $this->electronicCatalogMapper->saveES($electronicSpecification);
        $this->assertTrue($returnedValue->id == $eSData->id);
    }

    public function testMockUpdateES()
    {
        $electronicSpecification = new ElectronicSpecification();
        $eSData = new \stdClass();
        $eSData->id = 1;
        $electronicSpecification->set($eSData);

        //insertElectronicSpecification is called in the saveES method of ElectronicCatalogMapper class
        $this->electronicCatalogTDGMock
            ->method('updateElectronicSpecification')
            ->willReturn($eSData);

        $returnedValue = $this->electronicCatalogMapper->updateES($electronicSpecification);
        $this->assertTrue($returnedValue->id == $eSData->id);

    }

//    public function testUpdateES(){
//        $result = $this->electronicCatalogMapper->updateES($this->mockES);
//        $this->assertNotFalse($result);
//    }
//
//    public function testDeleteEI(){
//        $result = $this->electronicCatalogMapper->deleteEI($this->mockEI);
//        $this->assertNotFalse($result);
//    }
//
//    public function testMakeNewElectronicSpecification(){
//        $quantity = 1;
//        $result = $this->electronicCatalogMapper->makeNewElectronicSpecification($quantity, $this->mockES);
//        $this->assertFalse($result);
//    }
//
//    public function testModifyElectronicSpecification(){
//        $quantity = 1;
//        $ES1 = new MockElectronicSpecification();
//        $ES2 = new MockElectronicSpecification();
//        $result = $this->electronicCatalogMapper->modifyElectronicSpecification($quantity, $ES1, $ES2);
//        $this->assertTrue($result);
//    }
//
//    public function testDeleteElectronicItems(){
//        $ei = new MockElectronicItem();
//        $eiList = array($ei);
//        $result = $this->electronicCatalogMapper->deleteElectronicItems($eiList);
//        $this->assertTrue($result);
//    }
//
//    public function testGetAllElectronicSpecifications(){
//        $result = $this->electronicCatalogMapper->getAllElectronicSpecifications();
//        $this->assertTrue($result === array());
//    }
//
//    public function testGetElectronicSpecification(){
//        $result = $this->electronicCatalogMapper->getElectronicSpecification($this->mockES->id);
//        $this->assertTrue($result->id === $this->mockES->id);
//        $this->assertTrue($result->modelNumber === $this->mockES->modelNumber);
//        $this->assertTrue($result->ElectronicType_id === $this->mockES->ElectronicType_id);
//    }
//
//    public function testGetESFilteredAndSortedByCriteria(){
//        $result = $this->electronicCatalogMapper->getESFilteredAndSortedByCriteria(null, array(), null);
//        $this->assertTrue(array() === $result);
//    }
//
//    public function testGetESByType(){
//        $result = $this->electronicCatalogMapper->getESByType(null);
//        $this->assertTrue(array() === $result);
//    }
//
//    public function testGetAllEIForOnePurchaseForUser(){
//        $userId = 9242;
//        $result = $this->electronicCatalogMapper->getAllEIForOnePurchaseForUser($userId);
//        $this->assertTrue(array() === $result);
//    }
//
//    public function testAddReturnedEI(){
//        $item_id = 99;
//        $sn = 99;
//        $es = "example_es";
//        $result = $this->electronicCatalogMapper->addReturnedEI($item_id, $sn, $es);
//        $this->assertTrue($result);
//    }
//
//    public function testSaveEI(){
//        $result = $this->electronicCatalogMapper->saveEI($this->mockEI);
//        $this->assertTrue($result);
//    }
}

