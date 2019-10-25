<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\ContactUs;
class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $username;
    protected $email;
    protected $user_message;

    public function __construct($username , $email , $user_message)
    {
        $this->username = $username;
        $this->email = $email;
        $this->user_message = $user_message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            $contactUs = new ContactUs($this->username,$this->email,$this->user_message); 
           Mail::to('alisonny2009@gmail.com')->send($contactUs);
    }
}
