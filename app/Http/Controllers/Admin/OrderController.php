<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TheOrder;
use App\Product;
class OrderController extends Controller
{
    public function showorders() {



        if(\Auth::check() && \Auth::user()->type = '1') {

            $getOrders = TheOrder::where('status','0')->get();
            // return $getOrders;
            return view('admin.new_orders' , compact('getOrders'));       
        } else {

            return redirect('/homepage');
            
        }



    }



    public function confirmrejectorder(Request $request) {



        if(! \Auth::user()->type = '1') {

            return redirect('/homepage');
            
        }


        $validator = \Validator::make($request->all() , [
            
            'order_id'     => 'required|exists:orders,id',
            'confirm_or_reject' => 'required|in:Confirm,Reject'
        ]);

        if($validator->fails()) {

             return 'error';
        }


        if($request->ajax()) {

            $order_id = $request->order_id;
            $confirm_or_reject = $request->confirm_or_reject;

            if($confirm_or_reject == 'Confirm') {

                $updateStatus = TheOrder::where('id' , $order_id)->update(['status'=>'1']);

                $getOrders = TheOrder::where('status','0')->get();

                return ['newordersajax'=>view('admin.new_orders_ajax' , compact('getOrders'))->render()];

            } else {
                // Reject
                $updateStatus = TheOrder::where('id' , $order_id)->update(['status'=>'2']);

                $getOrders = TheOrder::where('status','0')->get();

                return ['newordersajax'=>view('admin.new_orders_ajax' , compact('getOrders'))->render()];
            }


        }

    }


    public function showconfirmedorders() {


        if(! \Auth::user()->type = '1') {

            return redirect('/homepage');
            
        }

        $getConfirmedOrders = TheOrder::where('status','1')->get();
    	return view('admin.confirmed_orders' , compact('getConfirmedOrders'));
    }

    public function showrejectedorders() {



        if(! \Auth::user()->type = '1') {

            return redirect('/homepage');
            
        }

        $getRejectedOrders = TheOrder::where('status','2')->get();
        return view('admin.rejected_orders' , compact('getRejectedOrders'));
    }
    

}
