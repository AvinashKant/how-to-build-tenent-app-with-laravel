<?php

Route::middleware('web')->namespace("App\Http\Controllers\Tenant")->group(function () {
	Route::get('/', 'HomeController');
});