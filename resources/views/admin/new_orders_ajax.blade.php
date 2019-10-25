            @if(count($getOrders) > 0)
               @foreach($getOrders as $order)
                  <div class="col-lg-8 m-auto">
                     <form class="confirm_reject_order" action="{{'/confirm_reject_order/'.$order->id}}" method="post">
                        {{ csrf_field() }}
                        <div class="dash-new-order my-3">
                           <div class="new-order-info">
                              <p class="black"><span class="bolded-font">Date: </span>{{$order->created_at->toDateString()}}</p>
                              <p class="black"><span class="bolded-font">Order Id: </span>{{$order->id}}</p>
                              <p class="black"><span class="bolded-font">Time:  </span> {{$order->created_at->toTimeString()}}</p>
                           </div>
                           <div class="shipping-goods p-5">

                              <div class="goods-all py-3">

                                 @php 
                                    $getproducts =  $order->products;
                                    $getQuantity = $order->quantity_products;
                                    $convertQuantityToArray = explode('-' , $getQuantity);
                                    $convertProductsToArray = explode('-' , $getproducts);
                                    $total = [];
                                 @endphp
                                 @foreach($convertProductsToArray as $key=>$oneproduct)
                                    @php
                                       $product_details = App\Product::where('id' , $oneproduct)->with(['productdetails'=>function($que) {

                                          $que->select('product_id','image' , 'price','description');

                                       } ,'category','subcategory'])->first();
                                    @endphp
                                    <div class="goods-content my-3">
                                       <div class="good-image">
                                          <img class="img-fluid" src="{{asset('imgs/'.$product_details->category->name.'/subcategories/'.$product_details->subcategory->name.'/'.$product_details->name.'/'.$product_details->productdetails->image)}}"/>
                                          <div class="item-numb">{{$convertQuantityToArray[$key]}}</div>
                                       </div>
                                       <p>{{$product_details->productdetails->description}}</p>
                                       <p class="black bolded-font">{{$total[] = $product_details->productdetails->price * $convertQuantityToArray[$key]}}</p>
                                    </div>
                                 @endforeach

                              </div>


                              <div class="goods-all py-3">
                                 <div class="order-prices">
                                    <p>Total</p>
                                    <h5 class="black bolded-font">{{array_sum($total)}}LE</h5>
                                 </div>
                              </div>

                              <div class="client-info my-4">
                                 <p class="black" ><span class="bolded-font">Client Name: </span> {{$order->firstname.' '.$order->lastname}}</p>
                                 <p class="black" ><span class="bolded-font">Client Address: </span> {{$order->address}} </p>
                                 <p class="black" ><span class="bolded-font">Mobile: </span> {{$order->phone}}</p>
                              </div>

                              <div class="form-group  text-center">
                                 <button name="confirm" type="submit" class="btn black-btn"> Confirm</button>
                                 <button name="reject" type="submit" class="btn black-btn"> Reject</button>

                                <div class="ajax-load{{$order->id}} text-center" style="display:none">
                                    <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading</p>
                                </div>

                              </div>
                           </div>

                        </div>
                     </form>
                  </div>
               @endforeach
            @else 
               <h3 class="text-center" style="width: 100%">{{'No Orders At This Moment'}}</h3>
            @endif
               