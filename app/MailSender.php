<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mail;
use Illuminate\Mail\Message; 
use Illuminate\Support\Facades\Log;

use Sofa\Eloquence\Eloquence; // base trait
use Sofa\Eloquence\Mappable; // extension trait

class MailSender extends Model
{
    //
    public static function sendFranchiseInquiry($proposed_location,$first_name,$last_name,$email_address,$contact_number,$home_address,$remarks){
    	try{
    		//
    		// variables [ locality , brand , proposed_location , first_name , last_name , email_address , contact_number , home_address , remarks]
    		$email_subject = "Franchise Inquiry"; 
    		Mail::send('mails.franchise_inquiry',[ 
	            'proposed_location'     => $proposed_location,
	            'first_name' 			=> $first_name,
	            'last_name' 			=> $last_name,
	            'email_address' 		=> $email_address,
	            'contact_number' 		=> $contact_number,
	            'home_address' 			=> $home_address,
	            'remarks' 				=> $remarks
	        ],function($mail) use ($email_subject){
	            $mail->from('web@datalogicorp.com','Datalogic');
	            $mail->to('franchise@datalogicorp.com'); //franchise@foodasia-group.com
	            $mail->subject($email_subject);
	        });

     	}catch(\Exception $e){
     		Log::error( $e->getMessage() );
     		return false;
     		
    	}
    	return true;
    }

    public static function sendContactInquiry($first_name,$last_name,$email_address,$contact_number,$subject,$message){
    	try{
    		//
    		// variables [ locality , brand , proposed_location , first_name , last_name , email_address , contact_number , home_address , remarks]  
    		$email_subject = 'About Inquiry';  
    		Mail::send('mails.contact_inquiry',[ 
	            'first_name' 			=> $first_name,
	            'last_name' 			=> $last_name,
	            'email_address' 		=> $email_address,
	            'contact_number' 		=> $contact_number, 
	            'subject'				=> $subject,
	            'c_message'				=> $message
	        ],function($mail) use ($email_subject){
	            $mail->from('web@datalogicorp.com','Datalogic');
	            $mail->to('info@datalogicorp.com');//info@foodasia-group.com
	            $mail->subject($email_subject);
	        });

     	}catch(\Exception $e){
     		Log::error( $e->getMessage() );
     		return false;
    	}
    	return true;
    }
}
