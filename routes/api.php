<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('api')->post('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function ($router) {
    Route::post('/register', 'App\Http\Controllers\RegisterController@submit');
    Route::post('/login', 'App\Http\Controllers\AuthenticationController@login');
    Route::get('/province', 'App\Http\Controllers\ProvinceController@index');
    Route::get('/city/{province_id}', 'App\Http\Controllers\CityController@getByProvince');
    Route::get('/city', 'App\Http\Controllers\CityController@index');

});

Route::group(['middleware' => ['auth:api']], function ($router) {
    Route::get('/user/profile', 'App\Http\Controllers\UserController@getProfile');
    Route::post('/user/profile', 'App\Http\Controllers\UserController@updateProfile');
    Route::post('/user/password', 'App\Http\Controllers\UserController@updatePassword');
    Route::get('/user/book', 'App\Http\Controllers\UserController@getBooks');
    Route::post('/user/book', 'App\Http\Controllers\UserController@addBook');
    Route::get('/category', 'App\Http\Controllers\CategoryController@index');
    Route::get('/book/lookup', 'App\Http\Controllers\BookController@lookup');
    Route::get('/book/search', 'App\Http\Controllers\BookController@search');
    Route::get('/book/details/{id}', 'App\Http\Controllers\BookController@details');
    Route::post('/transaction/request', 'App\Http\Controllers\TransactionController@request');
    Route::post('/transaction/cancel', 'App\Http\Controllers\TransactionController@cancel');
    Route::post('/transaction/approve', 'App\Http\Controllers\TransactionController@approve');
    Route::post('/transaction/reject', 'App\Http\Controllers\TransactionController@reject');
    Route::post('/transaction/send', 'App\Http\Controllers\TransactionController@send');
    Route::post('/transaction/send_back', 'App\Http\Controllers\TransactionController@sendBack');
    Route::get('/user/my_request', 'App\Http\Controllers\UserController@myRequest');
    Route::get('/user/incoming_request', 'App\Http\Controllers\UserController@incomingRequest');
});