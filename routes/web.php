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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/login', 'AuthController@loginView')->name('view-login');
Route::post('/login', 'AuthController@login')->name('login');
Route::get('/register', 'AuthController@registerView')->name('view-register');
Route::post('/register', 'AuthController@register')->name('register');
Route::get('/email-validate/{key}/{id}', 'AuthController@validateEmail')->name('v-email');
Route::get('/logout', 'AuthController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('board', 'BoardController');
    Route::resource('card', 'CardController');
    Route::resource('task', 'TaskController');
    Route::post('add-member', 'BoardController@addMember')->name('addMember');
    Route::post('add-archive', 'TaskController@addArchive')->name('addArchive');
});
