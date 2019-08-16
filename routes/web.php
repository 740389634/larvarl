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

Route::get('add', function () {
    echo $hashed = Hash::make('bb');
});
Route::group(['middleware' => App\Http\Middleware\CheckLogin::class,], function () {
    Route::get('user/test', 'UserController@test');

});
Route::post('user/login', 'UserController@login');;
Route::get('user/show', 'UserController@show');
Route::post('user/add_login', 'UserController@add_login');
Route::post('user/action_login', 'UserController@action_login');
Route::post('user/delete', 'UserController@delete');
Route::post('user/addaction', 'UserController@addaction');
Route::post('user/update', 'UserController@update');
Route::get('show/show', 'ShowController@show');
Route::get('show/show1', 'ShowController@show1');
Route::get('show/show2', 'ShowController@show2');
Route::get('show/goods', 'ShowController@goods');
Route::get('auth/login', 'AuthController@login');

