<?php

/**
* User : Karine Zhang
* Date : 2017-10-31
* @test
*/

namespace Tests\Unit;
use Tests\TestCase; 
use App\Classes\TDG\UserCatalogTDG;

class UserCatalogTDGTest extends TestCase {
    
    public function setUp(){
        $this->mockUser = new MockUser();
        $this->userCatalogTDG = new UserCatalogTDG();
        $this->userCatalogTDG->conn = new MockMySQLConnection();
    }

    public function testAdd(){		
        $this->userCatalogTDG->add($this->mockUser);

        $expected_query = "INSERT INTO User SET id = :id , firstName = :firstName , lastName = :lastName , email = :email , phone = :phone , admin = :admin , physicalAddress = :physicalAddress , password = :password ";        
        $result_query = $this->userCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $result_query);
    }

    public function testFind(){
        $this->userCatalogTDG->find($this->mockUser);    
        $expected_query = "SELECT id, firstname, lastName, email, phone, admin, physicalAddress, password FROM User WHERE id = :id AND firstName = :firstName AND lastName = :lastName AND email = :email AND phone = :phone AND admin = :admin AND physicalAddress = :physicalAddress AND password = :password";
        $result_query = $this->userCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $result_query);
    }

    public function testFindAll(){
        $this->userCatalogTDG->findAll();
        $expected_query = "SELECT * FROM User";
        $result_query = $this->userCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $result_query);
    }

    public function testInsertLoginLog(){
        $timestamp = "888888";
        $userId = $this->mockUser->id;
        $this->userCatalogTDG->insertLoginLog($userId, $timestamp);
        $expected_query = "INSERT INTO LoginLog SET User_id = :User_id , timestamp = :timestamp ";
        $result_query = $this->userCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $result_query);
    }

    public function testLogin(){
        $email = $this->mockUser->email;
        $password = $this->mockUser->password;
        $this->userCatalogTDG->login($email, $password);
        $expected_query = "SELECT * FROM User WHERE email = :email";
        $result_query = $this->userCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $result_query);
    }

    public function testDeleteUser(){
        $this->userCatalogTDG->deleteUser($this->mockUser);
        $expected_query = "DELETE FROM User WHERE id = :id";
        $result_query = $this->userCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $result_query);
    }
    
    public function testDeleteLoginLog(){
        $userId = $this->mockUser->id;
        $this->userCatalogTDG->deleteLoginLog($userId);
        $expected_query = "DELETE FROM LoginLog WHERE User_id = :User_id";
        $result_query = $this->userCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $result_query);
    }

    public function testDeleteUserTransaction(){
        $userId = $this->mockUser->id;
        $this->userCatalogTDG->deleteUserTransaction($userId);
        $expected_query = "DELETE FROM Transaction WHERE customer_id = :customer_id";
        $result_query = $this->userCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $result_query);
    }   

    public function testUnsetUserEI(){
        $userId = $this->mockUser->id;
        $this->userCatalogTDG->unsetUserEI($userId);
        $expected_query = "SELECT * FROM ElectronicItem";
        $result_query = $this->userCatalogTDG->conn->query_string;
        $this->assertTrue($expected_query === $result_query);
    } 
}
