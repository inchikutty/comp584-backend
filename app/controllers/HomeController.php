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
	public function login( $member, $pass ){
    //function for login
		$username = Crypt::encrypt($member);
		$password = Crypt::encrypt($pass);
		$user = DB::table('users')->select([
       'username',
       'password',
			 'name',
			 'id'
     ])
		 ->where('username', '=', $username)
		 ->where('password', '=', $password)
     ->first();
     if($user){
        return Response::json($user, 200);
      }
      else {
        return Response::json("user not registered", 200);
     }
  }
	public function register( $member, $pass, $fullname ){

   //function to register user $user is json object
	 //$date = date("Y-m-d");               // 2015-12-19
   //$time = date("h:i:s");               // 10:10:16
	 $username = Crypt::encrypt($member);
	 $password = Crypt::encrypt($pass);
	 $name = Crypt::encrypt($fullname);
   $user = DB::table('users')->select([
      'username',
      'password',
			'name'
    ])->where('username', '=', $username)
    ->get();
    if($user){
       return Response::json("user exists", 200);
     }
     else {
       DB::table('users')->insert([
				'username' => $username,
			  'password' => $password,
				'name' => $name
        ]);
       return Response::json("user added", 201);
    }
  }
	public function sendMessage($sender, $receiver, $body){

	}
	public function getMessages($user_id){

	}
	public function deleteMessage($user_id, $msg_id){

	}
	public function encrypt($str){
		$encrypted = Crypt::encrypt($str);
		return Response::json($encrypted, 200);

	}
	public function decrypt($str){
		$decrypted = Crypt::decrypt($str);
		return Response::json($decrypted, 200);
	}

}
