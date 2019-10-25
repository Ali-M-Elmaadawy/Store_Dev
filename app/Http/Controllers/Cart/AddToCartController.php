<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cookie;
use App\Product;
class AddToCartController extends Controller
{
    public function addtocart(Request $request) { 

        if($request->ajax()) {

            $theProductId =  $request->productId;

            $cartArray = Cookie::get('cart');

            // If Cookie 'cart' Exists
            if($cartArray != null) { 

                // Change cartArrayDecode To Array         
                $cartArrayDecode = json_decode($cartArray);
                // If cartArrayDecode Is Array = the Cookie cart Is Not empty
                if(is_array($cartArrayDecode)) {

                    // Check If Product Id Is Already In Array
                    if(! in_array($theProductId, $cartArrayDecode)) {
                        // Add Product Id To The Array
                        array_push($cartArrayDecode, $theProductId);
                        // Start Make The Convert The Array To Json 
                        $theProductIdInJson = json_encode($cartArrayDecode);
                        $countCartArrayDecode = count($cartArrayDecode);
                        // Making  $qty_array array 
                        $qty_array = array_fill(0 , $countCartArrayDecode , "1");
                        // Start Convert $qry_array To Json
                        $qty_array_json = json_encode($qty_array);
                        // Start Making qty_array Cookie    
                        Cookie::queue('qty_array' , $qty_array_json , 60);
                        // Start Get Products Which In Cart
                        $productsDetails = Product::whereIn('id' , $cartArrayDecode)->with(['productdetails'=>function($que){
                            $que->select('product_id','image' , 'price');
                        } ] , 'category' , 'subcategory')->get();
                           
                        Cookie::queue('cart' , $theProductIdInJson , 60); // 100%
                        return  [
                                    'message'       =>'Product added to ArrayCart' , 
                                    'productId'     =>$theProductId , 
                                    'countOfCart'   =>$countCartArrayDecode,
                                    'productsInMenu'=>view('user_or_guest.products-in-menu-addtocart' , compact(['qty_array' , 'productsDetails']))->render()
                                ];

                    } else {

                        return  [
                                'message'=>'Product already in cart' ,
                                'productId'=>$theProductId
                                ];
                    }                    

                } else {

                    // The Cookie cart Is Empty = 'Empty';
                    $theProductIds = [];

                    $theProductIds[] =  $theProductId;

                    $theProductIdInJson = json_encode($theProductIds); // "["1"]"
                    // Cookie::queue(\Cookie::forget('Cart')); // 100%
                    Cookie::queue('cart' , $theProductIdInJson , 60); // 100%

                    // Making  $qty_array array 
                    $qty_array = array_fill(0 , 1 , "1");
                    // Start Convert $qry_array To Json
                    $qty_array_json = json_encode($qty_array);
                    // Start Making qty_array Cookie    
                    Cookie::queue('qty_array' , $qty_array_json , 60);
                    // Start Get Products
                    $productsDetails = Product::where('id' , $theProductId)->with(['productdetails'=>function($que){
                        $que->select('product_id','image' , 'price');
                    } ] , 'category' , 'subcategory')->first();

                    return  [
                            'message'=>'Product added to cart no array' ,
                            'productId'=>$theProductId , 
                            'countOfCart'=>1 , 
                            'productsInMenu'=>view('user_or_guest.products-in-menu-addtocart' , compact(['productsDetails','qty_array']))->render()
                            ];

                }

            }


        }
    }
}
