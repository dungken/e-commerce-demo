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

Route::middleware(['auth'])->group(function () {
    //==============DASHBOARD===============
    Route::get('dashboard', 'DashboardController@show')->middleware('verified');
    //==============USER===============
    Route::get('user/list', 'UserController@list')->name('user.list');
    Route::get('user/add', 'UserController@add');
    Route::get('user/delete/{id}', 'UserController@delete')->name('user.delete');
    Route::get('user/edit/{id}', 'UserController@edit')->name('user.edit');
    Route::post('user/store', 'UserController@store')->name('user.store');
    Route::post('user/action/{status}', 'UserController@action')->name('user.action');
    Route::post('user/update/{id}', 'UserController@update')->name('user.update');
    //==============PAGE===============
    Route::get('page/list', 'PageController@list');
    Route::get('page/add', 'PageController@add');
    Route::get('page/delete/{id}', 'PageController@delete')->name('page.delete');
    Route::get('page/edit/{id}', 'PageController@edit')->name('page.edit');
    Route::post('page/store', 'PageController@store')->name('page.store');
    Route::post('page/action/{status}', 'PageController@action')->name('page.action');
    Route::post('page/updte/{id}', 'PageController@update')->name('page.update');
    //==============POST===============
    Route::get('post/cat/add', 'PostController@addCat');
    Route::post('post/cat/addStore/', 'PostController@catStore')->name('post.cat.addStore');
    Route::get('post/cat/list', 'PostController@listCat');
    Route::get('post/cat/delete/{catId}', 'PostController@deleteCat')->name('post.cat.delete');
    Route::get('post/cat/edit/{catId}', 'PostController@editCat')->name('post.cat.edit');
    Route::post('post/cat/update/{catId}', 'PostController@updateCat')->name('post.cat.update');

    Route::get('post/add', 'PostController@add');
    Route::post('post/store', 'PostController@store')->name('post.addStore');
    Route::get('post/list', 'PostController@list');
    Route::get('post/delete/{id}', 'PostController@delete')->name('post.delete');
    Route::get('post/edit/{id}', 'PostController@edit')->name('post.edit');
    Route::post('post/action/{status}', 'PostController@action')->name('post.action');
    Route::post('post/update/{id}', 'PostController@update')->name('post.update');
    //==============PRODUCT===============
    Route::get('product/cat/add', 'ProductController@addCat');
    Route::post('product/cat/addStore/', 'ProductController@catStore')->name('product.cat.addStore');
    Route::get('product/cat/list', 'ProductController@listCat');
    Route::get('product/cat/delete/{catId}', 'ProductController@deleteCat')->name('product.cat.delete');
    Route::get('product/cat/edit/{catId}', 'ProductController@editCat')->name('product.cat.edit');
    Route::post('product/cat/update/{catId}', 'ProductController@updateCat')->name('product.cat.update');

    Route::get('product/add', 'ProductController@add');
    Route::post('product/store', 'ProductController@store')->name('product.addStore');
    Route::get('product/list', 'ProductController@list');
    Route::get('product/delete/{id}', 'ProductController@delete')->name('product.delete');
    Route::get('product/edit/{id}', 'ProductController@edit')->name('product.edit');
    Route::post('product/action/{status}', 'ProductController@action')->name('product.action');
    Route::post('product/update/{id}', 'ProductController@update')->name('product.update');
});


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
