<?php

namespace Tests\Unit;

use app\Classes\Core\iElectronicCatalog;
use App\Classes\Core\iElectronicItem;
use app\Classes\Core\iElectronicSpecification;
use app\Classes\Core\iShoppingCart;
use app\Classes\Core\iTransaction;
use app\Classes\Core\iUser;
use app\Classes\Core\iUserCatalog;

class MockUserCatalog
{
    public function findUser($email)
    {
        return true;
    }

    public function makeCustomer($userData)
    {
    }

    public function checkUser($email, $password)
    {
        return true;
    }

    public function getDeleteUserInfo($userId)
    {
        return new MockUser();
    }

    public function getUserList()
    {
        return new MockUser();
    }

    public function setUserList($userListData)
    {
        ;
    }
}

class MockUserCatalogTDG
{
    public function add($user)
    {
        return new \stdClass();
    }

    public function insertLoginLog($id, $timestamp)
    {

    }

    public function unsetUserEI($userId)
    {
    }

    public function deleteLoginLog($userId)
    {
    }

    public function deleteUserTransaction($userId)
    {
    }

    public function deleteUser($user)
    {
        return new \stdClass();
    }

    public function checkUser($email, $password)
    {
    }

    public function findUser($email)
    {
    }

    public function getDeleteUserInfo($userId)
    {
    }

    public function getUserList()
    {
    }

    public function makeCustomer($userData)
    {
    }

    public function setUserList($userListData)
    {
    }
}


class MockTransactionCatalog
{
    public function getTransactionListForUser($user_id)
    {
        return new MockTransaction();
    }

    public function getTransactionByItemId($tr_id)
    {
        return new MockTransaction();
    }

    public function getTransactionObjectByItemId($item_id)
    {
        return new MockTransaction();
    }

    public function setTransactionList($trListData)
    {
    }

    public function getTransactionsByUserIdAndTimestamp($user_id, $timestamp)
    {
        return null;
    }
}

class MockTransactionTDG
{
    public function addTransaction($transaction, $timeStamp)
    {
        return new \stdClass();
    }

    public function deleteTransaction($tr)
    {
    }
}


class MockShoppingCart
{
    public function getEIList()
    {
        return array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
    }

    public function updateEIList()
    {
    }

    public function addEIToCart($ei)
    {
    }

    public function setEIList($eIListData)
    {
    }
}

class MockShoppingCartTDG
{
    public function findalleifromuser($userid)
    {
    }

    public function updateEI($ei)
    {
    }
}


class MockElectronicCataLogTDG
{
    public function insertElectronicSpecification($electronicSpecification)
    {
        return new \stdClass();
    }

    public function updateElectronicSpecification($electronicSpecification)
    {
        return new \stdClass();
    }

    public function deleteElectronicItem($electronicItem)
    {
        return new \stdClass();
    }

    public function insertElectronicItem($modelNumber, $electronicItemData)
    {
        return new \stdClass();
    }

    public function saveReturnedEI($ei)
    {
        return new \stdClass();
    }
}

class MockElectronicCatalog
{
    private $esList;

    function __construct()
    {
        $es = new MockElectronicSpecification();
        $this->esList = array($es);
    }

    public function findElectronicSpecification($modelNumber)
    {
        $modelNumberExists = false;
        foreach ($this->esList as $eS) {
            if ($eS->modelNumber === $modelNumber) {
                $modelNumberExists = true;
            }
        }
        return $modelNumberExists;
    }

    public function makeElectronicSpecification($electronicSpecificationData)
    {
        return new MockElectronicSpecification();
    }

    public function makeElectronicItem($modelNumber, $electronicItemData)
    {
    }

    public function getElectronicSpecificationById($eSId)
    {
        $mockES = new MockElectronicSpecification();
        return $mockES->get();
    }

    public function modifyElectronicSpecification($eSId, $eSData)
    {
        return new MockElectronicSpecification();
    }

    public function getESList()
    {
        return array();
    }

    public function addReturnedEI($item_id, $serialNumber, $ElectronicSpecification_id)
    {
        return new MockElectronicItem();
    }

    public function deleteElectronicItem($ei)
    {
    }

    public function getESListFromEIList($lst)
    {
        return new MockElectronicSpecification();
    }

    public function unsetUserAndExpiryFromEI($eSId, $userId)
    {
    }

    public function reserveFirstEIFromES($eSId, $userId, $expiry)
    {
    }

    public function setESList($esListData)
    {
    }
}

class MockIdentityMap
{
    public function add($objectClass, $object)
    {
    }

    public function get($objectClass, $objectProperty, $objectPropertyValue)
    {
        return null;
    }

    public function delete($objectClass, $objectProperty, $objectPropertyValue)
    {
    }

    public function clear()
    {
    }
}

class MockUnitOfWork
{
    public function registerNew($object)
    {
    }

    public function registerDeleted($object)
    {
    }

    public function registerDirty($object)
    {
    }

    public function commit()
    {
        return null;
    }
}

class MockTransaction
{
    public $timestamp = 888888;
    public $item_id = 72;
    public $customer_id = 8;
    public $serialNumber = 8989;
    public $ElectronicSpec_id = 293;

    public function getTimeStamp()
    {
        return $this->timestamp;
    }

    public function get()
    {
        $returnData = new \stdClass();
        $returnData->item_id = $this->item_id;
        $returnData->customer_id = $this->customer_id;
        $returnData->serialNumber = $this->serialNumber;
        $returnData->ElectronicSpec_id = $this->ElectronicSpec_id;
        $returnData->timestamp = $this->timestamp;
        return $returnData;
    }

    public function purchase($userId)
    {
    }

    public function set($time)
    {
    }

    public function setTimeStamp($time)
    {
    }
}

class MockUser
{
    public $id = 999;
    public $firstName = 'example_firstname';
    public $lastName = 'example_lastname';
    public $email = 'example@hotmail.com';
    public $phone = '514-555-5555';
    public $admin = 0;
    public $physicalAddress = 'example_addr';
    public $password = 'example_pass';

    public function get()
    {
        $returnData = new \stdClass();

        $returnData->id = $this->id;
        $returnData->firstName = $this->firstName;
        $returnData->lastName = $this->lastName;
        $returnData->email = $this->email;
        $returnData->phone = $this->phone;
        $returnData->admin = $this->admin;
        $returnData->physicalAddress = $this->physicalAddress;
        $returnData->password = $this->password;

        return $returnData;
    }

    public function set($data)
    {
    }
}

class MockElectronicItem
{

    public $id = 1;
    public $serialNumber = 888;
    public $ElectronicSpecification_id = 43;
    public $User_id = 58;
    public $expiryForUser = 'never';

    function get()
    {
        $returnData = new \stdClass();
        $returnData->id = $this->id;
        $returnData->serialNumber = $this->serialNumber;
        $returnData->ElectronicSpecification_id = $this->ElectronicSpecification_id;
        $returnData->User_id = $this->User_id;
        $returnData->expiryForUser = $this->expiryForUser;
        return $returnData;
    }

    public function getElectronicSpecification_id()
    {
    }

    public function getExpiryForUser()
    {
    }

    public function getSerialNumber()
    {
    }

    public function getId()
    {
    }

    public function getUserId()
    {
    }

    public function set($data)
    {
    }

    public function setExpiryForUser($expiry)
    {
    }

    public function setSerialNumber($serialNumber)
    {
    }

    public function setUserId($userId)
    {
    }
}

class MockElectronicSpecification
{
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

    public function get()
    {
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

    public function addElectronicItem($electronicItemData)
    {
    }

    public function deleteElectronicItem($id)
    {
    }

    public function getElectronicItems()
    {
    }

    public function getId()
    {
    }

    public function getImage()
    {
    }

    public function getModelNumber()
    {
    }

    public function reserveFirstAvailableEI($userId, $expiry)
    {
    }

    public function set($data)
    {
    }

    public function setImage($image)
    {
    }

    public function unsetUserAndExpiry($userId)
    {
    }


}

class MockMySQLConnection
{
    public $query_string;
    public $parameters;

    public function query($query, $bindValues)
    {
        $this->query_string = $query;
        $this->parameters = $bindValues;
        return $this->interpret_query($query);
    }

    public function directQuery($query)
    {
        $this->query_string = $query;
        return $this->interpret_query($query);
    }

    public function interpret_query($query)
    {
        if ($query === 'SELECT * FROM ElectronicSpecification') {
            $es = new MockElectronicSpecification();
            return array($es);
        } else if ($query === 'SELECT * FROM ElectronicItem') {
            return array();
        } else if ($query === "SELECT * FROM User WHERE email = :email") {
            return array();
        } else if ($query === "SELECT ElectronicItem.id, serialNumber, ElectronicSpecification_id, User_id, expiryForUser FROM ElectronicItem  JOIN User ON ElectronicItem.User_id = User.id WHERE User.id = 999") {
            return array();
        }
        return null;
    }
}
