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

<<<<<<< HEAD

Route::group(['middleware'=>['auth:api'], 'namespace'=>'Api'], function(){
	Route::resource('roles','RoleController');
	Route::get('verify', 'UserController@verify');
=======
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>['auth:api'], 'namespace'=>'Api'], function(){
	Route::resource('roles','RoleController');
>>>>>>> 013b3b04339bc5e1c3fd1261669922a6773f1102
});
 

Route::post('login', 'Api\UserController@login')->name('login');