@extends('layouts.app')      
   @section('content')

   <!-- nav bar -->
      @include('admin.admin_navbar')
   <!-- nav bar  -->

      <section class="dash-categories my-5">
         <div class="container">
            <div class="row">
               <div class="col-lg-8 m-auto mb-4">
                  <div class="add-category">
                     <h3 class="black bolded-font my-5">Add Product</h3>

                     <form id="post_add_product" class="text-center" action="{{url('/post_add_product')}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                           <p class="black text-left">Upload Product Images (It's prefered be in range 450*300 px)</p>
                           <input id="allImages" name="productImage[]" type="file" multiple>
                           <div id="imagePreview">

                           </div>
                        </div>
                        <div class="form-group">
                           <input name="productName" type="text" class="form-control" placeholder="Product Name"/>
                        </div>
                        <div class="form-group">
                           <input name="quantity" type="number" class="form-control" placeholder="Quantity"/>
                        </div>
                        <div class="form-group">
                           <input name="price" type="number" class="form-control" placeholder="Price ..LE"/>
                        </div>
                        <div class="form-group">
                           <select name="category_id" class="form-control" id="categoryDropDown">
                              <option value="">Choose Category.....</option>
                              @foreach($allCategory as $category)
                                 <option value={{$category->id}}>{{$category->name}}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="form-group">
                           <select name="subcategory_id" class="form-control" id="subCategoryDropDown">
                              <option value="">Sub Category ...</option>
                           </select>
                        </div>
                        <div class="form-group">
                           <textarea name="description" class="form-control" rows="8" placeholder="Description"></textarea>
                        </div>
                        <div class="form-group ">
                           <button type="submit" class="btn black-btn mb-2"> ADD </button>
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
      </section>
   @endsection

   @section('script')
   <script>
      
      $(document).ready(function() {

         var inputLocalFont = document.getElementById("allImages");
         inputLocalFont.addEventListener("change",previewImages,false);

         function previewImages() {
             var fileList = this.files;
             $('#imagePreview').html('');
             var anyWindow = window.URL || window.webkitURL;

                 for(var i = 0; i < fileList.length; i++){
                   var objectUrl = anyWindow.createObjectURL(fileList[i]);
                   $('#imagePreview').append('<img src="' + objectUrl + '" />');
                   window.URL.revokeObjectURL(fileList[i]);
                 }       
         }

         $( "#categoryDropDown" ).change(function() {


               var category_id = $(this).val();
               $.ajax({

                  url:"/get_subcategories",
                  method:"get",
                  data:{'category_id':category_id},
                  beforeSend:function() {

                     $("#subCategoryDropDown").attr('disabled', 'disabled');
                  },
                  success:function(data) {

                     $("#subCategoryDropDown").removeAttr('disabled');
                     $("#subCategoryDropDown").html(data);
                     // console.log(data);
                  }

               });

               // alert($(this).val());

         });

         $('#post_add_product').submit(function(e) {

               e.preventDefault(); 
                   $.ajax({

                     url:'/post_add_product',
                     method:'post',
                     contentType: false,
                     cache: false,
                     processData:false,
                     data: new FormData(this),

                     beforeSend:function() {
                        $('.ajax-load').show();
                     },
                     success:function(data) {
                        $('.ajax-load').hide();
                        $('.message').html(data);
                        $('#allImages').val('');
                        $('#imagePreview').empty();
                        $('input[name="productName"]').val('');
                        $('input[name="quantity"]').val('');
                        $('input[name="price"]').val('');
                        $("#categoryDropDown").val('');
                        $("#subCategoryDropDown").html('<option value="">Sub Category ...</option>');
                        $('textarea[name="description"]').val('');
                     }     
                   });
         });


      });
   </script>

   @endsection
