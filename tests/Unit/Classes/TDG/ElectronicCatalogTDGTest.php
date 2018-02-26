<?php

namespace Tests\Unit;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\TDG\ElectronicCatalogTDG;

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
