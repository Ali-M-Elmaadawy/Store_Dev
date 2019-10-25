<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cookie;
use App\Product;
class DeleteFromCartController extends Controller
{
    public function deletefromnavcart(Request $request) { // Delete Product From Navbar cart

        if($request->ajax()) {

            $theProductId =  $request->productId;
            $qty_array_key =  $request->productKey;

            $cartArray = Cookie::get('cart');
        
            // If Cookie 'cart' Exists
            if($cartArray != null) { 
        
                // Change cartArrayDecode To Array         
                $cartArrayDecode = json_decode($cartArray);
                // If cartArrayDecode Is Array = the Cookie cart Is Not empty
                if(is_array($cartArrayDecode)) {
                    if($theNewCartArray = array_diff($cartArrayDecode , [$theProductId])) {
                        // Start Reset Keys Of Array To Start From Zero
                        $theNewCartArrayOffsetZero = array_values($theNewCartArray);
                        $cartArrayEncode = json_encode($theNewCartArrayOffsetZero);
                        $countCartArrayDecode = count($theNewCartArrayOffsetZero);
                        Cookie::queue('cart' , $cartArrayEncode , 60); // 100%
                        // Start Get The New Products
                        $productsDetails = Product::whereIn('id' , $theNewCartArrayOffsetZero)->with(['productdetails'=>function($que){
                            $que->select('product_id','image' , 'price');
                        } ] , 'category' , 'subcategory')->get();
                    } else if(count($cartArrayDecode) == 1) { // Last 1 Product In Cart

                        // Delete All Cookies Of Cart (cart , qty_array)
                        Cookie::queue('cart' , 'empty' , 60); // 100%
                        Cookie::queue(\Cookie::forget('qty_array')); // 100%
                        $productsDetails= [];
                        $qty_array = []; 
                        return  [
                                'countOfCart'   => 0,
                                'productsInMenu'=>view('user_or_guest.products-in-menu-addtocart' , compact(['qty_array' , 'productsDetails']))->render()
                                ];
                    } else {
                        return ['message'=>'This Product Does Not Exists In Your Cart'];
                    }
                    // Start Remove Product From qty_array
                    $qtyArray = Cookie::get('qty_array');
                    // Change qtyArray To Array         
                    $qty_array_decode = json_decode($qtyArray);   
                    //Check If $qty_array_key Exists In $qtyArray
                    if(array_key_exists($qty_array_key, $qty_array_decode)) {
                        // Start Remove The Value Of Product Key From The Array
                        unset($qty_array_decode[$qty_array_key]);

                        // Start Reset Keys Of Array To Start From Zero
                        $qty_array = array_values($qty_array_decode);

                        $qtyArrayEncode = json_encode($qty_array);
                        // Start Making Anew Cookie Of qty_array
                        Cookie::queue('qty_array' , $qtyArrayEncode , 60); // 100% 
                        return  [
                                'countOfCart'   =>$countCartArrayDecode,
                                'productsInMenu'=>view('user_or_guest.products-in-menu-addtocart' , compact(['qty_array' , 'productsDetails']))->render()
                                ];


                        
                    } else {
                        return ['message'=>'This Key Does Not Exists In Your Cart'];
                    }                    


                }
            }
        }
    }
}
