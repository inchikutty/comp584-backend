<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}
	public function login($user, $password){
		if( ($user=="abc") && ($password =="123")){
			$user = "xyz";
			$password = "987";
			$response='{user:'.$user.',password:'.$password.'}';
			//fetch data from db match it against encrypted values above and if match then
			$response = (object) $response;

				return Response::json($response, 200);
		}else{
				return Response::json("Not logged in", 200);
		}
	}

}
