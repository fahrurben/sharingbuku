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

});

Route::group(['middleware' => ['auth:api']], function ($router) {
    Route::get('/user/profile', 'App\Http\Controllers\UserController@getProfile');
    Route::post('/user/profile', 'App\Http\Controllers\UserController@updateProfile');
});