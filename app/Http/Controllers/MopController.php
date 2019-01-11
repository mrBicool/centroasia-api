<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mop;
use Carbon\Carbon;

class MopController extends Controller
{
    //
    public function index(Request $request){
    	$mop = Mop::all(); 
    	return response()->json([
                'success'       =>  true, 
                'message'       =>  'success.', 
                'data'			=> 	$mop
        ],200);
    }
}
