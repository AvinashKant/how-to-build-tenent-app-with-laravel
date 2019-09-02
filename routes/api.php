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

Route::post('/getData', 'HomeController@getAppUser');

Route::group(['prefix' => '{user?}'], function () {
	Route::get('createpost', 'UserController@createPost')->name('createPostRoute');
	Route::get('createuser', 'UserController@createUser')->name('createUserRoute');
});
