@extends('layouts.app')
@section('content')

@php
    $Navbar = '';
@endphp



<section class="intro my-5 pt-5 marg-top">
    <div class="container">
        <h1>
        It’s a matter of balancing <span>JUXTAPOSITIONS</span>. Creating
        an ideal <span>TENSION </span>between the hard and soft, rough and smooth,
        old and new. The beauty lies in the <span>CONTRADICTIONS</span>. Just as in life.
        </h1>
    </div>
</section>

<section class="products mb-5 thepaginateclass">
        <div class="container">
            <div class="row returned_ajax_products" id="{{$getAllPro->total()}}">
                    
            @foreach($getAllPro as $pro)
                
                @if(isset($pro->productdetails->image))   
                    <div class="col-lg-4 col-md-6">
                        <div class="product my-4">
                            <div class="product-img">
                            @if($pro->subcategory_id != null)          
                                <img class="img-fluid" src="{{asset('/imgs/'.$pro->category->name.'/subcategories/'.$pro->subcategory->name.'/'.$pro->name.'/'.$pro->productdetails->image)}}"/>
                            @else
                            <img class="img-fluid" src="{{asset('imgs/'.$pro->category->name.'/'.$pro->name.'/'.$pro->productdetails->image)}}"/>
                            @endif                                   
                            </div>
                            <div class="overlay-product ">
                                <a href="#" data-toggle="modal" data-target=".product-view{{$pro->id}}">
                                <h6>QUICK VIEW</h6>

                                </a>
                                <a href="#">
                                        {{$pro->name}}
                                <h5></h5>
                                </a>
                                <form action="{{url('add_to_cart?id='.$pro->id)}}" method="get" class="form_add_to_cart">
                                    <input type="hidden" name="productId" value="{{$pro->id}}">
                                    <button type="submit" class="btn black-btn mb-2"> <span>{{$pro->productdetails->price}}LE</span> /ADD TO CART</button>
                                </form>
                                <h6>AVAILABLE :{{$pro->productdetails->quantity}}</h6>
                            </div>
                        </div>
                        <div class="addtocart{{$pro->id}}" style="color:green">

                        </div> 
                    </div>
                    <!--product modal-->
                    <div class="products-main-modal">
                        <div class="modal fade product-view{{$pro->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title">Product Name{{$pro->id}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                    <div class="product-imgs-details">
                                        <div class="autoplay123">
                                            {{-- Check If The Array productimages Not Empty --}}
                                                @if(count($pro->productimages) > 0 )
                                                    {{-- Check If Image Object Is Exists In productimages  --}}
                                                    @if(isset($pro->productimages[0]->image))
                                                        @foreach($pro->productimages as $image)
                                                        <div>
                                                            <div class="product-popup">
                                                            @if($pro->subcategory_id !=null)
                                                            <img class="img-fluid" src="{{asset('imgs/'.$pro->category->name.'/subcategories/'.$pro->subcategory->name.'/'.$pro->name.'/'.$image->image)}}"/>
                                                            @else
                                                            <img class="img-fluid" src="{{asset('imgs/'.$pro->category->name.'/'.$pro->name.'/'.$image->image)}}"/>
                                                            @endif
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    @else 
                                                        <h5>Error In Prop Image</h5>
                                                    @endif
                                                @else
                                                    <h5>No Images In Main Home Yet</h5>
                                                @endif
      
                                        </div>
                                    </div>
                                    <div class="product-info-details text-center my-3">
                                        <h3 class="black">{{$pro->name}}</h3>
                                        <form action="{{url('add_to_cart?id='.$pro->id)}}" method="get" class="form_add_to_cart">
                                            <button class="btn black-btn mb-2"> <span>{{$pro->productdetails->price}}LE</span> /ADD TO CART</button>
                                        </form>
                                        <p>
                                            {{$pro->productdetails->description}}
                                        </p>
                                        <a href="product-details.html"class="brown">GO TO THE PRODUCT</a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!--/product-modal-->
                @else 
                    {{'The Product Does Not Have productdetails'}}
                @endif
            @endforeach
            </div>  
        </div> 
        <div class="ajax-load text-center" style="display:none">
            <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More Products</p>
        </div>
    </section>

    <!--spinner-->
    <div class="layout-spin">
        <div class="layout-clip">
            <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
            </div>
        </div>
    </div>
    <!--/spinner-->
@endsection

@section('script')
<script>
$(document).ready(function() {
    var totalPages,
        page,
        cat = 'nodata',
        subcat;

    //Start Scrolling To Get More Products
    page = 1;
    $(window).scroll(function() {
            totalPages = $('.returned_ajax_products').attr('id');
            var scroll_position_for_products_load = $(window).height() + $(window).scrollTop();
            if(scroll_position_for_products_load >= $(document).height()-400) {
                page++;
                if(page <= totalPages && cat == 'nodata') {
                    fetchHomeProducts(page);     
                } else if(page <= totalPages && cat != 'nodata') {
                    fetchProducts(page);
                }
            }
    });
    function fetchHomeProducts(page) {

        $.ajax({
            type:"get",
            url: 'homepage?page='+page,
            beforeSend:function() {
                $('.ajax-load').show();
            },
            success:function(data) {
                if(page > data.total){
                    $('.ajax-load').html("No more products found");
                    return;
                }
                $('.returned_ajax_products').append(data.products);
                $('.ajax-load').hide();
            }
        }); 
    } 

    function fetchProducts(page) {

                    $.ajax({
                        type:"get",
                        data:{'cat':cat,'subcat':subcat},
                        url: 'homepage?cat='+cat+'&subcat='+subcat+'&page='+page,
                        beforeSend:function() {
                            $('.ajax-load').show();
                        },
                        success:function(data) {
                            if(page > data.total){
                                $('.ajax-load').html("No more products found");
                                return;
                            }
                            $('.returned_ajax_products').append(data.products);
                            $('.ajax-load').hide();
                        }
                    }); 
    } 
    //End Scrolling To Get More Products

    // Start Add To Cart
    $(document).on('submit' , '.form_add_to_cart' , function(e){

        e.preventDefault();
        var productId = $(this).attr('action').split('id=').pop();

        $.ajax({
            type:'get',
            url:'add_to_cart',
            data:{'productId':productId},
            success:function(data){
                $('.addtocart'+data.productId).html(data.message);
                // Count Of Products 
                $('.cart-numb').html(data.countOfCart);
                $('.allitems_in_div').html(data.productsInMenu);                
            }
        });
    });

    // End Add To Cart


    // Start Choose Products From Menu
    $('.theformofcats').submit(function(e) {
        e.preventDefault();
        cat = $(this).find('input[name="cat"]').val();
        subcat = $(this).find('input[name="subcat"]').val();
        formAction = $(this).attr('action');
        $.ajax({
            'method':'get',
            'url':'homepage',
            'data':{'cat':cat , 'subcat':subcat},
            success:function(data) {
                $('.returned_ajax_products').empty();
                $('.returned_ajax_products').append(data.products);
                $('.returned_ajax_products').attr('id' , data.total);
                page = 1;
                
                {{--  alert($('.returned_ajax_products').attr('id'));  --}}
            }

        });
    });
    // End Choose Products From Menu

    // Start Delete Product From AddToCart Menu
    $(document).on('submit' , '.deleteproduct' , function(e){

        e.preventDefault();
        var productId = $(this).attr('class').split('Id=').pop();
        var productKey = $(this).attr('data-product-key');
        var token = $('input[id="csrfToken"]').val();

        $.ajax({
            method  :'post',
            url     :'delete_from_nav_cart',
            data    :{'_token': token, 'productId': productId , 'productKey':productKey},
            success:function(data) {
                // Count Of Products 
                $('.cart-numb').html(data.countOfCart);
                $('.allitems_in_div').html(data.productsInMenu);
                {{--  $('.allitems_in_div').html(data.productsInCartPage);  --}}
            }
        });
        
    });  
    // End Delete Product From AddToCart Menu


});


</script>
@endsection



