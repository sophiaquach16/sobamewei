<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\Core\User;

class UserClassTest extends TestCase {

    /**
     * A test for the get and set methods of the user class
     *
     * @return void
     */
    public function testSetGetTest() {
        $user = new User();

        $userData = new \stdClass();

        $userData->id = '1';
        $userData->firstName = 'John';
        $userData->lastName = 'Doe';
        $userData->email = 'johndoe123@gmail.com';
        $userData->phone = '123-456-7890';
        $userData->admin = '0';
        $userData->physicalAddress = '1234 Wallstreet';
        $userData->password = 'password123';

        $user->set($userData);

        $result = true;

        foreach ($userData as $key => $value) {
            if ($userData->$key !== $user->get()->$key) {
                $result = false;
            }
            /*
              // To debug a test, use echo to print on the terminal
              echo "\r\n";
              echo $u->$key;
              echo "\r\n";
              echo $user->get()->$key;
             */
        }

        $this->assertTrue($result);
    }

}
