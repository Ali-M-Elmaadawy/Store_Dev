                  <h3 class="black bolded-font mb-5">CATEGORIES</h3>
                     @foreach($allCats as $cat)
                        <div class=" black-btn my-3">
                           <div class="categ-all-descrep">
                              <div class="categ-bar">
                                 <p  class="white sub-category-btn m-2 sub-categ-all-btn">Add Sub Category</p>
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