<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['prevent-back-history'])->group(function () {


// Start Reset Password
// Route::get('/forget-password' , 'CustomAuth\@');

Route::get('/password/reset' , 'CustomAuth\ForgotPasswordController@showLinkRequestForm');
Route::post('/password/reset/post' , 'CustomAuth\ForgotPasswordController@sendResetLinkEmail');
Route::get('/password/reset/{token}' , 'CustomAuth\ResetPasswordController@showResetForm');
Route::post('/make/password/reset' , 'CustomAuth\ResetPasswordController@reset');


// End Reset password

// Start Login
Route::get('/' , 'CustomAuth\LoginController@getlogin')->name('login');
Route::post('/postlogin' , 'CustomAuth\LoginController@postlogin');
// End Login

Route::get('/homepage' , 'CustomAuth\RedirectAfterAuthController@homepage'); // For Admin And User

// Start Check Out
Route::get('/checkout' , 'Cart\CheckoutController@checkout'); // For Authintacated Users
Route::post('/post_checkout' , 'Cart\CheckoutController@postcheckout');
Route::get('/success_checkout' , 'Cart\CheckoutController@successcheckout');
// End Check Out

// Start Check Out With Paypal

Route::get('/checkout_online' , 'Cart\CheckoutController@checkoutonline'); // For Authintacated Users

Route::post('pay' , 'PaymentController@payWithPaypal')->name('pay');

Route::get('payment_success' , 'PaymentController@paymentsuccess')->name('approved');

Route::get('payment_cancelled' , 'PaymentController@paymentcancelled')->name('cancelled');


// End Check Out With Paypal

Route::get('/add_to_cart' , 'Cart\AddToCartController@addtocart'); 
Route::post('/delete_from_nav_cart' , 'Cart\DeleteFromCartController@deletefromnavcart'); 

Route::get('/view_cart' , 'Cart\ViewCartController@viewcart');
Route::post('/delete_or_update' , 'Cart\ViewCartController@deleteorupdate');

// Start Create Account
Route::get('/create_account_get' , 'CustomAuth\RegisterController@createaccountget');
Route::post('/create_account_post' , 'CustomAuth\RegisterController@createaccountpost');
// End Create Account

// Start Admin 

Route::post('/add_category' , 'Admin\CategoryController@addcategory');
Route::post('/delete_category' , 'Admin\CategoryController@delete_category');
Route::post('/add_subcat' , 'Admin\CategoryController@addsubcat');
Route::post('/delete_subcat' , 'Admin\CategoryController@deletesubcat');
Route::get('/show_orders' , 'Admin\OrderController@showorders');
Route::get('/show_confirmed_orders' , 'Admin\OrderController@showconfirmedorders');
Route::post('/confirm_reject_order' , 'Admin\OrderController@confirmrejectorder');
Route::get('/show_rejected_orders' , 'Admin\OrderController@showrejectedorders');
Route::get('/get_add_product' , 'Admin\ProductController@getaddproduct');

Route::post('/post_add_product' , 'Admin\ProductController@postaddproduct');

Route::get('/get_subcategories' , 'Admin\ProductController@getsubcategory');


Route::get('/all_product' , 'Admin\ProductController@allproduct');

Route::post('edit_product' , 'Admin\ProductController@editproduct');

// Start Search For Product

Route::get('search_product' , 'Admin\ProductController@searchproduct');


// End Search For Product

// End Admin

// Start Contact Us

Route::get('/get_contact_us' , 'ContactUs\ContactUsController@getcontactus');
Route::post('/post_contact_us' , 'ContactUs\ContactUsController@postcontactus');

// End Contact Us


}); // end prevent-back-history

Route::get('/logout' , function() {
    if(\Auth::check()) {
        Auth::logout();
        return redirect('/');
    } else {
        return redirect('/');
    }
});
