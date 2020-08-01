<?php

use Illuminate\Support\Facades\Route;

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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

//index and about page routes
Route::get('/', 'PageController@index');
Route::get('/about', 'PageController@about');

//departments routes
Route::resource('departments', 'DepartmentsController');

//users routes
Route::resource('users', 'UsersController');
Route::get('/users/{id}/edit/password', 'UsersController@changePassword');
Route::put('/users/{id}/edit/password', 'UsersController@updatePassword');

//chat routes
Route::get('/chat', 'MessagesController@index');
Route::get('/message/{id}', 'MessagesController@getMessage')->name('message');
Route::post('message', 'MessagesController@sendMessage');

Auth::routes();

//home routes
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@update_avatar');

