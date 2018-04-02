<?php
/**
 * Created by PhpStorm.
 * User: Mel
 * Date: 2018-02-22
 * Time: 9:51 PM
 */

use Tests\TestCase;
use App\Http\Controllers\AuthController;

class AuthControllerTest extends TestCase
{
    protected $fillable = [
        'id', 'name', 'email', 'password',
    ];

    public function testDoLogout()
    {
        $controller = new AuthController();
        $this->loginWithFakeUser();
        $redirect = $controller->doLogout();
        $this->followRedirects($redirect)
            ->assertSee("Successfully logged out.");
    }

    //found useful solution from here :
    // https://medium.com/yish/how-to-mock-authentication-user-on-unit-test-in-laravel-1441d491d82c
    public function loginWithFakeUser()
    {
        $user = new App\Classes\Core\User([
            'id' => 1,
            'name' => 'yish'
        ]);

        $this->be($user);
    }
}