<?php

namespace App\Http\Controllers\CustomAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function broker() {
        return Password::broker('users');
    }

    /**
    * Display the form to request a password reset link.
    *
    * @return \Illuminate\Http\Response
    */
    public function showLinkRequestForm()
    { // show form
        return view('forgetpassword.forget-password');
    }

    /**
    * Send a reset link to the given user.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
    */
    public function sendResetLinkEmail(Request $request)
    { //post method
        $this->validateEmail($request);
            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );

            return $response == Password::RESET_LINK_SENT
                        ? $this->sendResetLinkResponse($response)->with('message','Please Check Your Inbox If Not Check Your Span Inbox')
                        : $this->sendResetLinkFailedResponse($request, $response)->with('message','Your Email Is Invalid');            

    }
}


