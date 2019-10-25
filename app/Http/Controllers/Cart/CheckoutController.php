<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cookie;
use App\Product;
use App\TheOrder;
use App\Events\MakeOrder;
class CheckoutController extends Controller
{


    public function checkout() {
        
        if(! \Auth::check()) {
            return back()->with('message' , 'Login First');
        }

        $userData = \Auth::user();

        $username 	= $userData->firstname." ".$userData->lastname;
        $email		= $userData->email;

        // Get products Details From Cookie

        // If The Cookie cart Exists
        if(Cookie::get('cart') && Cookie::get('qty_array') ) {
            $cartArray = Cookie::get('cart');
            // Change cartArrayDecode To Array         
            $cartArrayDecode = json_decode($cartArray);
            // Get qty_array Cookie
            $qty_array_cookie = Cookie::get('qty_array');
            // Change qty_array_cookie To Array         
            $qty_array = json_decode($qty_array_cookie);   

            $productsDetails = Product::whereIn('id' , $cartArrayDecode)->with(['productdetails'=>function($que){
                $que->select('product_id','image' , 'price');
            } ] , 'category' , 'subcategory')->get();


            // Start Get products Ids Array From $productsDetails
            $productsArray = [];
            foreach($productsDetails as $product) {

                $productsArray[] = $product->id;
            }

            // Convert The Array To String To Save It In DB
            $productsArray = implode('-', $productsArray);

        } else {

            return redirect()->back();
        }

        
        return view('user_or_guest.checkout' , compact(['username','email','productsDetails','qty_array','productsArray']));
    }

    public function checkoutonline() {
        
        if(! \Auth::check()) {
            return back()->with('message' , 'Login First');
        }

        $userData = \Auth::user();

        $username   = $userData->firstname." ".$userData->lastname;
        $email      = $userData->email;

        // Get products Details From Cookie

        // If The Cookie cart Exists
        if(Cookie::get('cart') && Cookie::get('qty_array') ) {
            $cartArray = Cookie::get('cart');
            // Change cartArrayDecode To Array         
            $cartArrayDecode = json_decode($cartArray);
            // Get qty_array Cookie
            $qty_array_cookie = Cookie::get('qty_array');
            // Change qty_array_cookie To Array         
            $qty_array = json_decode($qty_array_cookie);   

            $productsDetails = Product::whereIn('id' , $cartArrayDecode)->with(['productdetails'=>function($que){
                $que->select('product_id','image' , 'price');
            } ] , 'category' , 'subcategory')->get();


            // Start Get products Ids Array From $productsDetails
            $productsArray = [];
            foreach($productsDetails as $product) {

                $productsArray[] = $product->id;
            }

            // Convert The Array To String To Save It In DB
            $productsArray = implode('-', $productsArray);

        } else {

            return redirect()->back();
        }


        return view('user_or_guest.checkout_online' , compact(['username','email','productsDetails','qty_array','productsArray']));
    }



    public function postcheckout(Request $request) {


            // Get qty_array Cookie
            $qty_array_cookie = Cookie::get('qty_array');
            // Change qty_array_cookie To Array         
            $qty_array = json_decode($qty_array_cookie , true);

            $qty_array = implode('-', $qty_array);

        $validator = \Validator::make($request->all() , [

            'firstname'     =>  'required|regex:/(^(([a-zA-Z]+)([0-9]+)?(\s+)?)+$)/u',
            'lastname'	    =>  'required|regex:/(^(([a-zA-Z]+)([0-9]+)?(\s+)?)+$)/u',
            'company'       =>  'nullable|string',
            'address' 	    =>  'required|string',
            'city'		    =>  'required|string',
            'country'	    =>  'required|string',
            'goornorate'    =>  'required|string',
            'phone'		    =>  'required|numeric',
            'productsArray' =>  'required|string'
        ])->validate();

        // Check productsArray From The From Is Already In The products Cart
            // Get Cookie Cart
            $cartArray = Cookie::get('cart');
            // Change cartArrayDecode To Array         
            $cartArrayDecode = json_decode($cartArray , true);
            // Convert productsArray To Array Again 
            $productsArrayArray = explode('-' , $request->productsArray);
            // return $productsArrayArray;
            foreach($productsArrayArray as $product) {
                if(in_array($product, $cartArrayDecode)) {
                    $checkproduct = true;
                } else {
                    $checkproduct = false;
                }
            }


            if(! $checkproduct == true) {

               return redirect()->back();
            }

        $username =  $request->firstname." ".$request->lastname; 

        $startInsertData = new TheOrder;

        $startInsertData->firstname = $request->firstname;
        $startInsertData->user_id = auth()->user()->id;
        $startInsertData->lastname = $request->lastname;
        $startInsertData->company = $request->company;
        $startInsertData->address = $request->address;
        $startInsertData->city = $request->city;
        $startInsertData->country = $request->country;
        $startInsertData->goornorate = $request->goornorate;
        $startInsertData->phone = $request->phone;
        $startInsertData->products = $request->productsArray;
        $startInsertData->quantity_products = $qty_array;
        $startInsertData->save();

        if($startInsertData) {

            Cookie::queue('cart' , 'empty' , 60); // 100%
            Cookie::queue('qty_array' , 'empty' , 60); // 100%

            event(new MakeOrder($username));
        	return redirect('/success_checkout');
        }

    }




    public function successcheckout() {

        echo "<script>setTimeout(function(){ window.location.href = '/homepage'; }, 2000);</script>";
        return view('user_or_guest.success_checkout');

    }
}
