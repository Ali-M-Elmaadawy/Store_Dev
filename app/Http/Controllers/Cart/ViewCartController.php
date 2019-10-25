<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;
use Cookie;
class ViewCartController extends Controller
{
    public function viewcart() {
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
            // Get All Categories
            // $getAllCategories = Category::with('subcategory')->get();
            return view('user_or_guest.viewcart' , compact(['qty_array','productsDetails']));

        } else {

            return redirect('/homepage');
        }

    }

    public function deleteorupdate(Request $request) {

        $validator = \Validator::make($request->all() , [

            'quantity'  =>  'required|integer|min:0|not_in:0',
            'productId' =>  'required|integer|min:0|not_in:0',
            'key'       =>  'required|integer|min:0',
            'buttonSubmit' => 'in:Update,REMOVE'
        ]);

        if($validator->fails()) {

            return ['message' =>'error'];
        }

        $buttonSubmit   = $request->buttonSubmit;
        $theProductId   = $request->productId;
        $quantity       = $request->quantity;
        $qty_array_key  = $request->key;
        if($buttonSubmit == 'REMOVE') {

            if(Cookie::get('cart') && Cookie::get('qty_array') ) {

                $cartArray = Cookie::get('cart');

                // Change cartArrayDecode To Array         
                $cartArrayDecode = json_decode($cartArray);
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
                            'totalPrice'    => 0,
                            'countOfCart'   => 0,
                            'productsInMenu'=>view('user_or_guest.products-in-menu-addtocart' , compact(['qty_array' , 'productsDetails']))->render(),
                            'productsInCartPage'=>view('user_or_guest.viewcartajax' , compact(['qty_array','productsDetails']))->render()
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
                    // Total Price In Checkout Button
                    $totalPriceOfAll = [];
                    foreach($productsDetails as $key=>$product) {
                        $totalPriceOfAll[] = $product->productdetails->price * $qty_array[$key];
                    }
                    $finalTotalCheckout = array_sum($totalPriceOfAll);

                    $qtyArrayEncode = json_encode($qty_array);
                    // Start Making Anew Cookie Of qty_array
                    Cookie::queue('qty_array' , $qtyArrayEncode , 60); // 100% 
                    return  [
                            'totalPrice'    => $finalTotalCheckout,
                            'countOfCart'   =>$countCartArrayDecode,
                            'productsInMenu'=>view('user_or_guest.products-in-menu-addtocart' , compact(['qty_array' , 'productsDetails']))->render(),
                            'productsInCartPage'=>view('user_or_guest.viewcartajax' , compact(['qty_array','productsDetails']))->render()
                            ];
                } else {
                    return ['message'=>'This Key Does Not Exists In Your Cart'];
                }  
            }

        } else { // $request->update

            if(Cookie::get('cart') && Cookie::get('qty_array') ) {

                $cartArray = Cookie::get('cart');
                $theCartDecode = json_decode($cartArray);
                $countCartArrayDecode = count($theCartDecode);
                // Start Get Item Quantity
                $productQuantityQuery = Product::where('id' , $theProductId)->with(['productdetails'=>function($que){
                    $que->select('product_id','quantity');
                }])->first();
                $productQuantity = $productQuantityQuery->productdetails->quantity;
                // Start Get The New Products
                $productsDetails = Product::whereIn('id' , $theCartDecode)->with(['productdetails'=>function($que){
                    $que->select('product_id','image' , 'price');
                } ] , 'category' , 'subcategory')->get();

                $qtyArray = Cookie::get('qty_array');
                $qty_array = json_decode($qtyArray);

                
                //Check If $qty_array_key Exists In $qtyArray
                if(array_key_exists($qty_array_key, $qty_array)) {
                    if($productQuantity >= $quantity ) {
                        $qty_array[$qty_array_key] = $quantity;

                        $totalPriceOfAll = [];
                        foreach($productsDetails as $key=>$product) {
                            $totalPriceOfAll[] = $product->productdetails->price * $qty_array[$key];
                        }
                        $finalTotalCheckout = array_sum($totalPriceOfAll);

                        $qtyArrayEncode = json_encode($qty_array);
                        // Start Making Anew Cookie Of qty_array
                        Cookie::queue('qty_array' , $qtyArrayEncode , 60); // 100% 
                        return  [
                            'totalPrice'    => $finalTotalCheckout,
                            'message'       =>'Successfully Updated',
                            'countOfCart'   =>$countCartArrayDecode,
                            'productsInMenu'=>view('user_or_guest.products-in-menu-addtocart' , compact(['qty_array' , 'productsDetails']))->render(),
                            'productsInCartPage'=>view('user_or_guest.viewcartajax' , compact(['qty_array','productsDetails']))->render()
                            ];

                    } else {
                        // Means $request->quantity Is Bigger Than The Quantity Of Product In DataBase
                        return  [
                            'message'       =>'This Quantity Is Unavailable',
                            'countOfCart'   =>$countCartArrayDecode,
                            'productsInMenu'=>view('user_or_guest.products-in-menu-addtocart' , compact(['qty_array' , 'productsDetails']))->render(),
                            'productsInCartPage'=>view('user_or_guest.viewcartajax' , compact(['qty_array','productsDetails']))->render()
                            ];
                    }
                }
            }
            
        }

    }



}
