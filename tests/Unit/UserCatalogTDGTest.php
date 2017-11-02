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

//Test the add and login methods to see if user infos got recorded onto the database
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

	
}