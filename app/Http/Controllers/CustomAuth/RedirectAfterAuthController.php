<?php

namespace App\Http\Controllers\CustomAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductDetails;
use App\Category;
use App\Product;
use Cookie;
class RedirectAfterAuthController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function homepage(Request $request) {

        if(\Auth::check()) { // if Authintacted
            if(\Auth::user()->type == '1') {

                $allCats = Category::with('subcategory')->get();

                return view('admin.homepage' , compact(['allCats']));
            } else {

                // If Cookie cart Not Exists
                if(! \Cookie::get('cart') ) {

                    Cookie::queue('cart' , 'Empty' , 75000); // 100%
                    $productsDetails = [];
                    // No qty_array Yet
                    $qty_array = [];
                } else {
                    // There,s Is Cookie Named cart
                    $cartArray = Cookie::get('cart');
                    // Change cartArrayDecode To Array         
                    $cartArrayDecode = json_decode($cartArray);
                    $qtyArray = Cookie::get('qty_array');
                    $qty_array = json_decode($qtyArray);
                    if(is_array($cartArrayDecode)) {

                        $productsDetails = Product::whereIn('id' , $cartArrayDecode)->with(['productdetails'=>function($que){
                            $que->select('product_id','image' , 'price');
                        } ] , 'category' , 'subcategory')->get();  
                    } else {
                        $productsDetails = [];
                    }
                }

                $getAllPro = Product::with('productdetails','productimages' , 'category' , 'subcategory')
                ->paginate(1);
                $getAllCategories = Category::with('subcategory')->get();

                if($request->ajax()) {
                    if(isset($request->cat)) {

                        $allData = $request->all();
                        $cat = $allData['cat'];
                        $subcat = $allData['subcat'];
                        if($subcat == 'null') { // To Solve String Value Of 'null'
                            $subcat = null;
                        }
                        $getAllPro = Product::where(['category_id' => $cat , 'subcategory_id' => $subcat])
                                            ->with('productdetails')
                                            ->paginate('1');                         
                    }

                    return [
                        'products' => view('user_or_guest.homepageajax' , compact('getAllPro'))->render(),
                        'total'    => $getAllPro->total()
                    ];
                }
                // not ajax
                return view('user_or_guest.homepage' , compact(['getAllPro' , 'getAllCategories','productsDetails','qty_array']));
                // $getAllPro = ProductDetails::with(['productid'=>function($que) {
                //     $que->with('category' , 'subcategory' , 'productimages');
                // }])->get();
                // return view('user_or_guest.homepage' , compact('getAllPro'));
            }
            
        } else { // Not Auth Or Guest

            // If Cookie cart Not Exists
            if(! \Cookie::get('cart') ) {

                Cookie::queue('cart' , 'Empty' , 75000); // 100%
                $productsDetails = [];
                // No qty_array Yet
                $qty_array = [];
            } else {
                // There,s Is Cookie Named cart
                $cartArray = Cookie::get('cart');
                // Change cartArrayDecode To Array         
                $cartArrayDecode = json_decode($cartArray);
                $qtyArray = Cookie::get('qty_array');
                $qty_array = json_decode($qtyArray);
                if(is_array($cartArrayDecode)) {

                    $productsDetails = Product::whereIn('id' , $cartArrayDecode)->with(['productdetails'=>function($que){
                        $que->select('product_id','image' , 'price');
                    } ] , 'category' , 'subcategory')->get();  
                } else {
                    $productsDetails = [];
                }
            }

            $getAllPro = Product::with('productdetails','productimages' , 'category' , 'subcategory')
            ->paginate(1);
            $getAllCategories = Category::with('subcategory')->get();

            if($request->ajax()) {
                if(isset($request->cat)) {

                    $allData = $request->all();
                    $cat = $allData['cat'];
                    $subcat = $allData['subcat'];
                    if($subcat == 'null') { // To Solve String Value Of 'null'
                        $subcat = null;
                    }
                    $getAllPro = Product::where(['category_id' => $cat , 'subcategory_id' => $subcat])
                                        ->with('productdetails')
                                        ->paginate('1');                         
                }

                return [
                    'products' => view('user_or_guest.homepageajax' , compact('getAllPro'))->render(),
                    'total'    => $getAllPro->total()
                ];
            }
            // not ajax
            return view('user_or_guest.homepage' , compact(['getAllPro' , 'getAllCategories','productsDetails','qty_array']));

        }


    } 
}
