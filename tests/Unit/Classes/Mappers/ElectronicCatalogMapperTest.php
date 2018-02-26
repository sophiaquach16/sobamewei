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
                    'getElectronicSpecificationById',
                    'makeElectronicSpecification',
                    'modifyElectronicSpecification',
                    'findElectronicSpecification'])
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
        $this->electronicCatalogMock = null;
        $this->unitOfWorkMock = null;
        $this->identityMapMock = null;


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

    public function testMockMakeNewElectronicSpecification()
    {
        $this->eSData->modelNumber = 5;

        //false is set to signify that the electronicSpecification does not exist yet
        $this->electronicCatalogMock
            ->method('findElectronicSpecification')
            ->willReturn(false);

        //set stub data for creating an electronic specification
        //electronicCatalog's mehod 'makeElectronicSpecification' is called in ElectronicCatalogMapper
        $this->electronicCatalogMock
            ->method('makeElectronicSpecification')
            ->willReturn($this->eSData);

        //since it does NOT exist, you should be able to make a new one
        $successfullyMadeNewElectronicSpecification =
            $this->electronicCatalogMapper->makeNewElectronicSpecification(1, $this->eSData);
        $this->assertTrue($successfullyMadeNewElectronicSpecification);

    }


//    public function testMockModifyElectronicSpecification()
//    {
//       //mocking issue in presence of a constructor with parameters
//        $this->eSData->modelNumber = 5;
//        $this->eSData->image = "/path/to/image";
//
//        //true is set to signify that the electronicSpecification does not exist
//        $this->electronicCatalogMock
//            ->method('findElectronicSpecification')
//            ->willReturn(true);
//
//        $this->electronicCatalogMock
//            ->method('getElectronicSpecificationById')
//            ->willReturn($this->eSData);
//
//        $this->electronicCatalogMock
//            ->method('modifyElectronicSpecification')
//            ->willReturn($this->eSData);
//
////        $this->unitOfWorkMock
////            ->method('registerDirty')
////            ->willReturn($this->eSData);
//        //creating a unit of work mock
//        $array = array($this->electronicCatalogMapper);
//        $this->unitOfWorkMock = $this
//            ->getMockBuilder(UnitOfWork::class)
//            ->setConstructorArgs($array)
//            ->setMethods(['registerNew', 'commit'])
//            ->getMock();
//
//
//        $successfullyModifiedElectronicSpecificaton =
//            $this->electronicCatalogMapper->modifyElectronicSpecification (1, $this->eSData, $this->eSData);
//
//        $this->assertTrue($successfullyModifiedElectronicSpecificaton);
//
//    }


//the method below does not need to be mocked because it will always return True
//    public function testMockDeleteElectronicItems()
//    {
//    }

    public function testMockGetAllElectronicSpecifications()
    {
        $this->electronicCatalogMock
            ->method('getESList')
            ->willReturn(array($this->eSData));
        $returnedData = $this->electronicCatalogMapper->getAllElectronicSpecifications();
        $same = true;
        foreach ($returnedData as $eS)
            if ($eS != $this->eSData) {
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
        $this->assertTrue($returnedData == $this->eSData);

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
        foreach ($retrievedESByType1 as $each) {
            if ($each->ElectronicType_name != 'Laptop') {
                $onlyLaptops = false;
                break;
            }
        }
        $this->assertTrue(sizeof($retrievedESByType1) == 2 && $onlyLaptops);
        $this->assertTrue(sizeof($retrievedESByType2) == 0);

    }

    public function testGetAllEIForOnePurchaseForUser()
    {
        $userIdSearch = 5;
        $electronicItemData1 = new \stdClass();
        $electronicItemData1->User_id = 5;

        $electronicItemData2 = new \stdClass();
        $electronicItemData2->User_id = 6;

        $electronicItemData3 = new \stdClass();
        $electronicItemData3->User_id = 5;

        $this->eSData->electronicItems = array($electronicItemData1, $electronicItemData2, $electronicItemData3);

        $this->electronicCatalogMock
            ->method('getESList')
            ->willReturn(array($this->eSData));
        //  dd($this->eSData);
        $purchasedEI = $this->electronicCatalogMapper->getAllEIForOnePurchaseForUser($userIdSearch);

        $correctUserId = true;
        foreach ($purchasedEI as $each) {
            if ($each->User_id != $userIdSearch) {
                $correctUserId = false;
                break;
            }
        }
        $this->assertTrue($correctUserId, sizeof($purchasedEI) == 2);

    }
}

//cannot test addReturnedEI or saveEI because both always return true;


//**************MANUAL MOCKING CAN BE SEEN BELOW**************************************************

//<?php
/*namespace Tests\Unit;
//    use Tests\TestCase;
//    use App\Classes\Mappers\ElectronicCatalogMapper;
//class ElectronicCatalogMapperTest extends TestCase {
//    public function setUp(){
//        $this->electronicCatalogMapper = new ElectronicCatalogMapper();
//        $this->electronicCatalogMapper->electronicCatalog = new MockElectronicCatalog();
//        $this->electronicCatalogMapper->electronicCatalogTDG  = new MockElectronicCataLogTDG();
//        $this->electronicCatalogMapper->unitOfWork = new MockUnitOfWork();
//        $this->electronicCatalogMapper->identityMap = new MockIdentityMap();
//        $this->mockEI = new MockElectronicItem();
//        $this->mockES = new MockElectronicSpecification();
//    }
//    public function testSaveES(){
//        $result = $this->electronicCatalogMapper->saveES($this->mockES);
//        $this->assertNotFalse($result);
//    }
//    public function testUpdateES(){
//        $result = $this->electronicCatalogMapper->updateES($this->mockES);
//        $this->assertNotFalse($result);
//    }
//    public function testDeleteEI(){
//        $result = $this->electronicCatalogMapper->deleteEI($this->mockEI);
//        $this->assertNotFalse($result);
//    }
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

*/
