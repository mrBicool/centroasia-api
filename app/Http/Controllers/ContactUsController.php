<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactUs;

class ContactUsController extends Controller
{
    //
    public function store(Request $request){

        ContactUs::create($request->all());

        return response()->json([
            'message' => 'Success'
        ]);
    }
}
