<?php
namespace Tests\Unit;


use App\Classes\TDG\ShoppingCartTDG;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\TDG\ElectronicCatalogTDG;
use App\Classes\Core\ElectronicSpecification;
use App\Classes\Core\ElectronicItem;
use App\Classes\Core\ShoppingCart;

class ShoppingCartTDGTest extends TestCase {
    public function testupdateEI(){
      //Use shoppingCartTDG to test for the methods
        $shoppingCartTDG = new ShoppingCartTDG();

        $shoppingCart = new ShoppingCart();


        $eIData = new \stdClass();
        $eIData->user_Id = "John";
        $eIData->serialNumber=12345;
        $eIData->ElectronicSpecification_id=123;

        $eI = new ElectronicItem();
        $eI->set($eIData);
        $eIData = (array) $eIData;

        $UserIDFound=$eI->getUserId(); //find the userId

        $shoppingCartList = $eI;
        $shoppingCart->setEIList($shoppingCartList);

        $shoppingCartTDG->updateEI($eI);



        $this->assertTrue($UserIDFound == "John");

    }

    public function testfindAllEIFromUser(){
      $shoppingCartTDG = new ShoppingCartTDG();

      $shoppingCart = new ShoppingCart();

      //Electronic item 1
      $eIData1 = new \stdClass();
      $eIData1->user_Id = "John";
      $eIData1->serialNumber=12345;
      $eIData1->ElectronicSpecification_id=123;

      $Item1 = new ElectronicItem();
      $Item1->set($eIData1);
      $UserIDFound=$Item1->getUserId(); //find the userId

      //Electronic item 2
      $eIData2 = new \stdClass();
      $eIData2->user_Id = "John";
      $eIData2->serialNumber=6789;
      $eIData2->ElectronicSpecification_id=345;

      $Item2 = new ElectronicItem();
      $Item2->set($eIData1);
      $UserIDFound=$Item2->getUserId(); //find the userId
        $shoppingCart = array($Item1,$Item2);
        $foundEI = $shoppingCartTDG->findAllEIFromUser($UserIDFound);
        $sameValues=true;
        foreach($shoppingCart as $key => $value){
            if($shoppingCart[$key] != $UserIDFound){
                $sameValues=false;
            }

        }


        $this->assertTrue($sameValues);


    }

}
