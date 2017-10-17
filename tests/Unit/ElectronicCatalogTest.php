<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Classes\Core\ElectronicCatalog;
use App\Classes\Core\ElectronicItem;
use App\Classes\Core\ElectronicSpecification;

class ElectronicCatalogTest extends TestCase
{
  public function testSetTest(){
    $item1info=array("id"=>"abc123", "serialNumber"=>123, "ElectronicSpecification_id"=>"123abc");
    $item2info=array("id"=>"abc456", "serialNumber"=>456, "ElectronicSpecification_id"=>"456abc");
    $item1=new ElectronicItem($item1info);
    $item2=new ElectronicItem($item2info);
    $electronicItemsArray=array($item1,$item2);
    $electroSpecData=array( "id"=>1,
                            "dimensions"=>"1x2x3",
                            "weight"=>1,
                            "modelNumber"=>1,
                            "modelNumber"=>1,
                            "brandNumber"=>1,
                            "hdSize"=>'1',
                            "price"=>1,
                            "processorType"=>'1',
                            "ramSize"=>1,
                            "cpuCores"=>1,
                            "batteryInfo"=>'1',
                            "os"=>'1',
                            "camera"=>true,
                            "touchScreen"=>true,
                            "displaySize"=>'1',
                            "ElectronicType_id"=>'1',
                            "ElectronicType_name"=>'1',
                            "ElectronicType_dimensionUnit"=>'1',
                            "ElectronicType_displaySizeUnit"=>'1',
                            "electronicItems"=>$electronicItemsArray,
                            );
    $electronicCatalog = new ElectronicCatalog();
    $electronicCatalog->setESList(array($electroSpecData));
    $this->assertTrue(count($electronicCatalog->getESList())==1);
  }
}
