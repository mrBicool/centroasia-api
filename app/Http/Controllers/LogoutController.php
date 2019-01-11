<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Carbon\Carbon;

class LogoutController extends Controller
{
    //
    public function logout(Request $request){
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

    	$user->token = null; 
    	$user->save();

    	return response()->json([
    			'success'		=> 		true, 
    			'message'		=> 		'You have successfuly logged out.'
    		],200);

    }
}
