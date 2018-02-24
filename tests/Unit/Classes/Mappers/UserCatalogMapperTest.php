<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Classes\Mappers\UserCatalogMapper;

class UserCatalogMapperTest extends TestCase{
    public function setUp(){
        $this->userCatalogMapper = new UserCatalogMapper();
        $this->userCatalogMapper->userCatalog = new MockUserCatalog();
        $this->userCatalogMapper->userCatalogTDG = new MockUserCatalogTDG();;
        $this->userCatalogMapper->unitOfWork = new MockUnitOfWork();
        $this->userCatalogMapper->identityMap = new MockIdentityMap();
    }

    public function testSaveUser(){
        $result = $this->userCatalogMapper->saveUser(new MockUser());
        $this->assertNotFalse($result);
    }

    public function testMakeLoginLog(){
        $mockUser = new MockUser();
        $result = $this->userCatalogMapper->makeLoginLog($mockUser->id);
        $this->assertTrue($result);
    }

    public function testMakeNewCustomer(){
        $result = $this->userCatalogMapper->makeNewCustomer(new MockUser());
        $this->assertFalse($result);
    }

    public function testLogin(){
        $mockUser = new MockUser();
        $result = $this->userCatalogMapper->login($mockUser->email, $mockUser->password);
        $this->assertTrue($result);
    }

    public function testDeleteUser(){
        $mockUser = new MockUser();
        $result = $this->userCatalogMapper->deleteUser($mockUser->id);
        $this->assertTrue($result === "userDeleteSuccess");  
    }

    public function testDeleteCurrentUser(){
        $mockUser = new MockUser();
        $result = $this->userCatalogMapper->deleteCurrentUser($mockUser);
        $this->assertNotFalse($result);
    }

    public function testGetAllUsers(){
        $mockUser = new MockUser();
        $result = $this->userCatalogMapper->getAllUsers();
        $this->assertTrue($mockUser->id === $result->id);
    }
}
