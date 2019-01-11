<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\MailSender;

class SendFranchiseInquiryEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $proposed_location;
    protected $first_name;
    protected $last_name;
    protected $email_address;
    protected $contact_number;
    protected $home_address;
    protected $remarks;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($proposed_location,$first_name,$last_name,$email_address,$contact_number,$home_address,$remarks)
    {
        // 
        $this->proposed_location    =$proposed_location;
        $this->first_name           =$first_name;
        $this->last_name            =$last_name;
        $this->email_address        =$email_address;
        $this->contact_number       =$contact_number;
        $this->home_address         =$home_address;
        $this->remarks              =$remarks;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        MailSender::sendFranchiseInquiry( 
         $this->proposed_location, 
         $this->first_name, 
         $this->last_name, 
         $this->email_address, 
         $this->contact_number, 
         $this->home_address, 
         $this->remarks
        );
    }
}
