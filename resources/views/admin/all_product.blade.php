@extends('layouts.app')
@section('content')
@section('title' , 'All Products')
   <!-- nav bar -->
      @include('admin.admin_navbar')
   <!-- nav bar  -->
<section class="dash-categories my-5">
   <div class="container">
      <div class="row">
        <!--search-->
         <div class="col-md-8 m-auto my-4">
            <h3 class="black bolded-font mb-5 text-center">MY PRODUCTS</h3>
            <form class="search_product" action="{{url('search_product')}}" method="post">
                <div class="form-group search-products">
                    <input name="search" type="search" class="form-control" placeholder="Search for product"/>
                    <button type="submit" class="btn btn-black"><i class="fas fa-search black"></i></button>
                </div>
            </form>
            <div class="search_result">

            </div>
            <div class="ajax-load text-center" style="display:none">
                <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading</p>
            </div> 
            
         </div>
         <div class="col-lg-12">
            <div class="dash-admin-all-categories">
            
               <div class="row getallproductsajax">
                  @foreach($getAllPro as $product)
                     <div class="col-md-6">
                        <div class=" my-product  my-4">
                           <div class="my-product-customize">
                              <a href="" class="white"  data-toggle="modal" data-target="#prodEdit{{$product->id}}">Edit</a>
                              <!-- Modal -->
                              <div class="modal fade editproduct" id="prodEdit{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="prodEdit" aria-hidden="true">
                                 <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title" id="prodEdit">Edit ({{$product->name}})</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body">
                                          <form class="text-center edit-product-form" action="{{url('/edit_product/'.$product->id)}}" enctype="multipart/form-data">
                                             {{ csrf_field() }}
                                             <input type="hidden" name="product_id" value="{{$product->id}}">
                                             <div class="form-group">
                                                <p class="black text-left">Upload New Product Images</p>
                                                <input name="productimages[]" id="allImages" type="file" multiple/>
                                             </div> 
                                             <div class="dash-product-images" id="imagePreview">

                                                   <div class="dash-product-image mx-2">

                                                         <div class="good-image">
                                                            @if($product->subcategory_id != null)
                                                            <img class="img-fluid" src="{{asset('/imgs/'.$product->category->name.'/subcategories/'.$product->subcategory->name.'/'.$product->name.'/'.$product->productdetails->image)}}"/>
                                                            @else
                                                            <img class="img-fluid" src="{{asset('/imgs/'.$product->category->name.'/'.$product->name.'/'.$product->productdetails->image)}}"/>
                                                            @endif
                                                         </div>
                                                   </div>

                                             @if(count($product->productimages) > 0 )
                                                 {{-- Check If Image Object Is Exists In productimages  --}}
                                                 @if(isset($product->productimages[0]->image))
                                                     @foreach($product->productimages as $image)
                                                      <div class="dash-product-image mx-2">

                                                            <div class="good-image">
                                                            @if($product->subcategory_id != null)
                                                               <img class="img-fluid" src="{{asset('imgs/'.$product->category->name.'/subcategories/'.$product->subcategory->name.'/'.$product->name.'/'.$image->image)}}"/>
                                                            @else
                                                               <img class="img-fluid" src="{{asset('imgs/'.$product->category->name.'/'.$product->name.'/'.$image->image)}}"/>
                                                            @endif
                                                            </div>
                                                      </div>
                                                     @endforeach
                                                 @endif
                                             @endif
                                             </div>
                                             <div class="form-group">
                                                <input name="productname" type="text" class="form-control" placeholder="Product Name" value="{{$product->name}}" />
                                             </div>
                                             <div class="form-group">
                                                <input name="quantity" type="number" class="form-control" placeholder="Quantity" value="{{$product->productDetails->quantity}}" />
                                             </div>
                                             <div class="form-group">
                                                <input name="price" type="number" class="form-control" placeholder="Price" value="{{intval($product->productDetails->price)}}" />
                                             </div>
                                             <div class="form-group">
                                                <select name="category_id" class="form-control" id="categoryDropDown">
                                                   <option value="">Choose Category.....</option>
                                                   @foreach($allCategory as $category)
                                                      <option value={{$category->id}} @if($product->category_id == $category->id) selected @endif >{{$category->name}}</option>
                                                   @endforeach
                                                </select>
                                             </div>
                                             @php 
                                                $getSubcategory = App\SubCategory::where('category_id' ,$product->category_id)->get();

                                             @endphp
                                             <div class="form-group">
                                                <select name="subcategory_id" class="form-control" id="subCategoryDropDown{{$product->id}}">
                                                   <option value="">Sub Category ...</option>
                                                   @foreach($getSubcategory as $subcat)
                                                      <option value={{$subcat->id}} @if($product->subcategory_id == $subcat->id) selected @endif >{{$subcat->name}}</option>
                                                   @endforeach                                    
                                                </select>
                                             </div>
                                             <div class="form-group">
                                                <textarea name="description" class="form-control" rows="8" placeholder="Description">{{$product->productDetails->description}}
                                                </textarea>
                                             </div>
                                             <div class="form-group ">
                                                <button class="btn black-btn mb-2"> UPDATE</button>
                                             </div>
                                            <div class="ajax-load text-center" style="display:none">
                                                <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading</p>
                                            </div> 
                                            <div class="message">
                                               
                                            </div>                  
                                          </form>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <!-- Start Delete Product -->
                              <i class="fas fa-backspace white m-2"  data-toggle="modal" data-target="#categDel{{$product->id}}"></i>
                              <!-- Modal -->
                              <div class="modal fade" id="categDel{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="categDel" aria-hidden="true">
                                 <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title" id="categDel">Delete Product{{$product->id}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body">
                                          <p class="black"> Are you sure you want to delete this product ? </p>
                                       </div>
                                       <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          <button type="button" class="btn btn-primary">Delete</button>
                                       </div>
                                    </div>
                                 </div>
                              </div>




                           </div>

                           <!-- Product Details One Picture -->
                           <div class="product">
                              <div class="product-img"> 
                                 @if($product->subcategory_id != null)
                                    <img class="img-fluid" src="{{asset('/imgs/'.$product->category->name.'/subcategories/'.$product->subcategory->name.'/'.$product->name.'/'.$product->productdetails->image)}}"/>
                                 @else
                                    <img class="img-fluid" src="{{asset('/imgs/'.$product->category->name.'/'.$product->name.'/'.$product->productdetails->image)}}"/>
                                 @endif
                              </div>
                                 <div class="overlay-product ">
                                    <a href="#" data-toggle="modal" data-target=".product-view{{$product->id}}">
                                       <h6>QUICK VIEW</h6>
                                    </a>
                                    <a href="#">
                                       <h5>{{$product->name}}</h5>
                                    </a>
                                    <button class="btn black-btn mb-2"> <span>{{$product->productdetails->price}}LE</span></button>
                                    <h6>AVAILABLE : {{$product->productdetails->quantity}}</h6>
                                 </div>
                              </div>
                           
                           </div>


                        <!--product modal-->
                        <div class="products-main-modal">
                           <div class="modal fade product-view{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title">Product Name</h5>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <div class="product-imgs-details">
                                          <!-- <div class="autoplay"> -->
                                             {{-- Check If The Array productimages Not Empty --}}
                                             @if(count($product->productimages) > 0 )
                                                 {{-- Check If Image Object Is Exists In productimages  --}}
                                                 @if(isset($product->productimages[0]->image))
                                                     @foreach($product->productimages as $image)
                                                     <div>
                                                         <div class="product-popup">
                                                         @if($product->subcategory_id != null)
                                                         <img class="img-fluid" src="{{asset('imgs/'.$product->category->name.'/subcategories/'.$product->subcategory->name.'/'.$product->name.'/'.$image->image)}}"/> 
                                                         @else
                                                         <img class="img-fluid" src="{{asset('imgs/'.$product->category->name.'/'.$product->name.'/'.$image->image)}}"/>
                                                         @endif
                                                         </div>
                                                     </div>
                                                     @endforeach
                                                 @else 
                                                     <h5>Error In Prop Image</h5>
                                                 @endif
                                             @else
                                                 <h5>No Images Yet</h5>
                                             @endif
                                          <!-- </div> -->
                                       </div>
                                       <div class="product-info-details text-center my-3">
                                          <h3 class="black">{{$product->name}}</h3>
                                          <button class="btn black-btn mb-2"> <span>{{$product->productdetails->price}}LE</span></button>
                                          <p>
                                             {{$product->productdetails->description}} 
                                          </p>
                                          <a href="product-details.html"class="brown">GO TO THE PRODUCT</a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!--/product-modal--> 
                     </div>
                  @endforeach   
               </div> 


            </div>
         </div>
      </div>
   </div>
</section>
@endsection

@section('script')

<script>
   $(document).ready(function() {


            $(document).on('change' , "#allImages" , function() {
               $('.dash-product-images').html('');
                  var fileList = this.files;
                  var anyWindow = window.URL || window.webkitURL;
                    for(var i = 0; i < fileList.length; i++){
                      var objectUrl = anyWindow.createObjectURL(fileList[i]);
                      $('.dash-product-images').append('<div class="dash-product-image mx-2"><div class="good-image"><img class="img-fluid" src="' + objectUrl + '" /></div></div>');
                      window.URL.revokeObjectURL(fileList[i]);
                    }    
            });


            $(document).on('change' , "#categoryDropDown" , function() {

                  var product_id = $(this).parent().parent('form').attr("action").split('/').pop();
                  var category_id = $(this).val();
                  $.ajax({
                     url:"get_subcategories",
                     method:"get",
                     data:{'category_id':category_id},
                     beforeSend:function() {
                        $("#subCategoryDropDown"+product_id).attr('disabled', 'disabled');                     
                     },
                     success:function(data) {
                        $("#subCategoryDropDown"+product_id).removeAttr('disabled');
                        $("#subCategoryDropDown"+product_id).html(data);
                     }
                  });
            });

            $(document).on('submit' , ".edit-product-form" , function(e) {

               e.preventDefault();

                   $.ajax({

                     url:'edit_product',
                     method:'post',
                     contentType: false,
                     cache: false,
                     processData:false,
                     data: new FormData(this),

                     beforeSend:function() {
                        $('.ajax-load').show();
                     },
                     success:function(data) {
                        $('.getallproductsajax').html(data.all_product);

                        $('.ajax-load').hide();
                        $('.message').html(data.message);
                        $(".modal-backdrop").remove();
                        $('body').removeClass('modal-open');
                        $('.editproduct').removeClass('show');
                        // $(".modal").modal("hide");

                        // $('#allImages').val('');
                        // $('#imagePreview').empty();
                        // $('input[name="productName"]').val('');
                        // $('input[name="quantity"]').val('');
                        // $('input[name="price"]').val('');
                        // $("#categoryDropDown").val('');
                        // $("#subCategoryDropDown").html('<option value="">Sub Category ...</option>');
                        // $('textarea[name="description"]').val('');
                     }     
                   });

            });
            $(document).on('keyup' , ".search_product" , function(e) {

                e.preventDefault();
                var search = $(this).find('input[name="search"]').val();

                $.ajax({
                   url:"search_product",
                   method:"get",
                   data:{'search':search},
                   beforeSend:function() {
                      $('.ajax-load').show();                    
                   },
                   success:function(data) {
                      $('.ajax-load').hide();
                      $('.search_result').html(data);

                   }
                });

            });


   });
</script>

@endsection

