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

