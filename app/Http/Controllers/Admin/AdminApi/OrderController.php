<?php

namespace App\Http\Controllers\Admin\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TheOrder;
class OrderController extends Controller
{
    public function showorders() {



    	$getOrders = TheOrder::where('status','0')->get();
        return $getOrders;

    }

}
