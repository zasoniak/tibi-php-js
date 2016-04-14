<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');


Route::get('/getmarkers','WelcomeController@getMarkers');

//Route::get('/newmarker/{lat}/{lng}/{desc}', 'WelcomeController@addNewMarker');

Route::get('/newmarker/{lat}/{lng}/{desc}', function($lat, $lng, $desc)
{
	$marker = Marker::create(['latitude' => $lat, 'longitude'=>$lng, 'description'=>$desc]);
	return $marker;
//	$markers = Marker::all()->toJson();
//	return $markers;
});

Route::get('/removemarker/{id}', 'WelcomeController@removeMarker');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
