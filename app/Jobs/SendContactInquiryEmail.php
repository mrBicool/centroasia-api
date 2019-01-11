<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\MailSender; 

class SendContactInquiryEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $first_name; 
    protected $last_name;
    protected $email_address;
    protected $contact_number;
    protected $subject;
    protected $message;
    /** 
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($first_name,$last_name,$email_address,$contact_number,$subject,$message)
    {
        //
        $this->first_name       =$first_name;
        $this->last_name        =$last_name;
        $this->email_address    =$email_address;
        $this->contact_number   =$contact_number;
        $this->subject          =$subject;
        $this->message          =$message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        MailSender::sendContactInquiry( 
             $this->first_name, 
             $this->last_name, 
             $this->email_address, 
             $this->contact_number, 
             $this->subject, 
             $this->message
        );
    }
}
