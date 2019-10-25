@extends('layouts.app')

<div>
    <h3 style="text-align:center;margin-top:20px;"class="brown"><a href="{{url('/homepage')}}"class="brown">Back Home</a></h3>
</div>
@section('content')


<section class="main-cart-content mt-5 pt-5">
    <div class="container">
        <p class="black text-center bolded-font my-4">MY GOODS</p>
        <div class="message">

        </div>
        <div class="viewcart_products">
            @foreach($productsDetails as $key=>$product)
                <div class="item-cart-tot">
                    <div class="row">
                        <div class="col-lg-8">
                            <a href="product-details.html">
                                <div class="cart-item-view my-2">
                                    @if( $product->subcategory_id != null )
                                    <img class="img-fluid" src="{{asset('imgs/'.$product->category->name.'/subcategories/'.$product->subcategory->name.'/'.$product->name.'/'.$product->productdetails->image)}}"/>
                                    @else
                                    <img class="img-fluid" src="{{asset('imgs/'.$product->category->name.'/'.$product->name.'/'.$product->productdetails->image)}}"/>
                                    @endif
                                <h3 class="black bolded-font">	
                                    {{$product->name}}
                                </h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4">
                            <form class="delete_or_update" method="post">
                                <div class="cart-item-price-numb my-2">
                                    
                                        {{ csrf_field() }}
                                        <input type="hidden" name="productId" value="{{$product->id}}"> 
                                        <input type="hidden" name="key" value="{{$key}}"> 
                                        <input name="quantity" type="number" class="form-control" value="{{$qty_array[$key]}}"/>
                                        <button type="submit" name="update" class="btn update2-btn">Update</button>      
                                        <h3 class="black bolded-font">{{$totalPrice[]=$product->productdetails->price * $qty_array[$key]}}LE</h3>
                                        <button name="delete" type="submit" class="brown">REMOVE</button>
                                   
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


<section class="policy my-5">
    <div class="container">
        <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="text-center">
                <p class="text-center mb-3">
                    VAT is applied at checkout to orders shipping inside the EU.
                    International deliveries might be subject to customs duties.
                    If you have a store credit or discount code, enter it on the next page.
                </p>
                    <a href="{{url('/checkout')}}"  class="btn black-btn mb-2">CHECKOUT/ <span class="checkout">{{array_sum($totalPrice)}}</span>LE</a>
                    <a href="{{url('/checkout_online')}}"  class="btn black-btn mb-2">Online Payment/ <span class="checkout">{{array_sum($totalPrice)}}</span>LE</a>
            </div>
            @if(session()->has('message'))
                <p style="text-align:center" class="alert alert-dark">Please <a href="{{url('/')}}">Login </a>To Complete</p>
            @endif

        </div>
        </div>
    </div>
</section>

@endsection

@section('script')

<script>
$(document).ready(function() {


    $(document).on('click' , ':button' , function(e) {

        e.preventDefault();

        var token = $(this).parent().find('input[name="_token"]').val();
        var quantity = $(this).parent().find('input[name="quantity"]').val();
        var productId = $(this).parent().find('input[name="productId"]').val();
        var key = $(this).parent().find('input[name="key"]').val();
        var buttonSubmit = $(this).html();

        $.ajax({
            method:'post',
            url:'delete_or_update',
            data:{'buttonSubmit':buttonSubmit,'_token':token , 'quantity':quantity , 'productId':productId , 'key':key},
            success:function(data) {
                $('.message').html(data.message);
                $('.cart-numb').html(data.countOfCart);
                $('.allitems_in_div').html(data.productsInMenu);
                $('.viewcart_products').html(data.productsInCartPage);
                $('.checkout').html(data.totalPrice);
                
            }
        })

    });
});


</script>

@endsection
