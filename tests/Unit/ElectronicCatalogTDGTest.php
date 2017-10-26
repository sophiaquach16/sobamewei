<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\TDG\ElectronicCatalogTDG;
use App\Classes\Core\ElectronicSpecification;

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

}
