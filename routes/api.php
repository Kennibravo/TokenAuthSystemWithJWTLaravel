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

        //Artisan group of routes
        Route::group(['prefix' => 'artisan'], function() {
            Route::get('get_artisan', 'ArtisanController@get_all'); // it fetches all the artisans
			Route::get('get_artisan/{id}', 'ArtisanController@get_id'); // to fetch all artisans by id
			Route::any('add_artisan', 'ArtisanController@store');//for adding a new artisan
			Route::put('edit_artisan/{id}','ArtisanController@update');//for updating an artisan
			Route::delete('delete_artisan/{id}','ArtisanController@destroy'); //for deleting an artisan
        });
        
        Route::group(['prefix' => 'customer'], function() {
        //Customer group of routes
		Route::get('getCustomer', 'customer\CustomerController@getAllCustomer');
		Route::get('getCustomerById/{id}', 'customer\CustomerController@getCustomerById');
		Route::put('updateCustomerProfile/{id}', 'customer\CustomerController@updateCustomerProfile');

	});


    });



