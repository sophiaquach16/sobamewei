<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\ElectronicSpecification;

class ElectronicSpecificationClassTest extends TestCase {

    /**
     * A test for the get and set methods of the user class
     *
     * @return void
     */
    public function testSetGetTest() {

        $electronic = new ElectronicSpecification();

        $electronicData = new \stdClass();

        $electronicData->id = '1';
        $electronicData->dimension = '2X3X4';
        $electronicData->weight = '100';
        $electronicData->modelNumber = '123';
        $electronicData->brandName = '123';
        $electronicData->hdSize = '123';
        $electronicData->price = '123';
        $electronicData->processorType = 'intel';
        $electronicData->ramSize = '16';
        $electronicData->cpuCores = '4';
        $electronicData->batteryInfo = 'infinite';
        $electronicData->os = 'ubuntu';
        $electronicData->camera = 'bestcam';
        $electronicData->touchScreen = 'True';
        $electronicData->ElectronicType_id = '123';
        $electronicData->ElectronicType_name = 'abc';
        $electronicData->ElectronicType_dimensionUnit = '123';

        $electronic->set($electronicData);

        $result = true;

        foreach ($electronicData as $key => $value) {
            if ($electronicData->$key !== $electronic->get()->$key) {
                $result = false;
            }
            /*
              // To debug a test, use echo to print on the terminal
              echo "\r\n";
              echo $u->$key;
              echo "\r\n";
              echo $user->get()->$key;
             */
        }

        $this->assertTrue($result);
    }

}
