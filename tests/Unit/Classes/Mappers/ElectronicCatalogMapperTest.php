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
    private $electronicSpecification;
    private $unitOfWorkMock;
    private $identityMapMock;
    private $eSData;
    private $eSData2;

    public function setUp()
    {
        parent::setUp();

        //creating an electronic catalog TDG mock
        $this->electronicCatalogTDGMock = $this
            ->getMockBuilder(ElectronicCatalogTDG::class)
            ->setMethods(
                ['insertElectronicSpecification',
                'updateElectronicSpecification',
                'deleteElectronicItem',
                'getESList',
                'insertElectronicItem'])
            ->getMock();


        //creating an electronic catalog TDG mock
        $this->electronicCatalogMock = $this
            ->getMockBuilder(ElectronicCatalog::class)
            ->disableOriginalConstructor()
            ->setMethods(
                ['makeElectronicItem',
                'getESList',
                'getElectronicSpecificationById'])
            ->getMock();


        //creating a unit of work mock
        $this->unitOfWorkMock = $this
            ->getMockBuilder(UnitOfWork::class)
            ->disableOriginalConstructor()
            ->setMethods(['registerNew', 'commit'])
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


        //creating an actual ElectronicSpecification data and creating a new electronicSpecification with that data
        $this->eSData = new \stdClass();
        $this->eSData->id = 1;
        //creating an actual ElectronicSpecification data and creating a new electronicSpecification with that data
        $this->eSData2 = new \stdClass();
        $this->eSData2->id = 2;
        //creating an ES and setting its data, this is not a mock
        $this->electronicSpecification = new ElectronicSpecification();
        $this->electronicSpecification->set($this->eSData);

    }

    public function tearDown()
    {
        parent::tearDown();
        $this->electronicCatalogMapper = null;
        $this->electronicCatalogMock = null;

    }

    public function testMockSaveES()
    {
        //insertElectronicSpecification is called in the saveES method of ElectronicCatalogMapper class
        $this->electronicCatalogTDGMock
            ->method('insertElectronicSpecification')
            ->willReturn($this->eSData);
        $returnedValue = $this->electronicCatalogMapper->saveES($this->electronicSpecification);
        $this->assertTrue($returnedValue->id == $this->eSData->id);
    }

    public function testMockUpdateES()
    {
        //updateElectronicSpecification is called in the saveES method of ElectronicCatalogMapper class
        $this->electronicCatalogTDGMock
            ->method('updateElectronicSpecification')
            ->willReturn($this->eSData);

        $returnedValue = $this->electronicCatalogMapper->updateES($this->electronicSpecification);
        $this->assertTrue($returnedValue->id == $this->eSData->id);

    }


    public function testMockdeleteES()
    {
        //deleteElectronicItem is called in the saveES method of ElectronicCatalogMapper class
        $this->electronicCatalogTDGMock
            ->method('deleteElectronicItem')
            ->willReturn($this->eSData);

        $returnedValue = $this->electronicCatalogMapper->deleteEI($this->electronicSpecification);
        $this->assertTrue($returnedValue->id == $this->eSData->id);

    }

//    public function testMockMakeNewElectronicSpecification()
//    {
//
//    }
//
//    public function testMockModifyElectronicSpecification()
//    {
//
//    }
//
//    public function testMockDeleteElectronicItems()
//    {
//
//    }

    public function testMockGetAllElectronicSpecifications()
    {
        $this->electronicCatalogMock
            ->method('getESList')
            ->willReturn(array($this->eSData));
        $returnedData = $this->electronicCatalogMapper->getAllElectronicSpecifications();
        $same = true;
        foreach ($returnedData as $eS)
        if ( $eS != $this->eSData)
        {
            $same = false;
            break;
        }
        $this->assertTrue($same);

    }

    public function testMockGetElectronicSpecification()
    {
        $this->electronicCatalogMock
            ->method('getElectronicSpecificationById')
            ->willReturn($this->eSData);
        $returnedData = $this->electronicCatalogMapper->getElectronicSpecification($this->eSData->id);
        $this->assertTrue( $returnedData == $this->eSData);

    }

    public function testMockGetESFilteredAndSortedByCriteria()
    {

    }

    public function testMockGetESByType()
    {
        $this->eSData->ElectronicType_name = 'Laptop';
        $this->eSData2->ElectronicType_name = 'Laptop';
        $this->electronicCatalogMock
            ->method('getESList')
            ->willReturn(array($this->eSData, $this->eSData2));

        //there exists 1 ES of type Laptop
        $retrievedESByType1 = $this->electronicCatalogMapper->getESByType('Laptop');
       // dd($retrievedESByType1);
        //there does not exists 1 ES of type Monitor
        $retrievedESByType2 = $this->electronicCatalogMapper->getESByType('Monitor');

        //there are two items of type laptop
        $onlyLaptops = true;
        foreach ($retrievedESByType1 as $each){
            if ($each->ElectronicType_name != 'Laptop'){
                $onlyLaptops = false;
                break;
            }
        }
        $this->assertTrue(sizeof($retrievedESByType1) == 2 && $onlyLaptops);
        $this->assertTrue(sizeof($retrievedESByType2) == 0 );

    }

    public function testGetAllEIForOnePurchaseForUssr()
    {
        $electronicItemData1 = new \stdClass();
        $electronicItemData2 = new \stdClass();
        $this->eSData->ElectronicType_name = 'Laptop';
        $this->eSData2->ElectronicType_name = 'Laptop';
        $electronicItemData1->User_id = 5;
        $electronicItemData2->User_id = 6;

    }
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

