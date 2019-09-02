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

Route::get('/', function () {
	return view('welcome');
});

/*
Route::get('websiteusers', 'HomeController@createWesiteUsers')->name('createWesiteUsersRoute');
Route::get('createandconnecthostname', 'HomeController@createAndConnectHostname')->name('createAndConnectHostnameRoute');
Route::get('switchtonewtenant', 'HomeController@switchToNewTenant')->name('switchToNewTenantRoute');

Route::get('createpost', 'HomeController@createPost')->name('createPostRoute');
 */
Route::get('listusers', 'UserController@listUsers')->name('listUsersRoute');
Route::get('createuser', 'UserController@createUserView')->name('createUserRoute');
Route::post('createuser', 'UserController@createTenantUser')->name('createUserPostRoute');

/*Route::group(['middleware' => 'tenancy.enforce'], function () {
Route::get('createpost', 'HomeController@createPost')->name('createPostRoute');
});

 */
Route::group(['prefix' => '{user?}'], function () {
	Route::get('createpost', 'UserController@createPost')->name('createPostRoute');
	Route::get('createuser', 'UserController@createUser')->name('createUserRoute');
});
