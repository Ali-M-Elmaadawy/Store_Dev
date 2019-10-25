@extends('layouts.app') 

@section('content')  
  
<!-- Admin Page -->
   <!-- nav bar -->
      @include('admin.admin_navbar')
   <!-- nav bar  -->
      <!-------------------------------------------------------------->
      <section class="dash-categories my-5">
         <div class="container-fluid">
            <div class="row">
               <div class="col-lg-6 mb-5">
                  <div class="add-category">
                     <h3 class="black bolded-font">Add Category</h3>


                     <form id="addcategory" class="text-center" action="{{url('/add_category')}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                           <input name="categoryname" type="text" class="form-control" placeholder="Category Name"/>
                        </div>                    
                        <p  class="brown sub-category-btn  sub-categ-add-btn">Add Sub Category</p>
                        <div class="form-group sub-category-input">
                           <div class="field_wrapper">
                              <div>
                                  <input type="text" class="form-control" placeholder="Sub Category Name" name="subcat[]"/>
                                  <a href="javascript:void(0);" class="add_button" title="Add field"><img src="imgs/add-icon.png"/></a>
                              </div>
                           </div>
                        </div>
                        <div class="form-group ">
                           <button type="submit" class="btn black-btn mb-2"> ADD </button>
                        </div>
                     </form>
                     <div class="message" style="background-color: #6c757d ;">
                        
                     </div>
                    <div class="ajax-load text-center" style="display:none">
                        <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading</p>
                    </div>


                  </div>
               </div>


               <div class="col-lg-6 ">
                  <div class="added-categories text-center">
                     <h3 class="black bolded-font mb-5">CATEGORIES</h3>

                     @foreach($allCats as $cat)
                        <div class=" black-btn my-3">
                           <div class="categ-all-descrep">
                              <div class="categ-bar">
                              <!-- If There Is Products Added To This Category Which Created Without Subcategories Then You Cant Add Sub Category To This Category  -->
                              @php 
                                 $checkProductsBeforeAddSub = App\Product::where(['category_id'=> $cat->id , 'subcategory_id' => null])->first();
                              @endphp
                                <p  class="white sub-category-btn m-2 sub-categ-all-btn">@if($checkProductsBeforeAddSub == null) Add Sub Category @endif</p> 
                                 <i class="fas fa-backspace white m-2"  data-toggle="modal" data-target="#categDel{{$cat->id}}"></i>
                                 <!-- Modal -->
                                 <div class="modal fade" id="categDel{{$cat->id}}" tabindex="-1" role="dialog" aria-labelledby="categDel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h5 class="modal-title" id="categDel">Delete Category</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body">
                                             <p class="black"> Are You Sure To Delete This Category ({{$cat->name}})?</p>
                                          </div>
                                          <div class="modal-footer">
                                             <form class="delete_category" action="{{url('/delete_category/'.$cat->id)}}" method="post">
                                                {{ csrf_field() }}

                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Delete</button>
                                                <div class="ajax-load{{$cat->id}} text-center" style="display:none">
                                                <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading</p>
                                                </div>

                                             </form>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              @if($checkProductsBeforeAddSub == null)
                              <form class="addsubcat" action="{{url('/add_subcat/'.$cat->id)}}" method="post">
                                 {{ csrf_field() }}
                                 <div class="sub-categ-add">
                                    <div class="form-group ">
                                       <input id="subcatname{{$cat->id}}" name="subcatname" type="text" class="form-control" placeholder="Sub Category Name"/>
                                    </div>
                                    <div class="form-group ">
                                       <button type="submit" class="btn black-btn"> ADD </button>
                                    </div>
                                 </div>
                              </form>
                              @endif

                             <div class="ajax-load{{$cat->id}} text-center" style="display:none">
                                 <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading</p>
                             </div>
                           </div>
                           <h5 class="white py-4 main-dash-categ">{{$cat->name}} @if(count($cat->subcategory) > 0)  <i class="fas fa-chevron-down fa-lg float-right mr-5"></i> @endif </h5>



                        @if(count($cat->subcategory) > 0)  

                           @foreach($cat->subcategory as $subcat)   
                              <div class="sub-categ-main-box pb-3">
                                 <h6 class="white">{{$subcat->name}} <i class="fas fa-minus float-right mr-5" data-toggle="modal" data-target="#subCategDel{{$subcat->id}}"></i></h6>
                                 <!-- Modal -->
                                 <div class="modal fade" id="subCategDel{{$subcat->id}}" tabindex="-1" role="dialog" aria-labelledby="subCategDel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h5 class="modal-title" id="subCategDel">Delete Category</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body">
                                             <p class="black"> Are You Sure To Delete This Sub Category ({{$subcat->name}})?</p>
                                          </div>
                                          <div class="modal-footer">
                                             <form class="deletesubcat" action="{{'/delete_subcat/'.$subcat->id}}" method="post">
                                                {{ csrf_field() }}
                                                <input id="categoryname{{$subcat->id}}" type="hidden" name="categoryname" value="{{$cat->name}}">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Delete</button>
                                               <div class="ajax-load{{$subcat->id}} text-center" style="display:none">
                                                   <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading</p>
                                               </div>
                                             </form>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           @endforeach
                        @endif   
                        </div>  
                     @endforeach

                  </div>
               </div>
            </div>
         </div>
      </section>

@endsection

@section('script')

<script>
$(document).ready(function() {

      // Start Add Category
      $('#addcategory').submit(function(e) {
         e.preventDefault();
         var token         = $(this).find('input[name="_token"]').val();
         var categoryname  = $(this).find('input[name="categoryname"]').val();
         var multi_subcat  = '';
         if($('input[name^="subcat"]').val()) {

            var values = $("input[name='subcat[]']").map(function(){
                  multi_subcat += $(this).val()+'-';

               }).get();


            // var subcat        = $('input[name^="subcat"]').each(function() {
            //     multi_subcat += $(this).val()+'-';
            // });            
            multi_subcat =  multi_subcat.slice(0, -1);

         } else {
            multi_subcat = '0';
         }

         $.ajax({

            url:'/add_category',
            method:'post',
            data:{'_token': token, 'categoryname': categoryname , 'multi_subcat':multi_subcat},
            beforeSend:function() {
               $('.ajax-load').show();
            },
            success:function(data) {

               $('.ajax-load').hide();
               $('.added-categories').html(data.getcategoryajax);
               $('.message').html(data.message);        
            }
         });

      });
      // End Add Category

      $(document).on('submit' , '.delete_category' , function(e) {

         e.preventDefault();

         var category_id = $(this).attr('action').split('/').pop();
         var token       = $('form').find('input[name="_token"]').val();

         $.ajax({

            url:'/delete_category',
            method:'post',
            data:{'_token':token, 'category_id':category_id},
            beforeSend:function(){
               $('.ajax-load'+category_id).show();
            },
            success:function(data){
               $('.added-categories').html(data.getcategoryajax);
               $('.ajax-load'+category_id).hide();
               $(".modal").modal("hide");
               $(".modal-backdrop").css('display',"none");
               $('body').removeClass('modal-open');
            }
         });
      });

      $(document).on('submit' , '.addsubcat' , function(e) {

         e.preventDefault();

         var token = $('form').find('input[name="_token"]').val();
         var category_id = $(this).attr('action').split('/').pop();
         var subcatname = $('#subcatname'+category_id).val();


         $.ajax({

            url:'/add_subcat',
            method:'post',
            data:{'_token':token , 'category_id':category_id , 'subcatname':subcatname},
            beforeSend:function() {
               $('.ajax-load'+category_id).show();
            },
            success:function(data){
               $('.added-categories').html(data.getcategoryajax);
               $('.ajax-load'+category_id).hide();
            }


         });

      });

      $(document).on('submit' , '.deletesubcat' , function(e) {

         e.preventDefault();

         var token = $('form').find('input[name="_token"]').val();
         var subcat_id = $(this).attr('action').split('/').pop(); 
         var categoryname = $("#categoryname"+subcat_id).val();     

         $.ajax({

            url:'/delete_subcat',
            method:'post',
            data:{'_token':token , 'subcat_id':subcat_id , 'categoryname':categoryname},
            beforeSend:function() {
               $('.ajax-load'+subcat_id).show();
            },
            success:function(data){
               $('.added-categories').html(data.getcategoryajax);
               $('.ajax-load'+subcat_id).hide();
               $('body').removeClass('modal-open');
               $(".modal").modal("hide");
               $(".modal-backdrop").css('display',"none");
            }

         });


      });
});



</script>

@endsection
