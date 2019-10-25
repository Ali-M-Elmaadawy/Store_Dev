     <section class="dash-nav">
      <nav class="navbar navbar-expand-lg navbar-light">
         <div class=container>
            <a class="navbar-brand" href="#"><img class="img-fluid" src="imgs/logo-sm.png" /></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
               <ul class="navbar-nav ml-auto">
                  <li class="nav-item ">
                     <a class="nav-link" href="{{url('/homepage')}}" <?php if(Request::segment(1) == 'homepage') {echo  'style="color: green"';} ?> >CATEGORIES<span class="sr-only">(current)</span></a>
                  </li>
                  <div class="dropdown show">
                     <a class="nav-link dropdown-toggle"   id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span  <?php if(Request::segment(1) == 'get_add_product' ||Request::segment(1) == 'all_products'  ) {echo  'style="color: green"';} ?> >PRODUCTS</span>
                     </a>
                     <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{url('/get_add_product')}}" <?php if(Request::segment(1) == 'get_add_product') {echo  'style="color: green"';} ?> >Add Product</a>
                        <a class="dropdown-item" href="{{url('/all_product')}}" <?php if(Request::segment(1) == 'all_product') {echo  'style="color: green"';} ?> >All products</a>
                     </div>
                  </div>
                  <li class="nav-item active active">
                     <div class="dropdown show">
                        <a class="nav-link dropdown-toggle"   id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <span <?php if(Request::segment(1) == 'show_orders' || Request::segment(1) == 'show_confirmed_orders' || Request::segment(1) == 'show_rejected_orders') {echo  'style="color: green"';} ?> >ORDERS</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                           <a class="dropdown-item" href="{{'/show_orders'}}" <?php if(Request::segment(1) == 'show_orders') {echo  'style="color: green"';} ?> >New Orders</a>
                           
                           <a class="dropdown-item" href="{{'/show_confirmed_orders'}}" <?php if(Request::segment(1) == 'show_confirmed_orders') {echo  'style="color: green"';} ?> >Confirmed Orders</a>

                           <a class="dropdown-item" href="{{'/show_rejected_orders'}}" <?php if(Request::segment(1) == 'show_rejected_orders') {echo  'style="color: green"';} ?> >Rejected Orders</a>

                        </div>
                     </div>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link " href="{{url('/logout')}}">LOGOUT</a>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
   </section>