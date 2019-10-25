<section class="menu ">
    <div class="menu-content">
        <div class="container-fluid">
        <div class="menu-main">
            <i class="fas fa-chevron-down fa-lg"></i>
            <a href="{{url('/')}}"><img class="img-fluid store-logo" src="imgs/logo.png"/></a>
            <a style="cursor: pointer;" class="black black cart-numb">
                @php
                    if(\Cookie::get('cart')) {
                        $cart =  \Cookie::get('cart');
                        $cartDecode = json_decode($cart);
                        if(is_array($cartDecode)) {
                            echo count($cartDecode);
                        } else {
                            echo '0';
                        }
                    } else {
                        echo '0';
                    }
                    
                @endphp
            </a>
        </div>
        <div class="menu-back">
            <div class="menu-dropdown text-center">
               @foreach($getAllCategories as $allCats)
                @if(! count($allCats->subcategory) > 0) 
                    {{-- If Theres No SubCategories --}}

                    <form class="theformofcats" action="{{url('/homepage?cat='.$allCats->name)}}" method="get">
                        <div class="">
                            <input type="hidden" name="cat" value="{{$allCats->id}}">
                            <input type="hidden" name="subcat" value="null">
                            <input type="submit" class="black active-menu" value="{{$allCats->name}}">
                        </div>
                    </form>

                    @else
                    {{-- If Theres SubCategories --}}               
                    <a href="#">
                            <div class="category">
                                <p class="black sub-categ">{{$allCats->name}} <i class="fas fa-chevron-down fa-lg float-right"></i></p>
                                <div class="mt-3 sub-categ-cont">
                                @foreach($allCats->subcategory as $subCats) 
                                <form class="theformofcats" action="{{url('/homepage?cat='.$allCats->name.'&subcat='.$subCats->name)}}" method="get">
                                    <div class="">
                                        <input type="hidden" name="cat" value="{{$allCats->id}}">
                                        <input type="hidden" name="subcat" value="{{$subCats->id}}">
                                        <input type="submit" class="black active-menu" value="{{$subCats->name}}">
                                    </div>
                                </form>
                                @endforeach 
                                </div>
                            </div>
                        </a>  
                @endif
               @endforeach

                <div class="dotted-image my-5">
                    <img class="img-fluid" src="imgs/dotted.png"/>
                </div>
                <div class="ext-menu-links mb-5">
                    <a href="#">The Founders. </a>
                    <a href="#">The Brand. </a>
                    <a href="#">The Material. </a>
                    <a href="#">The Prodution. </a>
                    <a href="#">FAQ. </a>
                    <a href="login.html">Login</a>
                </div>
               <a href="{{url('/get_contact_us')}}"><b>Contact Us</b></a>
            </div>

            <div class="cart-menu">
                <p class="py-2 text-center black bolded-font">WORLDWIDE SHIPPING</p>
                <div class="allitems_in_div">
                    
                        @if(isset($productsDetails)) 
                            @php $totalPrice = [] @endphp
                            @foreach($productsDetails as $key=>$product) 
                                <div class="item-cart-menu">
                                    <div class="item-cart-descrep">
                                        <form class="deleteproduct productId={{$product->id}}" data-product-key={{$key}}>
                                            <input type="hidden" id="csrfToken" value="{{ csrf_token() }}">
                                            <button type="submit"><i class="fas fa-times deletebutton"></button></i>
                                        </form>
                                        <p class= "black bolded-font">{{$product->name}}</p>
                                        <p class="small-price my-4">{{$totalPrice[]=$product->productdetails->price * $qty_array[$key]}}LE * {{$qty_array[$key]}}</p>
                                    </div>
                                    <div class="item-cart-img">

                                        @if( $product->subcategory_id != null )
                                        <img class="img-fluid" src="{{asset('imgs/'.$product->category->name.'/subcategories/'.$product->subcategory->name.'/'.$product->name.'/'.$product->productdetails->image)}}"/>
                                        @else
                                        <img class="img-fluid" src="{{asset('imgs/'.$product->category->name.'/'.$product->name.'/'.$product->productdetails->image)}}"/>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        
                            <div class="menu-tot-subtot my-3">
                                <div class="tot-subtot-price">
                                    <p>Subtotal (excluding shipping)
                                    </p>
                                    <p class="bolded-font black">{{array_sum($totalPrice)}}LE</p>
                                </div>
                                <p class=text-center>
                                    INTERNATIONAL DELIVERIES MIGHT BE SUBJECT<br>
                                    TO CUSTOMS DUTIES
                                </p>
                                <div class="checkout-cart py-4">
                                    <a href="{{url('view_cart')}}" class="black">VIEW CART</a>
                                </div>
                            </div> 
                        @endif   
                </div>

            </div>
        </div>
        </div>
    </div>
</section>




