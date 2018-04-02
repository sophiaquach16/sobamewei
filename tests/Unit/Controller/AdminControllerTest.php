<?php
/**
 * Created by PhpStorm.
 * User: Mel
 * Date: 2018-02-23
 * Time: 5:23 PM
 */

use Tests\TestCase;
use App\Http\Controllers\AdminController;
use App\Classes\Core\User;

class AdminControllerTest extends TestCase
{

    protected $fillable = [
        'id', 'name', 'email', 'password', 'admin',
    ];

    public function aFunction()
    {

        $user = new User();
        $userData = new \stdClass();

        $userData->id = '1';
        $userData->firstName = 'John';
        $userData->lastName = 'Doe';
        $userData->email = 'johndoe123@gmail.com';
        $userData->phone = '123-456-7890';
        $userData->admin = '1';
        $userData->physicalAddress = '1234 Wallstreet';
        $userData->password = 'password123';

        $user->set($userData);
        Auth::login($user);
        Auth::check();
        $this->be($user);
//        $adminLog = $this->post('/login', ['email' => 'admin1@conushop.com',
//        'password' => 'admin'])
//            ->assertSee('Successfully logged in.');
        //$this->loginWithFakeUser();
       // $addItem = $this->post('add-items', ['some_field' => 'some_value'])
        //    ->assertSee('expected result');
//        var_dump("betch");
//        var_dump($addItem);
    }

    public function loginWithFakeUser()
    {
        $user = new App\Classes\Core\User([
            'id' => 1,
            'admin' => 1,
            'email' => 'admin1@conushop.com',
            'password' => '$2y$10$CCdVyhydRyjluMY7/39VL.A1atziI7EAdRHhWyFkZyMKOfMlFl3GW',

        ]);
      //  $user = App\Classes\Core\User::first();
        $this->be($user);
    }
}