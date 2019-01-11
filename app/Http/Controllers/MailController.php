<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MailSender;
use Validator;

use App\Jobs\SendFranchiseInquiryEmail;
use App\Jobs\SendContactInquiryEmail;
use Carbon\Carbon;

class MailController extends Controller
{
    //  
    public function franchiseInquiry(Request $request){
    	// variables [ locality , brand , proposed_location , first_name , last_name , email_address , contact_number , home_address , remarks]
    	$credentials = $request->only( 
    		'proposed_location',
    		'first_name',
    		'last_name',
    		'email_address',
    		'contact_number',
    		'home_address',
    		'remarks'
    	);

        $rules = [ 
    		'proposed_location' => 'required',
    		'first_name' 		=> 'required',
    		'last_name' 		=> 'required',
    		'email_address' 	=> 'required|email',
    		'contact_number' 	=> 'required',
    		'home_address' 		=> 'required',
        ];

        //apply tayo ng validation
        $validator = Validator::make($credentials,$rules);
        if($validator->fails()){
            return response()->json([
                'success'=>false,
                //'message'=>$validator->messages()
                'message'=>'All fields are required.'
            ],400);
        } 

        // MailSender::sendFranchiseInquiry(
        //  $request->locality,
        //  $request->brand,
        //  $request->proposed_location, 
        //  $request->first_name, 
        //  $request->last_name, 
        //  $request->email_address, 
        //  $request->contact_number, 
        //  $request->home_address, 
        //  $request->remarks
        // );
        $job = (new SendFranchiseInquiryEmail(
                    $request->proposed_location, 
                    strtoupper($request->first_name), 
                    strtoupper($request->last_name), 
                    $request->email_address, 
                    $request->contact_number, 
                    $request->home_address, 
                    $request->remarks
                    ))
                    ->delay(Carbon::now()->addSeconds(5));
        dispatch($job);  
 
 		return response()->json([
            'success'=>true,
            'message'=>'Franchise inquiry has been sent.' 
        ],200);

    }

    public function contactInquiry(Request $request){
    	// variables [ locality , brand , proposed_location , first_name , last_name , email_address , contact_number , home_address , remarks]

    	$credentials = $request->only(
    		'first_name',
    		'last_name',
    		'email_address',
    		'contact_number',
    		'subject',
    		'message'
    	);

        $rules = [
    		'first_name' 		=> 'required',
    		'last_name' 		=> 'required',
    		'email_address' 	=> 'required|email',
    		'contact_number' 	=> 'required',
    		'subject' 			=> 'required',
    		'message' 			=> 'required'
        ];

        //apply tayo ng validation
        $validator = Validator::make($credentials,$rules);
        if($validator->fails()){
            return response()->json([
                'success'=>false,
                //'message'=>$validator->messages()
                'message'=>'All fields are required.'
            ],400);
        }
        

        // MailSender::sendContactInquiry(
        //  $request->first_name, 
        //  $request->last_name, 
        //  $request->email_address, 
        //  $request->contact_number, 
        //  $request->subject, 
        //  $request->message
        // );
        
        $job = (new SendContactInquiryEmail(
                    strtoupper($request->first_name), 
                    strtoupper($request->last_name), 
                    $request->email_address, 
                    $request->contact_number, 
                    strtoupper($request->subject), 
                    $request->message
                    ))
                    ->delay(Carbon::now()->addSeconds(5));
        dispatch($job);  

 		return response()->json([
            'success'=>true,
            'message'=>'Your message has been sent.'
        ],200);

    }
}
