<?php

namespace App\Http\Controllers\CustomAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected $redirectTo = '/homepage';


    public function getlogin() { // View Login Page

        return view('/login');
    }

    public function postlogin(Request $request) {

        $validator=\Validator::make($request->all() , [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        // If No Errors
        $remember_me = $request->has('remember') ? true : false;

            if(\Auth::attempt(['email' => $request->email, 'password' => $request->password]  , $remember_me)) {

                return redirect('/homepage');
               
            } else {
                // Not Auth
                return back()->with('message' , 'Email Or Pass Is Incorrect');
            }
        
    }
}
