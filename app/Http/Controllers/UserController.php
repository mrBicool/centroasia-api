<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Carbon\Carbon;

class UserController extends Controller
{
    //
    public function get_delivery_address(Request $request){
    	$token = $request->header('token');

    	$data	=[
    		'token' 	=> $token
    	];	
    	$rules 	= 	[
    		'token'		=>	'required', 
    	];

    	$validator	= 	Validator::make($data,$rules);
    	if( $validator->fails() ){
    		return response()->json([
    			'success'		=> 		false, 
    			'message'		=> 		'Token is required.'
    		],200);
    	}

    	$user = User::isValidToken($token);
    	if( is_null($user) || !$user ){
    		return response()->json([
    			'success'		=> 		false, 
    			'message'		=> 		'Token not found.'
    		],200);
    	}

    	return response()->json([
			'success'		=> 		true, 
			'message'		=> 		'Success Request',
			'data'			=> 		$user->address
		],200);
    }

    public function get_personal_details(Request $request){
    	$token = $request->header('token');

    	$data	=[
    		'token' 	=> $token
    	];	
    	$rules 	= 	[
    		'token'		=>	'required', 
    	];

    	$validator	= 	Validator::make($data,$rules);
    	if( $validator->fails() ){
    		return response()->json([
    			'success'		=> 		false, 
    			'message'		=> 		'Token is required.'
    		],200);
    	}

    	$user = User::isValidToken($token);
    	if( is_null($user) || !$user ){
    		return response()->json([
    			'success'		=> 		false, 
    			'message'		=> 		'Token not found.'
    		],200);
    	}

    	return response()->json([
			'success'		=> 		true, 
			'message'		=> 		'Success Request',
			'data'			=> 		$user->account_name
		],200);
    }
}
