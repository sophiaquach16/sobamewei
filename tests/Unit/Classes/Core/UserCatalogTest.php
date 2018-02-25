<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 2017-10-17
 * Time: 3:46 PM
 * @test
 */

namespace Tests\Unit;

use App\Classes\Core\UserCatalog;
use App\Classes\Core\User;
use Tests\TestCase;
use Hash;

class UserCatalogTest extends TestCase
{
    private $userCatalog;
    private $user1;
    private $user2;
    private $user1Data;
    private $user2Data;

    public function setUp(){
        parent::setUp();
        $this->userCatalog = new UserCatalog();
        $this->user1 = new User();
        $this->user2 = new user();
        $this->user1Data = new \stdClass();
        $this->user2Data = new \stdClass();

        $this->user1Data->id = 1;
        $this->user1Data->firstName = 'foo1';
        $this->user1Data->lastName = 'bar1';
        $this->user1Data->email = 'foo@gmail.com';
        $this->user1Data->phone = '514-111-1111';
        $this->user1Data->admin = 0;
        $this->user1Data->physicalAddress = 'Chez bar';
        $this->user1Data->password = 'foo123';

        $this->user2Data->id = 2;
        $this->user2Data->firstName = 'foo2';
        $this->user2Data->lastName = 'bar2';
        $this->user2Data->email = 'bar@gmail.com';
        $this->user2Data->phone = '514-222-2222';
        $this->user2Data->admin = 0;
        $this->user2Data->physicalAddress = 'Chez foo';
        $this->user2Data->password = 'bar123';

    }

    public function tearDown(){
        parent::tearDown();
        //set the catalog to an empty list
        $this->userCatalog->setUserList(array());

    }
    public function testAccessorsMethods()
    {
        $this->user1->set($this->user1Data);
        $this->user2->set($this->user2Data);
        $userList = array($this->user1, $this->user2);
        $this->userCatalog->setUserList($userList);
        $userCatalogList = $this->userCatalog->getUserList();

        $this->assertTrue(sizeof($userList) == sizeof($userCatalogList));

    }

    public function testCheckUser()
    {
        $this->user1->set($this->user1Data);
        $this->user2->set($this->user2Data);
        $userList = array($this->user1, $this->user2);
        $this->userCatalog->setUserList($userList);

        $emailParameter = 'bar@gmail.com';
        $pswParameter = 'bar123';
        $hashedPsw = Hash::make($pswParameter);
        $this->assertTrue($this->userCatalog->checkUser($emailParameter, $hashedPsw));

    }

    public function testFindUser()
    {
       $this->user1->set($this->user1Data);
       $this->user2->set($this->user2Data);
       $userList = array($this->user1, $this->user2);
       $this->userCatalog->setUserList($userList);

        $emailParameter = 'bar@gmail.com';

        $this->assertTrue($this->userCatalog->findUser($emailParameter));
    }

    public function testMakeCustomer()
    {

        $this->user1->set($this->user1Data);
        $this->user2->set($this->user2Data);
        $userList = array($this->user1, $this->user2);
        $this->userCatalog->setUserList($userList);
        //default userList has 2 users

        //adding one more user using makeNewCustom
        $user3Data = new \stdClass();

        $user3Data->id = 3;
        $user3Data->firstName = 'foo3';
        $user3Data->lastName = 'bar3';
        $user3Data->email = 'foobar@gmail.com';
        $user3Data->phone = '514-333-3333';
        $user3Data->admin = 0;
        $user3Data->physicalAddress = 'Chez bar';
        $user3Data->password = 'foobar123';

        $this->userCatalog->makeCustomer($user3Data);
        //dump($userCatalog);
        $newUserList = $this->userCatalog->getUserList();
        //dump($total);
        $this->assertTrue(count($newUserList) == 3);
    }

    public function testDeleteUserInfo()
    {
        $this->user1->set($this->user1Data);
        $this->user2->set($this->user2Data);
        $userList = array($this->user1, $this->user2);
        $this->userCatalog->setUserList($userList);

        $returnedUser = $this->userCatalog->getDeleteUserInfo(2);
        $this->assertTrue( $returnedUser->get()->id == 2);

    }
}
