@foreach($getAllPro as $pro) 
    @if(isset($pro->productdetails->image))   
        <div class="col-lg-4 col-md-6">
            <div class="product my-4">
                <div class="product-img">

                    @if($pro->subcategory_id != null) 
                    <img class="img-fluid" src="{{asset('imgs/'.$pro->category->name.'/subcategories/'.$pro->subcategory->name.'/'.$pro->name.'/'.$pro->productdetails->image)}}"/>
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
                        <button class="btn black-btn mb-2"> <span>{{$pro->productdetails->price}}LE</span> /ADD TO CART</button>
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
                                <h5>No Images in Ajax Yet</h5>
                            @endif
                            {{--  If productimages Not Found--}}
                        </div>
                    </div>
                    <div class="product-info-details text-center my-3">
                        <h3 class="black">{{$pro->name}}</h3>
                        <form action="{{url('add_to_cart?id='.$pro->id)}}" method="get" class="form_add_to_cart">
                            <button class="btn black-btn mb-2"> <span>{{$pro->productdetails->price}}LE</span> /ADD TO CART</button>
                        </form>

                        {{--  <button class="btn black-btn mb-2"> <span>{{$pro->productdetails->price}}LE</span> /ADD TO CART</button>  --}}
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
        {{'The Product Is Not Completed yet'}}
    @endif
@endforeach