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
Route::get('get_artisan', 'ArtisanController@get_all'); // it fetches all the artisans
Route::get('get_artisan/{id}', 'ArtisanController@get_id'); // to fetch all artisans by id
Route::any('add_artisan', 'ArtisanController@store');//for adding a new artisan
Route::put('edit_artisan/{id}','ArtisanController@update');//for updating an artisan
Route::delete('delete_artisan/{id}','ArtisanController@destroy'); //for deleting an artisan

