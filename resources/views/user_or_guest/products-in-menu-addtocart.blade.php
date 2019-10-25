@if(isset($productsDetails))
     {{--  Means Its Array  --}}
    @if(! isset($productsDetails->name))
        @php $totalPrice = []; @endphp

        @foreach($productsDetails as $key=>$product)
            <div class="item-cart-menu">
                    <div class="item-cart-descrep">
                        <form class="deleteproduct productId={{$product->id}}" data-product-key={{$key}}>
                                <input type="hidden" id="csrfToken" value="{{ csrf_token() }}">
                                <button type="submit"><i class="fas fa-times"></button></i>
                        </form>
                        <p class= "black bolded-font">{{$product->name}}</p>
                        <p class="small-price my-4">{{$totalPrice[]=$product->productdetails->price * $qty_array[$key]}}LE * {{$qty_array[$key]}}</p>
                    </div>
                    <div class="item-cart-img">
                        @if($product->subcategory_id != null)
                        <img class="img-fluid" src="{{asset('imgs/'.$product->category->name.'/subcategories/'.$product->subcategory->name.'/'.$product->name.'/'.$product->productdetails->image)}}"/>
                        @else
                        <img class="img-fluid" src="{{asset('imgs/'.$product->category->name.'/'.$product->name.'/'.$product->productdetails->image)}}"/>
                        @endif
                    </div>
            </div>  

        @endforeach
    @else
        <div class="item-cart-menu">
                <div class="item-cart-descrep">
                    <form class="deleteproduct productId={{$productsDetails->id}}" >
                            <input type="hidden" id="csrfToken" value="{{ csrf_token() }}">
                            <button type="submit"><i class="fas fa-times"></button></i>
                    </form>
                    <p class= "black bolded-font">{{$productsDetails->name}}</p>
                    <p class="small-price my-4">{{$productsDetails->productdetails->price * $qty_array[0]}}LE * {{$qty_array[0]}}</p>
                </div>
                <div class="item-cart-img">
                    @if( $productsDetails->subcategory_id != null )
                    <img class="img-fluid" src="{{asset('imgs/'.$productsDetails->category->name.'/subcategories/'.$productsDetails->subcategory->name.'/'.$productsDetails->name.'/'.$productsDetails->productdetails->image)}}"/>
                    @else
                    <img class="img-fluid" src="{{asset('imgs/'.$productsDetails->category->name.'/'.$productsDetails->name.'/'.$productsDetails->productdetails->image)}}"/>
                    @endif
                </div>
        </div>
    @endif  
    <div class="menu-tot-subtot my-3">
            <div class="tot-subtot-price">
            <p>Subtotal (excluding shipping)
            </p>
            <p class="bolded-font black">
                @if(isset($totalPrice)) 
                    {{--  If Theres Array Of Items  --}}
                    {{array_sum($totalPrice)}}LE
                @else
                    {{--  If One Item Exists In Cart  --}}
                    {{$productsDetails->productdetails->price}}LE * 1
                @endif
            </p>
            </div>
            <p class=text-center>
            INTERNATIONAL DELIVERIES MIGHT BE SUBJECT<br>
            TO CUSTOMS DUTIES
            </p>
            <div class="checkout-cart py-4">
                <a href="{{url('view_cart')}}" class="black">VIEW CART</a>
                {{--  <button class="btn black-btn mb-2"> CHECKOUT</button>  --}}
            </div>
    </div>

    
@endif



