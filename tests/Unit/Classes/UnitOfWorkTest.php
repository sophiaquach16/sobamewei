<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Classes\UnitOfWork;

class MockGeneric{
    public $value1 = 1;

    public function equals($obj){
        if ($obj->value1 === $this->value1){
            return True;
        }
        return False;
    }
}

class UnitOfWorkTest extends TestCase {
    public function setUp(){
        $this->unitOfWork = new UnitOfWork(null);
    }

    public function testRegisterNew(){
        $obj1 = new MockGeneric();
        $this->unitOfWork->registerNew($obj1);
        $obj2 = $this->unitOfWork->newList[0];
        $this->assertTrue($obj1->equals($obj2));
    }

    public function testRegisterDirty(){
        $obj1 = new MockGeneric();
        $this->unitOfWork->registerDirty($obj1);
        $obj2 = $this->unitOfWork->changedList[0];
        $this->assertTrue($obj1->equals($obj2));

    }

    public function testRegisterDelete(){
        $obj1 = new MockGeneric();
        $this->unitOfWork->registerDeleted($obj1);
        $obj2 = $this->unitOfWork->deletedList[0];
        $this->assertTrue($obj1->equals($obj2));
    }

    public function testCommit(){
        $obj1 = new MockGeneric();
        $this->unitOfWork->registerDeleted($obj1);
        $this->unitOfWork->registerDirty($obj1);
        $this->unitOfWork->registerNew($obj1);
        $result = $this->unitOfWork->commit();
        $this->assertNull($result);
        $this->assertTrue(array() === $this->unitOfWork->newList);
        $this->assertTrue(array() === $this->unitOfWork->changedList);
        $this->assertTrue(array() === $this->unitOfWork->deletedList);
    }
}

