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

Route::get('/', function () {
    return view('pages.index');
});

Route::get('/login', function () {
    return view('pages.login');
});

Route::post('login', function() {
     
});

Route::get('/inventory', function () {
    return view('pages.inventory');
});

Route::get('/add-items', function () {
    return view('pages.add-items');
});

/*
Route::get('/welcome', function () {
    return view('welcome');
});
*/
