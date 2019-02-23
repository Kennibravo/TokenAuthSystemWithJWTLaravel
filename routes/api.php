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

		//Unprotected Routes
Route::group(['prefix' => 'v1'], function(){
			Route::post('register', 'UserController@register')->name('register');
	    Route::post('login', 'UserController@authenticate')->name('login');
	    Route::post('logout', 'UserController@logout')->name('logout');



    	Route::group(['middleware' => ['jwt.verify']], function() { //Protected by JWT middleware
        // Route::get('user', 'UserController@getAuthenticatedUser');
        // Route::get('closed', 'DataController@closed');

    	//Artisan group of routes
      Route::group(['prefix' => 'artisan'], function() {


        //Get all artisans in the User's table and return JSON Objects
      Route::get('getArtisan', 'artisan\ArtisanController@getAllArtisan');

        //Get artisan details from the User's table based on the ID passed in and return JSON
			Route::get('getArtisanById/{id}', 'artisan\ArtisanController@getArtisanById');

			//Update Artisan's details in the User's table
			Route::put('updateArtisanProfile/{id}', 'artisan\ArtisanController@updateArtisanProfile');

        });


        //Customer group of routes
      Route::group(['prefix' => 'customer'], function() {
       	//Get all customers in the User's table and return JSON Objects
			Route::get('getCustomer', 'customer\CustomerController@getAllCustomer');

			//Get customer details from the User's table based on the ID passed in and return JSON Object
			Route::get('getCustomerById/{id}', 'customer\CustomerController@getCustomerById');

			//Update Customer's details in the User's table
			Route::put('updateCustomerProfile', 'customer\CustomerController@updateCustomerProfile');

			//The services route...
			Route::group(['prefix' => 'services'], function(){

			//Get all services created by a specific customer
			Route::get('getServices', 'customer\CustomerServiceController@index');

			//Create as new services for the customers
			Route::post('createService', 'customer\CustomerServiceController@store');

			//View services created based on current user
			Route::get('showService/{id}', 'customer\CustomerServiceController@show');

			//Edit the specified services.
			Route::put('editService/{id}', 'customer\CustomerServiceController@update');

			//Delete the specified service
			Route::delete('deleteService/{id}', 'customer\CustomerServiceController@destroy');
		});
	});


    });
});
