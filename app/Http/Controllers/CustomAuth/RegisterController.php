<?php

namespace App\Http\Controllers\CustomAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Events\NewUser;
class RegisterController extends Controller
{
    public function createaccountget() { // view Page 

        return view('register');
    }

    public function createaccountpost(Request $request) { // post

        $validator = \Validator::make($request->all() , [
            
            'firstname'     => 'required|regex:/(^(([a-zA-Z]+)([0-9]+)?(\s+)?)+$)/u', // Accepts strings and spaces and string with numbers(test test123)
            'lastname'      => 'required|string', 
            'email'         => 'required|email|unique:users', 
            'password'      => 'required|min:6', 
            'confirmpass'    => 'required|same:password'

        ])->validate();

        //->validate(); works With => old('inputname) 
        

        $storeUser = new User;
        $storeUser->firstname   = $request->firstname;
        $storeUser->lastname    = $request->lastname;
        $storeUser->email       = $request->email;
        $storeUser->password    = bcrypt($request->password);
        $saved = $storeUser->save();
        if($saved) {
            // return the new user to homepage with auth
            event(new NewUser($storeUser));
            \Auth::login($storeUser);
            return redirect('/homepage');     
        } else {
            return back();
        }


        
    }
}
