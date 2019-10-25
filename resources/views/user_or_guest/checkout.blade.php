@extends('layouts.app')

@section('content')

<section class="confirm-order">
        <div class="container-fluid">
            <div class="row">
            <div class="col-lg-6">
                <div class="checkout-info ">
                    <a href="index.html"><img class="img-fluid store-logo" src="imgs/logo.png"/></a>
                    <p class="black bolded-font">Contact information</p>
                    <div class="contact-info my-3">
                        <img class="img-fluid" src="imgs/user.png"/>
                        <div>
                        <p>{{$username}} ({{$email}})</p>
                        <a href="{{url('/logout')}}" class="brown">Logout</a>
                        </div>
                    </div>
                    <p class="black bolded-font">Shipping address (English characters only)</p>
                    <div class="shipping-form my-5">
                        <form method="post" action="{{url('/post_checkout')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="productsArray" value="{{$productsArray}}">
                            <div class="row">
                                <div class="col-md-6 my-2">
                                    <input name="firstname" type="text" class="form-control" placeholder="first name"/>
                                </div>
                                <div class="col-md-6 my-2">
                                    <input name="lastname" type="text" class="form-control" placeholder="last name"/>
                                </div>                              
                                <div class="col-12 my-2">
                                    <input name="company" type="text" class="form-control" placeholder="company"/>
                                </div>
                                <div class="col-12 my-2">
                                    <input name="address" type="text" class="form-control" placeholder="address"/>
                                </div>
                                <div class="col-12 my-2">
                                    <input name="city" type="text" class="form-control" placeholder="city"/>
                                </div>
                                <div class="col-md-4 my-2">
                                    <select name="country" class="form-control" id="exampleFormControlSelect1">
                                        <option value="egypt">egypt</option>
                                    </select>
                                </div>
                                <div class="col-md-4 my-2">
                                    <select name="goornorate" class="form-control" id="exampleFormControlSelect1">
                                        <option value="Alexandria">Alexandria</option>
                                    </select>
                                </div>
                                <div class="col-12 my-2">
                                    <input name="phone" type="text" class="form-control" placeholder="phone"/>
                                </div>                             
                                <div class="col-12 my-2">
                                    <div class="confirm-button-order">
                                        <a href="{{ URL::previous() }}" class="brown">Back To Cart</a>
                                        <button type="submit" class="btn black-btn mb-2"> 
                                            Continue shipping method
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shipping-goods p-5">


                    <div class="goods-all py-3">

                        @foreach($productsDetails as $key=>$product)
                
                            <div class="goods-content my-3">
                                <div class="good-image">
                                    @if( $product->subcategory_id != null )
                                    <img class="img-fluid" src="{{asset('imgs/'.$product->category->name.'/subcategories/'.$product->subcategory->name.'/'.$product->name.'/'.$product->productdetails->image)}}"/>
                                    @else
                                    <img class="img-fluid" src="{{asset('imgs/'.$product->category->name.'/'.$product->name.'/'.$product->productdetails->image)}}"/>
                                    @endif
                                    <div class="item-numb">{{$qty_array[$key]}}</div>
                                </div>
                                <p>{{$product->name}}</p>
                                <p class="black bolded-font">{{$totalPrice[]=$product->productdetails->price * $qty_array[$key]}}</p>
                            </div>
                        @endforeach


                    </div>

                    <div class="goods-all py-3">
                        <div class="order-prices">
                        <p>Subtotal</p>
                        <p class="black bolded-font">{{array_sum($totalPrice)}}</p>
                        </div>
                        <div class="order-prices">
                        <p>Shipping</p>
                        <p class="black bolded-font">{{$totalPrice[] = 66}}LE</p>
                        </div>
                    </div>

                    <div class="goods-all py-3">
                        <div class="order-prices">
                        <p>Total</p>
                        <h5 class="black bolded-font">{{array_sum($totalPrice)}}</h5>
                        </div>
                    </div>

                </div>
            </div>
            </div>
        </div>
    </section>



                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


@endsection    