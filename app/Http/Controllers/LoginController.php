<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Hash;
use App\User;
use Carbon\Carbon;

class LoginController extends Controller
{
    //
    public function login(Request $request){

    	$data	=	$request->only('username','password');
    	$rules 	= 	[
    		'username'		=>	'required',
    		'password'		=>	'required', 
    	];

    	$validator	= 	Validator::make($data,$rules);
    	if($validator->fails()){
    		return response()->json([
    			'success'		=> 		false, 
    			'message'		=> 		'All fields are required.'
    		],200);
    	}
        
    	$user = User::findByUsername($request->username); 
    	if(is_null($user) || !$user){
    		return response()->json([
    			'success'		=> 		false, 
    			'message'		=> 		'Invalid Username.'
    		],200);
    	}

	
    	//if(!Hash::check($request->password,$user->password)){ 
    	if($request->password!=$user->password){
    		return response()->json([
    			'success'		=> 		false,
    			'message'		=> 		'Invalid Password.'
    		],200);
    	}
    	
    	//issuing a token
    	$gentoken       = $user::generateToken($user->username); 
    	$user->token 	= $gentoken;
    	$user->save();


    	$data = [
    		'token'		      =>	$gentoken,
    		'user'		      => 	$user->username,
            'account_name'    =>    $user->account_name
    	];
    	return response()->json([
    			'success'		=> 		true,
    			'message'		=> 		'Access granted.',
    			'data'			=> 		$data
    		],200);
    }
}
