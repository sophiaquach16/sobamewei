<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Classes\IdentityMap;

class MockObject{
    private $id = 57;
    function __construct() {
    }

    public function get(){
        $return_val = new \stdClass();
        $return_val->id = $this->id;
        return $return_val;
    }
}

class IdentityMapTest extends TestCase {
    public function setUp(){
        $this->identityMap = new IdentityMap();
    }

    public function testAdd(){
        // Create object and add it to identityMap
        // Retrieve it from identity map
        $key = 'key';
        $value = new MockObject();
        $this->identityMap->add($key, $value);
        $returned_object = $this->identityMap->get($key, "id", 57);
        $id = $returned_object->get();
        $this->assertTrue($id->id == 57);
    }

    public function testDelete(){
        // Add object to identity map and check that it is there
        // Delete object from the map and check that it is not there
        $key = 'key';
        $value = new MockObject();
        $this->identityMap->add($key, $value);
        $returned_object = $this->identityMap->get($key, "id", 57);
        $id = $returned_object->get();
        $this->assertTrue($id->id == 57);

        $this->identityMap->delete($key, "id", 57);
        $returned_object = $this->identityMap->get($key, "id", 57);
        $this->assertNull($returned_object);
    }

    public function testClear(){
        // Add object to identity map and check that it is there
        // Clear the map and check that it is absent 
        $key = 'key';
        $value = new MockObject();
        $this->identityMap->add($key, $value);
        $returned_object = $this->identityMap->get($key, "id", 57);
        $id = $returned_object->get();
        $this->assertTrue($id->id == 57);

        $this->identityMap->clear();
        $returned_object = $this->identityMap->get($key, "id", 57);
        $this->assertNull($returned_object);
    }
}


