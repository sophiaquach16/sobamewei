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

date_default_timezone_set('America/Montreal');

Route::get('/', array(
    'uses' => 'MainController@showElectronicCatalog'
));

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

Route::post('inventory', array(
    'uses' => 'AdminController@doModifyOrDelete'
));

Route::post('modify', array(
    'uses' => 'AdminController@doModify'
));

Route::get('/add-items', array(
    'uses' => 'AdminController@showAddItems'
));

Route::post('add-items', array(
    'uses' => 'AdminController@doAddItems'
));

Route::get('registration', array(
    'uses' => 'MainController@showRegistration'
));

Route::post('registration', array(
    'uses' => 'MainController@doRegistration'
));

Route::get('details', array(
    'uses' => 'MainController@showDetails'
));

Route::get('add-to-cart',array(
    'uses'=>'CustomerController@doAddToCart'
));
Route::get('shopping-cart', array(
    'uses' => 'CustomerController@doViewCart'
));
Route::get('remove-from-cart',array(
    'uses' => 'CustomerController@doRemove'
));
Route::post('shopping-cart',array(
    'uses' => 'CustomerController@doPurchase'
));
Route::get('my-account', array(
    'uses' => 'CustomerController@showTransactions'
));

Route::post('my-account', array(
    'uses' => 'MainController@deleteUser'
));

Route::get('show-registered-users', array(
    'uses' => 'AdminController@showRegisteredUsers'
));

Route::post('show-transaction-details', array(
    'uses' => 'CustomerController@showTransactionDetails'
));
Route::post('return', array(
    'uses' => 'CustomerController@doReturnPurchase'
));