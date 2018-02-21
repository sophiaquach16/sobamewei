<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\TDG\ElectronicCatalogTDG;

class MockElectronicItem{
    public $id = 1;
    public $serialNumber = 888;
    public $ElectronicSpecification_id = 43;
    public $User_id = 58;
    public $expiryForUser = 'never'; 

    function get() {
        $returnData = new \stdClass();
        $returnData->id = $this->id;
        $returnData->serialNumber = $this->serialNumber;
        $returnData->ElectronicSpecification_id = $this->ElectronicSpecification_id;
        $returnData->User_id = $this->User_id;
        $returnData->expiryForUser= $this->expiryForUser;
        return $returnData;
    }
}

class MockElectronicSpecification{
    public $id = 1;
    public $dimension = '100 x 200 x 300';
    public $weight = 400;
    public $modelNumber = 'E4R2G2GS3D4';
    public $brandName = 'LG';
    public $hdSize = '500';
    public $price = '1000';
    public $processorType = 'AMD';
    public $ramSize = '16';
    public $cpuCores = '4';
    public $batteryInfo = '12 hours';
    public $os = 'Windows';
    public $camera = 1;
    public $touchScreen = 1;
    public $displaySize = 10;
    public $ElectronicType_id = 3;
    public $ElectronicType_name = 'Monitor';
    public $ElectronicType_displaySizeUnit = 'inch'; 
    public $ElectronicType_dimensionUnit = 0;
    public $image = "image.jpg";
    public $electronicItems = array(); 

    public function get() {
        $returnData = new \stdClass();
        $returnData->id = $this->id;
        $returnData->dimension = $this->dimension;
        $returnData->weight = $this->weight;
        $returnData->modelNumber = $this->modelNumber;
        $returnData->brandName = $this->brandName;
        $returnData->hdSize = $this->hdSize;
        $returnData->price = $this->price;
        $returnData->processorType = $this->processorType;
        $returnData->ramSize = $this->ramSize;
        $returnData->cpuCores = $this->cpuCores;
        $returnData->batteryInfo = $this->batteryInfo;
        $returnData->os = $this->os;
        $returnData->camera = $this->camera;
        $returnData->touchScreen = $this->touchScreen;
        $returnData->displaySize = $this->displaySize;
        $returnData->ElectronicType_id = $this->ElectronicType_id;
        $returnData->ElectronicType_name = $this->ElectronicType_name;
        $returnData->ElectronicType_dimensionUnit = $this->ElectronicType_dimensionUnit;
        $returnData->ElectronicType_displaySizeUnit = $this->ElectronicType_displaySizeUnit;
        $returnData->image = $this->image;

        $electronicItemsData = array();
        foreach ($this->electronicItems as $electronicItem) {
            array_push($electronicItemsData, $electronicItem->get());
        }

        $returnData->electronicItems = $electronicItemsData;

        return $returnData;
    }
}

class MockMySQLConnection{
    public $query_string;
    public $parameters;

    public function query($query, $bindValues){
        $this->query_string = $query;
        $this->parameters = $bindValues;
        return $this->interpret_query($query);
    }

    public function directQuery($query){
        $this->query_string = $query;
        return $this->interpret_query($query);
    }

    public function interpret_query($query){
        if ($query === 'SELECT * FROM ElectronicSpecification'){
            $es = new MockElectronicSpecification();
            return array($es);
        }
        return null;
    }
}

class ElectronicCatalogTDGTest extends TestCase {
    
    public function setUp(){
        $this->electronicCatalogTDG = new ElectronicCatalogTDG();
        $this->electronicCatalogTDG->conn = new MockMySQLConnection();
        $this->electronicSpecification = new MockElectronicSpecification();
        $this->electronicItem = new MockElectronicItem();
    }
    
    public function testInsertES(){
        $this->electronicCatalogTDG->insertElectronicSpecification($this->electronicSpecification);
        $expected_query = "INSERT INTO ElectronicSpecification SET dimension = :dimension , weight = :weight , modelNumber = :modelNumber , brandName = :brandName , hdSize = :hdSize , price = :price , processorType = :processorType , ramSize = :ramSize , cpuCores = :cpuCores , batteryInfo = :batteryInfo , os = :os , camera = :camera , touchScreen = :touchScreen , displaySize = :displaySize , ElectronicType_id = :ElectronicType_id , ElectronicType_dimensionUnit = :ElectronicType_dimensionUnit , image = :image ";
        $obtained_query = $this->electronicCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $obtained_query);
    }

    public function testFind() {    
        $this->electronicCatalogTDG->find(['id' => 1])[0];
        $expected_query = "SELECT * FROM ElectronicSpecification WHERE id = :id";
         $obtained_query = $this->electronicCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $obtained_query);
    }
    
    public function testFindAll(){
        $this->electronicCatalogTDG->findAll();
        $expected_query = "SELECT * FROM ElectronicItem WHERE ElectronicSpecification_id = :ElectronicSpecification_id";
        $obtained_query = $this->electronicCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $obtained_query);
    }

    public function testInsertElectronicItem(){
        $this->electronicCatalogTDG->insertElectronicItem($this->electronicSpecification, $this->electronicItem); 
        $expected_query = "INSERT INTO ElectronicItem SET id = :id , serialNumber = :serialNumber , ElectronicSpecification_id = :ElectronicSpecification_id , User_id = :User_id , expiryForUser = :expiryForUser ";
        $obtained_query = $this->electronicCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $obtained_query);
    }

    public function testDeleteElectronicItem(){
        $this->electronicCatalogTDG->deleteElectronicItem($this->electronicItem); 
        $expected_query = "DELETE FROM ElectronicItem WHERE id = :id";
        $obtained_query = $this->electronicCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $obtained_query);
    }

    public function testUpdateElectronicSpecification(){
        $this->electronicCatalogTDG->updateElectronicSpecification($this->electronicSpecification); 
        $expected_query = "UPDATE ElectronicSpecification SET dimension = :dimension , weight = :weight , modelNumber = :modelNumber , brandName = :brandName , hdSize = :hdSize , price = :price , processorType = :processorType , ramSize = :ramSize , cpuCores = :cpuCores , batteryInfo = :batteryInfo , os = :os , camera = :camera , touchScreen = :touchScreen , displaySize = :displaySize , ElectronicType_id = :ElectronicType_id , ElectronicType_dimensionUnit = :ElectronicType_dimensionUnit , image = :image  WHERE id = :id";
        $obtained_query = $this->electronicCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $obtained_query);
    }

    public function testUnsetUselessESProperties(){
        $this->electronicCatalogTDG->unsetUselessESProperties($this->electronicSpecification); 
        $expected_query = null;
        $obtained_query = $this->electronicCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $obtained_query);
    }

    public function testUpdateElectronicSpecificationveReturnedEI(){
        $this->electronicCatalogTDG->saveReturnedEI($this->electronicItem);
        $expected_query = "INSERT INTO ElectronicItem SET id = :id , serialNumber = :serialNumber , ElectronicSpecification_id = :ElectronicSpecification_id , User_id = :User_id , expiryForUser = :expiryForUser ";
        $obtained_query = $this->electronicCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $obtained_query);
    }
}
