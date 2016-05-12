<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});
Route::post('/api/user:{user}/password:{password}',['uses' => 'HomeController@login']);
Route::post('/api/user:{user}/password:{password}/name:{name}',['uses' => 'HomeController@register']);
Route::get('/api/en={str}',['uses' => 'HomeController@encrypt']);
Route::get('/api/de={str}',['uses' => 'HomeController@decrypt']);
Route::get('/api/del={str}', ['uses' => 'HomeController@deleteUsers']);
