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
		$password = '';
		$username = '';
		$id='';
		$name ='';
    $users = DB::table('users')->select([
       'username',
       'password',
 			'name',
			'id'
     ])->where('username', '!=', '')
 		->distinct()
 		->get();
    $users = (object) $users;

 		foreach ($users as $user) {
			$un = Crypt::decrypt($user->username);
			$pw = Crypt::decrypt($user->password);
 			if( ($member == $un) and ($pass == $pw ) ){
 				$username = $member;
 				$password = $pass;
				$id = $user->id;
 				$name = Crypt::decrypt($user->name);
 			}
 		}
     $currentUser = array(
			'username' => $username,
			'password' => $password,
			'name' => $name,
			'id' => $id
		);

     if($username == $member){
        return Response::json($currentUser, 200);
      }
      else {
        return Response::json("user not registered", 200);
     }
  }
	public function register( $member, $pass, $fullname ){

	 $username = null;
   $users = DB::table('users')->select(
      'users.username AS username'
    )->where('username', '!=', '')
		->distinct()
		->get();
     $users = (object) $users;
	   foreach ($users as $usr) {
			$un = Crypt::decrypt( $usr->username );
			if( $member == $un ){
				$username = $member;
			}
		}

    if($username == $member){
       return Response::json("user exists", 200);
     }

     else {
       DB::table('users')->insert([
				  'username' => Crypt::encrypt($member),
			    'password' => Crypt::encrypt($pass),
				  'name' => Crypt::encrypt($fullname)
			  ]);
       return Response::json($users, 201);
    }
  }
	public function deleteUsers($str){
		DB::table('users')->where('username','=',$str)->delete();
		return Response::json("deleted", 200);
	}

	public function sendMessage($sender, $receiver, $body){
		DB::table('messages')->insert([
			 'sender_id' => $sender,
			 'receiever_id' => $receiver,
			 'body' => Crypt::encrypt($body),
			 'hidden_to_sender' => 0,
			 'hidden_to_receiver' => 0,
				'receiever_read' => 0
		 ]);
		 return Response::json("sent", 200);
	}
	public function getMessages($user_id){
		$send_messages = DB::table('messages')->select(
       '*'
     )->where('sender_id', '=', $user_id)
 		->orderBy('id')
 		->get();
		foreach ($send_messages as $msg) {
			$msg->body = Crypt::decrypt($msg->body);
		}
		$received_messages = DB::table('messages')->select(
       '*'
     )->where('receiever_id', '=', $user_id)
 		->orderBy('id')
 		->get();
		foreach ($received_messages as $msg) {
			$msg->body = Crypt::decrypt($msg->body);
		}

		$messages= array(
			'send'=>$send_messages,
		 'received' =>$received_messages,
	 );
		return Response::json($messages, 200);
	}

	public function deleteMessage($user_id, $msg_id){
		$msg = DB::table('messages')->select('*')->where('id','=',$msg_id)->first();

		return Response::json($msg, 200);
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
