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
	Route::post('register', 'UserController@register')->name('register');
    Route::post('login', 'UserController@authenticate')->name('login');
    Route::post('logout', 'UserController@logout')->name('logout');


    Route::group(['middleware' => ['jwt.verify']], function() {
        Route::get('user', 'UserController@getAuthenticatedUser');
        Route::get('closed', 'DataController@closed');
    });
