<?php

/**
* User : Karine Zhang
* Date : 2017-10-31
* @test
*/

namespace Tests\Unit;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\Core\User;
use App\Classes\Core\UserCatalog;
use App\Classes\TDG\UserCatalogTDG;
use App\Classes\Mappers\UserCatalogMapper;

class UserCatalogTDGTest extends TestCase {

//Test the add method in UserCatalogTDG to see if user got added into the database
	public function testAdd(){
		$userCatalogTDG = new UserCatalogTDG();
		
		$userData = new \stdClass();

		//create user with all its parameters 
		$userData->firstName = 'Jay';
		$userData->lastName = 'Lin';
		$userData->email = 'jlin@hotmail.com';
		$userData->phone = '6789998212';
		$userData->admin = 0;
		$userData->physicalAddress = '111 St-Laurent Street';
		$userData->password = '123';
		$user= new User($userData);

		$userCatalogTDG->add($user);
		
		$this->assertDatabaseHas('User', [
            'email' => 'jlin@hotmail.com'
        ]);
	}

	//Test the login method in UserCatalogTDG to see if user has been logged in succesfully
	public function testLogin(){
		
		$userCatalogMapper = new UserCatalogMapper();
	    
		$this->assertTrue($userCatalogMapper->login('admin1@conushop.com','admin'));
	}

	//Test the find method in UserCatalogTDG, to make sure that a particular user is saved in the database
	public function testFind(){
		$userCatalogTDG = new UserCatalogTDG();
		$userData = new \stdClass();
        
		//create user with all its parameters
		$userData->firstName = 'Eric';
		$userData->lastName = 'Watson';
		$userData->email = 'ewat@aol.com';
		$userData->phone = '443-885-3424';
		$userData->physicalAddress = '150 Whatsit Avenue';
		$userData->password = '1e2r3ic';

		$user= new User($userData);
		$userCatalogTDG->add($user);

		// Make sure we don't search with information we shouldn't have.
		unset($userData->password);

		// Make sure we only have one result.
		$this->assertTrue(count($userCatalogTDG->find($userData)) == 1);
	}

}