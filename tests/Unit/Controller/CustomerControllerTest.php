<?php
/**
 * Created by PhpStorm.
 * User: Mel
 * Date: 2018-02-23
 * Time: 10:43 PM
 */

use Tests\TestCase;
use App\Http\Controllers\AuthController;

class CustomerControllerTest extends TestCase
{
    protected $fillable = [
        'id', 'name', 'email', 'password',
    ];

    public function AddToCart()
    {
        $controller = new AuthController();
        $this->loginWithFakeUser();
        $addItemToCart = $this->post('/add-to-cart?eSId=1', ['eSId' => '1'])
            ->assertSee('');
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