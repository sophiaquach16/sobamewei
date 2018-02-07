<?php

namespace Tests\Unit;

use App\Classes\Core\ShoppingCart;
use App\Classes\TDG\ShoppingCartTDG;
use App\Classes\Core\ElectronicSpecification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\Core\ElectronicItem;
use App\Classes\TDG\ElectronicCatalogTDG;
use Illuminate\Support\Facades\Auth;
use App\Classes\Core\User;

class ShoppingCartTDGTest extends TestCase {
    public function testFindAllEIFromUser(){


        $shoppingCartTDG = new ShoppingCartTDG();
        //Creation of a user
        $user = new User();

        $userData = new \stdClass();

        $userData->id = 5;
        $userData->firstName = 'John';
        $userData->lastName = 'Doe';
        $userData->email = 'johndoe123@gmail.com';
        $userData->phone = '123-456-7890';
        $userData->admin = 0;
        $userData->physicalAddress = '1234 Wallstreet';
        $userData->password = 'password123';

        $user->set($userData);

        //Creation of a ShoppingCart
        $shoppingCart = ShoppingCart::getInstance();
        //Logging in the user
        Auth::login($user);
        Auth::check();

        $electronicCatalogTDG = new ElectronicCatalogTDG();
        $eS = new ElectronicSpecification();

        $eSData = new \stdClass();
        $eSData->id = 12345;
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
        $eSData->displaySize = 10;
        $eSData->ElectronicType_id = 3;

        $eS->set($eSData);

        $electronicCatalogTDG->insertElectronicSpecification($eS);

        $eIData = new \stdClass();
        $eIData->id = 12345;
        $eIData->serialNumber = "ABC123";
        $eIData->ElectronicSpecification_id = 2;
        $eIData->User_id=5;
        $eIData->expiryForUser='2017-12-25 12:12:12';

        $electronicCatalogTDG->insertElectronicItem($eSData->modelNumber, $eIData);
        $shoppingCart->setEIList(array($eIData));
        $itemsRetrievedFromDB= $shoppingCartTDG->findAllEIFromUser($eIData->User_id);
        var_dump($itemsRetrievedFromDB);
        $shoppingCartItems=$shoppingCart->getEIList();
        $sameValues = false;
        foreach ($itemsRetrievedFromDB as $itemDB){
            foreach ($shoppingCartItems as $shoppingItem)
                if ($itemDB->id== $shoppingItem->getId()){
                    $sameValues = true;
                }
                else
                    $sameValues = false;
                break;
        }
        $this->assertTrue($sameValues);
    }

}