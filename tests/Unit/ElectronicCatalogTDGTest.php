<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\TDG\ElectronicCatalogTDG;
use App\Classes\Core\ElectronicSpecification;
use App\Classes\Core\ElectronicItem;

class ElectronicCatalogTDGTest extends TestCase {

    public function testInsertAndFindES() {
        $electronicCatalogTDG = new ElectronicCatalogTDG();
        $eS = new ElectronicSpecification();

        $eSData = new \stdClass();
        
        $eSData->id = 1;
        $eSData->dimension = '100 x 200 x 300';
        $eSData->weight = 400;
        $eSData->modelNumber = 'E4R2G2GS3D4';
        $eSData->brandName = 'LG';
        $eSData->hdSize = '500';
        $eSData->price = '1000';
        $eSData->processorType = 'AMD';
        $eSData->ramSize = '16';
        $eSData->cpuCores = '4';
        $eSData->batteryInfo = '12 hours';
        $eSData->os = 'Windows';
        $eSData->camera = 1;
        $eSData->touchScreen = 1;
        $eSData->displaySize = '10 x 30';
        $eSData->ElectronicType_id = 3;

        $eS->set($eSData);
        
        $eSData = (array) $eSData;
        
        $electronicCatalogTDG->insertElectronicSpecification($eS);
        
        $foundES = (array) $electronicCatalogTDG->find(['id' => 1])[0];
        
        $sameValues = true;
        
        foreach($eSData as $key => $value){
            if($eSData[$key] != $foundES[$key]){
                $sameValues = false;
                break;
            }
        }
        
        $this->assertTrue($sameValues);
    }

     public function testUpdateES(){
        $electronicCatalogTDG = new ElectronicCatalogTDG();
        $newES= new ElectronicSpecification();
         
        $newESData= new \stdClass();
        $newESData->id = 1;
        $newESData->dimension = '200 x 400 x 500';
        $newESData->weight = 500;
        $newESData->modelNumber = 'AHZ3011HLAZ';
        $newESData->brandName = 'Samsung';
        $newESData->hdSize = '600';
        $newESData->price = '1200';
        $newESData->processorType = 'AMD';
        $newESData->ramSize = '8';
        $newESData->cpuCores = '3';
        $newESData->batteryInfo = '6 hours';
        $newESData->os = 'Windows';
        $newESData->camera = 1;
        $newESData->touchScreen = 1;
        $newESData->displaySize = '20 x 40';
        $newESData->ElectronicType_id = 3;
        
        $newES->set($newESData);
        
        $electronicCatalogTDG->updateElectronicSpecification($newES);
        
        $this->assertDatabaseHas('ElectronicSpecification', [
            'id' => 1,
            'dimension' => '200 x 400 x 500',
            'weight' => 500,
            'modelNumber' => 'AHZ3011HLAZ',
            'brandName' => 'Samsung',
            'hdSize' => '600',
            'price' => '1200',
            'processorType' => 'AMD',
            'ramSize' => '8',
            'cpuCores' => '3',
            'batteryInfo' => '6 hours',
            'os' => 'Windows',
            'camera' => 1,
            'touchScreen' => 1,
            'displaySize' => '20 x 40',
            'ElectronicType_id' => 3,
        ]);
        
     } 
     
     
    public function testInsertEI() {
        $electronicCatalogTDG = new ElectronicCatalogTDG();
        $eS = new ElectronicSpecification(); 

        $eSData = new \stdClass();
        $eSData->id = 2;
        $eSData->dimension = '100 x 200 x 300';
        $eSData->weight = 400;
        $eSData->modelNumber = 'ABC123DEF5D';
        $eSData->brandName = 'LG';
        $eSData->hdSize = '500';
        $eSData->price = '1000';
        $eSData->processorType = 'AMD';
        $eSData->ramSize = '16';
        $eSData->cpuCores = '4';
        $eSData->batteryInfo = '12 hours';
        $eSData->os = 'Windows';
        $eSData->camera = 1;
        $eSData->touchScreen = 1;
        $eSData->displaySize = '10 x 30';
        $eSData->ElectronicType_id = 3;

        $eS->set($eSData);
        
        
        $electronicCatalogTDG->insertElectronicSpecification($eS);
        
        $eIData = new \stdClass();        
        $eIData->id = 1;
        $eIData->serialNumber = "ABC123";
        $eIData->ElectronicSpecification_id = 2;
        
        $electronicCatalogTDG->insertElectronicItem($eSData->modelNumber, $eIData);
        
        $this->assertDatabaseHas('ElectronicItem', [
            'id' => 1,
            'serialNumber' => 'ABC123',
        ]);
    }     
    
     public function testDeleteEI() {
        $electronicCatalogTDG = new ElectronicCatalogTDG();
         
        $eIData = new \stdClass();        
        $eIData->id = 1;
        $eIData->serialNumber = "ABC123";
        $eIData->ElectronicSpecification_id = 2;
        $eI= new ElectronicItem($eIData);
        
        $electronicCatalogTDG->deleteElectronicItem($eI);
         
        $this->assertDatabaseMissing('ElectronicItem', [
            'id' => 1,
            'serialNumber' => 'ABC123',
        ]);
         
     }
    
}
