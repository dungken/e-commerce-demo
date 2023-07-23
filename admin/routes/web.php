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
    Route::get('dashboard', 'DashboardController@show')->middleware('verified')->middleware('can:dashboard.view');
    Route::get('dashboard/delete/{id}', 'DashboardController@delete')->name('dashboard.delete')->middleware('can:dashboard.delete');
    //==============USER===============
    Route::get('user/list', 'UserController@list')->name('user.list')->middleware('can:user.view');
    Route::get('user/add', 'UserController@add')->middleware('can:user.add');
    Route::post('user/store', 'UserController@store')->name('user.store')->middleware('can:user.add');
    Route::get('user/delete/{id}', 'UserController@delete')->name('user.delete')->middleware('can:user.delete');
    Route::get('user/edit/{user}', 'UserController@edit')->name('user.edit')->middleware('can:user.edit');
    Route::post('user/update/{user}', 'UserController@update')->name('user.update')->middleware('can:user.edit');
    Route::post('user/action/{status}', 'UserController@action')->name('user.action')->middleware('can:user.view');
    //==============PAGE===============
    Route::get('page/list', 'PageController@list')->middleware('can:page.view');
    Route::get('page/add', 'PageController@add')->middleware('can:page.add');
    Route::post('page/store', 'PageController@store')->name('page.store')->middleware('can:page.add');
    Route::get('page/delete/{id}', 'PageController@delete')->name('page.delete')->middleware('can:page.delele');
    Route::get('page/edit/{id}', 'PageController@edit')->name('page.edit')->middleware('can:page.edit');
    Route::post('page/updte/{id}', 'PageController@update')->name('page.update')->middleware('can:page.edit');
    Route::post('page/action/{status}', 'PageController@action')->name('page.action')->middleware('can:page.view');
    //==============POST===============
    Route::get('post/cat/add', 'PostController@addCat')->middleware('can:post.cat.add');
    Route::post('post/cat/addStore/', 'PostController@catStore')->name('post.cat.addStore')->middleware('can:post.cat.add');
    Route::get('post/cat/list', 'PostController@listCat')->middleware('can:post.cat.view');
    Route::get('post/cat/delete/{catId}', 'PostController@deleteCat')->name('post.cat.delete')->middleware('can:post.cat.delete');
    Route::get('post/cat/edit/{catId}', 'PostController@editCat')->name('post.cat.edit')->middleware('can:post.cat.edit');
    Route::post('post/cat/update/{catId}', 'PostController@updateCat')->name('post.cat.update')->middleware('can:post.cat.edit');

    Route::get('post/add', 'PostController@add')->middleware('can:post.add');
    Route::post('post/store', 'PostController@store')->name('post.addStore')->middleware('can:post.add');
    Route::get('post/list', 'PostController@list')->middleware('can:post.view');
    Route::get('post/delete/{id}', 'PostController@delete')->name('post.delete')->middleware('can:post.delele');
    Route::get('post/edit/{id}', 'PostController@edit')->name('post.edit')->middleware('can:post.edit');
    Route::post('post/action/{status}', 'PostController@action')->name('post.action')->middleware('can:post.view');
    Route::post('post/update/{id}', 'PostController@update')->name('post.update')->middleware('can:post.edit');
    //==============PRODUCT===============
    Route::get('product/cat/add', 'ProductController@addCat')->middleware('can:product.cat.add');
    Route::post('product/cat/addStore/', 'ProductController@catStore')->name('product.cat.addStore')->middleware('can:product.cat.add');
    Route::get('product/cat/list', 'ProductController@listCat')->middleware('can:product.cat.view');
    Route::get('product/cat/delete/{catId}', 'ProductController@deleteCat')->name('product.cat.delete')->middleware('can:product.cat.delete');
    Route::get('product/cat/edit/{catId}', 'ProductController@editCat')->name('product.cat.edit')->middleware('can:product.cat.edit');
    Route::post('product/cat/update/{catId}', 'ProductController@updateCat')->name('product.cat.update')->middleware('can:product.cat.edit');

    Route::get('product/add', 'ProductController@add')->middleware('can:product.add');
    Route::post('product/store', 'ProductController@store')->name('product.addStore')->middleware('can:product.add');
    Route::get('product/list', 'ProductController@list')->middleware('can:product.view');
    Route::get('product/delete/{id}', 'ProductController@delete')->name('product.delete')->middleware('can:product.delete');
    Route::get('product/edit/{id}', 'ProductController@edit')->name('product.edit')->middleware('can:product.edit');
    Route::post('product/action/{status}', 'ProductController@action')->name('product.action')->middleware('can:product.view');
    Route::post('product/update/{id}', 'ProductController@update')->name('product.update')->middleware('can:product.edit');
    //==============ORDER===============
    Route::get('order/list', 'OrderController@list')->middleware('can:order.view');
    Route::post('order/action/{status}', 'OrderController@action')->name('order.action')->middleware('can:order.view');
    Route::get('order/delete/{id}', 'OrderController@delete')->name('order.delete')->middleware('can:order.delete');
    //==============ROLE===============
    Route::get('role/permission', 'RoleController@permission')->middleware('can:permission.add');
    Route::post('role/permission/permissionStore', 'RoleController@permissionStore')->name('role.permission.store')->middleware('can:permission.add');
    Route::get('role/permission/edit/{id}', 'RoleController@permissionEdit')->name('role.permission.edit')->middleware('can:permission.edit');
    Route::post('role/permission/update/{id}', 'RoleController@permissionUpdate')->name('role.permission.update')->middleware('can:permission.edit');
    Route::get('role/permission/delete/{id}', 'RoleController@permissionDelete')->name('role.permission.delete')->middleware('can:permission.delete');

    Route::get('role/add', 'RoleController@add')->middleware('can:role.add');
    Route::post('role/add/store', 'RoleController@store')->name('role.add.store')->middleware('can:role.add');
    Route::get('role/list', 'RoleController@list')->name('role.list')->middleware('can:role.view');
    Route::get('role/list/edit/{role}', 'RoleController@listEdit')->name('role.list.edit')->middleware('can:role.edit');
    Route::post('role/list/update/{role}', 'RoleController@listUpdate')->name('role.list.update')->middleware('can:role.edit');
    Route::get('role/list/delete/{id}', 'RoleController@listDelete')->name('role.list.delete')->middleware('can:role.delete');
});


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
