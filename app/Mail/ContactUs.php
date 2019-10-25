<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $username;
    public $email;
    public $user_message;

    public function __construct($username,$email,$user_message)
    {
        $this->username = $username;
        $this->email = $email;
        $this->user_message = $user_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // No Need To Pass Vairables Because It Is Public In Class
        return $this->view('user_or_guest.contact_us_message')->from('noreply@aliElmaadawy');
    }
}
