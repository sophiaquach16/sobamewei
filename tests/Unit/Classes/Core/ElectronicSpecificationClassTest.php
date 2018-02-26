<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\Core\ElectronicSpecification;
use App\Classes\Core\ElectronicItem;

class ElectronicSpecificationClassTest extends TestCase
{

    /**
     * A test for the get and set methods of the user class
     *
     * @return void
     */
    public function setUp(){

        parent::setUp();



        $this->electronicItemMock1 = $this ->createMock(ElectronicItem::Class);



    }

    public function SetGetTest()
    {

        $electronic = new ElectronicSpecification();



        $electronicItemData = new \stdClass();
        $electronicItemData->id = 'TESTINGID123';
        $electronicItemData->serialNumber = 'TESTINGSERIAL';
        $electronicItemData->ElectronicSpecification_id = 'TESTAGAIN';
        $electronicItemData->User_id='1';
        $electronicItemData->expiryForUser = '2017-12-25 12:12:12';
        $this->electronicItemMock1 -> setUserId($electronicItemData);
        $this-> electronicItemMock1 ->method('get') ->willReturn($electronicItemData);
        $electronicItems = array($this-> electronicItemMock1);
        dump($this->electronicItemMock1);
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
        $electronicData->camera = true;
        $electronicData->touchScreen = true;
        $electronicData->ElectronicType_id = '1';
        $electronicData->electronicItems = $this->electronicItemMock1;



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
                        //var_dump($electronic->get()->$key[$key1]->ElectronicSpecification_id);
                       // var_dump('----------------------------');
                        dump($electronic->get()->$key[$key1]);
                        dump('----------');
                        dump($value1->get()->id);
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
