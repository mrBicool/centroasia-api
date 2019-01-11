<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\User;
use Validator;
use Carbon\Carbon;
use App\Product;

class CartController extends Controller
{
    // 
    public function addToCart(Request $request){ 
    	$data	=	$request->only('product_id','qty');
    	$rules 	= 	[
    		'product_id'	=>	'required',
            'qty'           =>  'required'
    	];

    	$validator	= 	Validator::make($data,$rules);
    	if($validator->fails()){
    		return response()->json([
    			'success'		=> 		false, 
    			'message'		=> 		'Product ID & Qty is required.'
    		],200);
    	}

    	$token = $request->header('token');
    	$user  = User::findByToken($token); 

    	$cart = Cart::findByUserAndProduct($user->account_code,$request->product_id);
    	if($cart){
    		$cart->qty = $cart->qty + $request->qty; 
    		$cart->save();

    	}else{
    		$cart = new Cart; 
	    	$cart->account_id 	= $user->account_code;
	    	$cart->product_id 	= $request->product_id;
	    	$cart->qty 			= $request->qty;
	    	$cart->save();
    	} 

    	return response()->json([
    			'success'		=> 		true, 
    			'message'		=> 		'Added to cart.'
    		],201);
    }

    public function removeItemFromCart(Request $request){
    	$data	=	$request->only('product_id');
    	$rules 	= 	[
    		'product_id'	=>	'required', 
    	];

    	$validator	= 	Validator::make($data,$rules);
    	if($validator->fails()){
    		return response()->json([
    			'success'		=> 		false, 
    			'message'		=> 		'Product ID is required.'
    		],200);
    	}

    	$token = $request->header('token');
    	$user  = User::findByToken($token); 

    	$cart = Cart::findByUserAndProduct($user->account_code,$request->product_id);
    	if(!$cart){
    		return response()->json([
    			'success'		=> 		false, 
    			'message'		=> 		'Cart item not found.'
    		],200);
    	}

    	$cart->delete();

    	return response()->json([
    			'success'		=> 		true, 
    			'message'		=> 		'Item has been removed.'
    		],200); 
    }

    public function getCart(Request $request){
    	$token = $request->header('token');
        
    	$user  = User::findByToken($token); 


        //dd($user->USERNAME);
    	$my_carts = Cart::findByUser($user->account_code); 
        //dd($my_carts); 

    	$c = array();
    	$total_amount = 0;
    	foreach($my_carts as $cart){
    		$part = Product::findById($cart->product_id);
            $amount = $cart->qty * ($part->unit_price + $user->sc) ;
    		$total_amount +=  $amount;
    		$data = [
    			'product_id' 	=> $cart->product_id,
    			'description'	=> trim($part->description), 
    			'qty' 			=> $cart->qty,
    			'price'			=> round($part->unit_price, 2),
    			'amount'		=> round($amount,2),
                'surcharge'     => $user->sc
    		];
    		array_push($c , $data);
    	}  


    	$data = [
    		'total_amount' 	=> $total_amount,
    		'items' 		=> $c
    	];
    	return response()->json([
    			'success'		=> 	true, 
    			'message'		=> 	'Carts Item list.',
    			'data'			=>  $data
    		],200); 
    }

    public function deleteCart(Request $request){
    	$token = $request->header('token');
    	$user  = User::findByToken($token); 

    	$result = Cart::removeCartByUserID($user->account_code);
    	if(!$result){
    		return response()->json([
    			'success'		=> 		false, 
    			'message'		=> 		'No cart can be remove.'
    		],200);
    	}

    	return response()->json([
    			'success'		=> 		true, 
    			'message'		=> 		'Cart successfuly removed.'
    		],200);
    }

    public function updateCart(Request $request){
    	$data	=	$request->only('product_id','qty');
    	$rules 	= 	[
    		'product_id'	=>	'required', 
    		'qty'			=> 	'required'
    	];

    	$validator	= 	Validator::make($data,$rules);
    	if($validator->fails()){
    		return response()->json([
    			'success'		=> 		false, 
    			'message'		=> 		'Product and Qty are required.'
    		],200);
    	}

    	$token = $request->header('token');
    	$user  = User::findByToken($token); 
        
    	$cart = Cart::findByUserAndProduct($user->account_code,$request->product_id);
        //dd($token,$user->ACCTCODE,$user->USERNAME,$cart);
    	if(!$cart){
    		return response()->json([
    			'success'		=> 		false, 
    			'message'		=> 		'Item not found.'
    		],200);
    	}

    	$cart->qty = $request->qty;
    	$cart->save();

    	return response()->json([
    			'success'		=> 		true, 
    			'message'		=> 		'You have successfuly updated item on cart.'
    		],200);
    }
}
