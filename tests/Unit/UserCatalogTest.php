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

    public function testAccessorsMethods()
    {
        $user1 = new User();
        $user2 = new user();
        $user1Data = new \stdClass();
        $user2Data = new \stdClass();
        $userCatalog = new UserCatalog();

        $user1Data->id = 1;
        $user1Data->firstName = 'foo1';
        $user1Data->lastName = 'bar1';
        $user1Data->email = 'foo@gmail.com';
        $user1Data->phone = '514-111-1111';
        $user1Data->admin = 0;
        $user1Data->physicalAddress = 'Chez bar';
        $user1Data->password = 'foo123';

        $user2Data->id = 2;
        $user2Data->firstName = 'foo2';
        $user2Data->lastName = 'bar2';
        $user2Data->email = 'bar@gmail.com';
        $user2Data->phone = '514-222-2222';
        $user2Data->admin = 0;
        $user2Data->physicalAddress = 'Chez foo';
        $user2Data->password = 'bar123';

        $user1->set($user1Data);
        $user2->set($user2Data);
        $userList = array($user1, $user2);
        $userCatalog->setUserList($userList);
        $userCatalogList = $userCatalog->getUserList();

        $this->assertTrue(sizeof($userList) == sizeof($userCatalogList));

    }

    public function testCheckUser()
    {
        $user1 = new User();
        $user2 = new user();
        $user1Data = new \stdClass();
        $user2Data = new \stdClass();
        $userCatalog = new UserCatalog();

        $user1Data->id = 1;
        $user1Data->firstName = 'foo1';
        $user1Data->lastName = 'bar1';
        $user1Data->email = 'foo@gmail.com';
        $user1Data->phone = '514-111-1111';
        $user1Data->admin = 0;
        $user1Data->physicalAddress = 'Chez bar';
        $user1Data->password = 'foo123';

        $user2Data->id = 2;
        $user2Data->firstName = 'foo2';
        $user2Data->lastName = 'bar2';
        $user2Data->email = 'bar@gmail.com';
        $user2Data->phone = '514-222-2222';
        $user2Data->admin = 0;
        $user2Data->physicalAddress = 'Chez foo';
        $user2Data->password = 'bar123';

        $user1->set($user1Data);
        $user2->set($user2Data);
        $userList = array($user1, $user2);
        $userCatalog->setUserList($userList);

        $emailParameter = 'bar@gmail.com';
        $pswParameter = 'bar123';
        $hashedPsw = Hash::make($pswParameter);
        $this->assertTrue($userCatalog->checkUser($emailParameter, $hashedPsw));

    }

    public function testFindUser()
    {
        $user1 = new User();
        $user2 = new user();
        $user1Data = new \stdClass();
        $user2Data = new \stdClass();
        $userCatalog = new UserCatalog();

        $user1Data->id = 1;
        $user1Data->firstName = 'foo1';
        $user1Data->lastName = 'bar1';
        $user1Data->email = 'foo@gmail.com';
        $user1Data->phone = '514-111-1111';
        $user1Data->admin = 0;
        $user1Data->physicalAddress = 'Chez bar';
        $user1Data->password = 'foo123';

        $user2Data->id = 2;
        $user2Data->firstName = 'foo2';
        $user2Data->lastName = 'bar2';
        $user2Data->email = 'bar@gmail.com';
        $user2Data->phone = '514-222-2222';
        $user2Data->admin = 0;
        $user2Data->physicalAddress = 'Chez foo';
        $user2Data->password = 'bar123';

        $user1->set($user1Data);
        $user2->set($user2Data);
        $userList = array($user1, $user2);
        $userCatalog->setUserList($userList);

        $emailParameter = 'bar@gmail.com';

        $this->assertTrue($userCatalog->findUser($emailParameter));
    }

    public function testMakeCustomer()
    {
        $user1 = new User();
        $user2 = new user();
        $user1Data = new \stdClass();
        $user2Data = new \stdClass();
        $userCatalog = new UserCatalog();

        $user1Data->id = 1;
        $user1Data->firstName = 'foo1';
        $user1Data->lastName = 'bar1';
        $user1Data->email = 'foo@gmail.com';
        $user1Data->phone = '514-111-1111';
        $user1Data->admin = 0;
        $user1Data->physicalAddress = 'Chez bar';
        $user1Data->password = 'foo123';

        $user2Data->id = 2;
        $user2Data->firstName = 'foo2';
        $user2Data->lastName = 'bar2';
        $user2Data->email = 'bar@gmail.com';
        $user2Data->phone = '514-222-2222';
        $user2Data->admin = 0;
        $user2Data->physicalAddress = 'Chez foo';
        $user2Data->password = 'bar123';

        $user1->set($user1Data);
        $user2->set($user2Data);
        $userList = array($user1, $user2);
        $userCatalog->setUserList($userList);
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

        $userCatalog->makeCustomer($user3Data);
        //dump($userCatalog);
        $newUserList = $userCatalog->getUserList();
        //$total = count($newUserList);
        //dump($total);
        $this->assertTrue(count($newUserList) == 3);
    }
}
