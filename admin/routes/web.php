<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    //==========DASHBOAR=========
    Route::get('dashboard', 'DashboardController@show');
    //==========USER=========
    Route::get('user/list', 'UserController@list');
    Route::get('user/add', 'UserController@add');
    Route::post('user/store', 'UserController@store');
    Route::post('user/update/{id}', 'UserController@update')->name('user.update');
    Route::get('user/delete/{id}', 'UserController@delete')->name('delete.user');
    Route::get('user/edit/{id}', 'UserController@edit')->name('edit.user');
    Route::post('user/action', 'UserController@action');
});
