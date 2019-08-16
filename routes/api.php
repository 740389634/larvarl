<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
Route::post('show/product', 'ShowController@product');
Route::post('show/shopping', 'ShowController@shopping');
Route::post('show/user_name', 'ShowController@user_name');
Route::post('show/area', 'ShowController@area');
Route::post('cate/buycar', 'CateController@buycar');
Route::post('cate/shopping_cate', 'CateController@shopping_cate');
Route::post('cate/number', 'CateController@number');
Route::post('order/address', 'OrderController@address');
Route::post('order/order', 'OrderController@order');
Route::post('order/ress', 'OrderController@ress');
Route::post('order/addaction', 'OrderController@addaction');
Route::get('pay/pay', 'PayController@index');
Route::get('pay/return', 'PayController@return');
Route::any('pay/notify', 'PayController@notify');