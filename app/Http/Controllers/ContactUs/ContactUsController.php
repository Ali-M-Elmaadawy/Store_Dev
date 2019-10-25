<?php

namespace App\Http\Controllers\ContactUs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\ContactUs;
// use App\jobs\SendEmailJob;
class ContactUsController extends Controller
{


	public function getcontactus() {

		return view('user_or_guest.contact_us');
	}

    public function postcontactus(Request $request) {

        	$validator = \Validator::make($request->all() , [
    
        		'username' 	=> 'required|string|min:3',
        		'email'		=> 'required|email',
        		'user_message'   => 'required|string|min:6'
    
        	])->validate();
    
            $username = $request->get('username');
            $email = $request->get('email');
            $user_message = $request->get('user_message');



            $send = Mail::to('alisonny2009@gmail.com')
                          ->send(new ContactUs($username,$email,$user_message));


 // ------------Start This Send Mail Will Be In Queue Job  --------------- // 
            // SendEmailJob::dispatch($username , $email , $user_message);
            // To Run The Queue => php artisan queue work
 // ------------End This Send Mail Will Be In Queue Job  --------------- // 

        // ------------This Will Not Use php artisan make:mail (mail name)---------------
        // $send = Mail::send('user_or_guest.contact_us_message',
        //    array(
        //        'username' => $request->get('username'),
        //        'email' => $request->get('email'),
        //        'user_message' => $request->get('user_message')
        //    ), function($message) {
        //    $message->from($request->get('email'));
        //    $message->to('alisonny2009@gmail.com', 'Admin')->subject('Contact Us');
       	//   });
    
        	return back()->with('message' , 'Your Email Sent Success');


    }
}