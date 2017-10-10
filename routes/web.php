<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

use App\ElectronicTDG;

Route::get('/', function () {
    return view('pages.index');
});

Route::get('login', array(
    'as' => 'login',
    'uses' => 'MainController@showLogin'
));

Route::post('login', array(
    'uses' => 'MainController@doLogin'
));

Route::get('logout', array(
    'uses' => 'AuthController@doLogout'
));

Route::get('/inventory', array(
    'uses' => 'AdminController@showInventory'
));

Route::get('/add-items', array(
    'uses' => 'AdminController@showAddItems'
));

Route::post('add-items', array(
    'uses' => 'AdminController@doAddItems'
));
