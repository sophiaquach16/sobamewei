<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\ElectronicSpecification;
use App\ElectronicItem;

class ElectronicSpecificationClassTest extends TestCase
{

    /**
     * A test for the get and set methods of the user class
     *
     * @return void
     */
    public function testSetGetTest()
    {

        $electronic = new ElectronicSpecification();
        $electronicItem = new ElectronicItem();

        $electronicItemData = new \stdClass();
        $electronicItemData->id = 'TESTINGID123';
        $electronicItemData->serialNumber = 'TESTINGSERIAL';
        $electronicItemData->ElectronicSpecification_id = 'TESTAGAIN';

        $electronicItem->set($electronicItemData);
        $electronicItems = array($electronicItem);

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
        $electronicData->ElectronicType_id = '1';
        $electronicData->electronicItems = $electronicItems;


        $electronic->set($electronicData);
        //dump($electronic);
        //dump($electronicData);
        $result = true;

        foreach ($electronicData as $key => $value) {
            if (is_array($value)) {
                //dump($value[0]->get());
                //dump($electronic->get()->$key[0]->id);
                foreach ($value as $key1 => $value1) {
                    if ($value1->get()->id !== $electronic->get()->$key[$key1]->id &&
                        $value1->get()->serialNumber !== $electronic->get()->$key[$key1]->serialNumber &&
                        $value1->get()->ElectronicSpecification_id !== $electronic->get()->$key[$key1]->ElectronicSpecification_id) {
                        //dump($electronic->get()->$key[$key1]->id);
                        //dump($value1->get()->id);
                        $result = false;
                    }
                }
            } else if ($value !== $electronic->get()->$key) {

                $result = false;

            }
        }
        //dd($electronic);

        $this->assertTrue($result);
    }

}
