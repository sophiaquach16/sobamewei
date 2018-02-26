<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Classes\Mappers\UserCatalogMapper;
use App\Classes\Core;

class UserCatalogMapperTest extends TestCase{
    public function setUp(){
        /*$this->userCatalogMapper = new UserCatalogMapper();
        $this->userCatalogMapper->userCatalog = new MockUserCatalog();
        $this->userCatalogMapper->userCatalogTDG = new MockUserCatalogTDG();;
        $this->userCatalogMapper->unitOfWork = new MockUnitOfWork();
        $this->userCatalogMapper->identityMap = new MockIdentityMap();*/
        $this->userCatalogTDGMock = $this
            ->getMockBuilder(userCatalogTDG::class)
            ->setMethods(
                ['add',
                    'insertLoginLog',
                    'unsetUserEI',
                    'deleteLoginLog',
                    'deleteUserTransaction',
                    'deleteUser',
                    ])
            ->getMock();



        $this->userCatalogMock = $this
            ->getMockBuilder('UserCatalog')
            ->disableOriginalConstructor()
            ->setMethods(['get',
                           'findUser',
                            'checkUser',
                            'getDeleteUserInfo',
                            'getUserList',
                ])
            ->getMock();
        //creating a unit of work mock
        $this->unitOfWorkMock = $this
            ->getMockBuilder(UnitOfWork::class)
            ->disableOriginalConstructor()
            ->setMethods(['registerDeleted', 'commit'])
            ->getMock();

        //creating an identity map mock
        $this->identityMapMock = $this
            ->getMockBuilder(IdentityMap::class)
            ->disableOriginalConstructor()
            ->setMethods(['delete',
            ])
            ->getMock();


        $this->UserCatalogMapperMock = new UserCatalogMapper(
            $this->userCatalogTDGMock,
            $this->userCatalogMock,
            $this->unitOfWorkMock,
            $this->identityMapMock
        );

        $this-> userMock = $this
            ->getMockBuilder(User::class)
            ->setMethods(['get'])
            ->getMock();

        $userData = new \stdClass();

        $userData->id = '1';
        $userData->firstName = 'John';
        $userData->lastName = 'Doe';
        $userData->email = 'johndoe123@gmail.com';
        $userData->phone = '123-456-7890';
        $userData->admin = '0';
        $userData->physicalAddress = '1234 Wallstreet';
        $userData->password = 'password123';

        $this-> userMock->method('get') ->willReturn($userData);
        $this-> userMock-> id = '1';
        $this-> userMock-> password = 'password123';
        $this-> userMock-> email = 'johndoe123@gmail.com';



    }

    public function tearDown()

    {

        parent::tearDown();

        $this->UserCatalogMapperMock = null;

    }
    public function testSaveUser(){
        $this->userCatalogTDGMock
            ->method('add')
            ->willReturn($this->userMock);

        $result = $this->UserCatalogMapperMock->saveUser($this->userMock);
        $this->assertNotFalse($result);
    }

    public function testMakeLoginLog(){
        $this->userCatalogTDGMock
            ->method('insertLoginLog')
            ->willReturn($this->userMock);

        $result = $this->UserCatalogMapperMock->makeLoginLog($this->userMock->id);
        $this->assertTrue($result);
    }

    public function testMakeNewCustomer(){

        $this->userCatalogMock
            ->method('findUser')
            ->willReturn($this->userMock);

        $userData = new \stdClass();
        $userData->id = '1';
        $userData->firstName = 'asd';
        $userData->lastName = 'asd';
        $userData->email = 'asd@gmail.com';
        $userData->phone = '1235-456-7890';
        $userData->admin = '0';
        $userData->physicalAddress = '1234 Wallstreet';
        $userData->password = '123';
        $result = $this->UserCatalogMapperMock->makeNewCustomer($userData);
        $this->assertFalse($result);
    }

    public function testLogin(){
       $this->userCatalogMock
                    ->method('checkUser')
                    ->willReturn($this->userMock);

        $result = $this->UserCatalogMapperMock->login($this->userMock->email, $this->userMock->password);
        $this->assertTrue($result);
    }

    public function testDeleteUser(){
        $this->identityMapMock
            ->method('delete')
            ->willReturn($this->userMock);

        $this->userCatalogMock
            ->method('getDeleteUserInfo')
            ->willReturn($this->userMock);

        $this->unitOfWorkMock
            ->method('registerDeleted')
            ->willReturn($this->userMock);

        $this->unitOfWorkMock
             ->method('commit')
             ->willReturn($this->userMock);
        $result = $this->UserCatalogMapperMock->deleteUser($this->userMock->id);
        $this->assertTrue($result === "userDeleteSuccess");  
    }

    public function testDeleteCurrentUser(){
        $this->userCatalogTDGMock
            ->method('unsetUserEI')
            ->willReturn($this->userMock);

        $this->userCatalogTDGMock
            ->method('deleteLoginLog')
            ->willReturn($this->userMock);

        $this->userCatalogTDGMock
            ->method('deleteUserTransaction')
            ->willReturn($this->userMock);

        $this->userCatalogTDGMock
            ->method('deleteUser')
            ->willReturn($this->userMock);

        $result = $this->UserCatalogMapperMock->deleteCurrentUser($this->userMock);
        $this->assertNotFalse($result);
    }

    public function testGetAllUsers(){
        $this->userCatalogMock
            ->method('getUserList')
            ->willReturn($this->userMock);
        $result = $this->UserCatalogMapperMock->getAllUsers();
        $this->assertTrue($this->userMock->id === $result->id);
    }
}
