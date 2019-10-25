<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('title') </title>
    <link href="{{ asset('images/logo.png') }}" rel="icon">
    <link rel="stylesheet" href="{{ asset('/css/font.css') }}"/>
    <link href='https://fonts.googleapis.com/css?family=Caesar Dressing' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('/css/all.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}"/>
</head>




<body>
        

        @if(isset($Navbar))
            @include('layouts.menu')
        @endif
        
        @yield('content')

        <!--footer-->
        <footer class="mt-5 py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="ext-menu-links mb-1">
                            <a href="#">The Founders. </a>
                            <a href="#">The Brand. </a>
                            <a href="#">The Material. </a>
                            <a href="#">The Prodution. </a>
                            <a href="#">FAQ. </a>
                            @if(! auth()->check())
                            <a href="{{url('/')}}">Login</a>
                            @endif
                        </div>
                    
                        <img class="img-fluid store-logo" src="imgs/logo.png"/>
                    
                        <p class="bolded-font black">HOLD ON TO THE GOOD</p>
                        <p class="mt-2 mb-5">
                            First published 2007. Redesigned often. © 2019 hardgraft. All rights reserved. No part of<br>
                            this website may be reproduced, stored in a retrieval system or transmitted, in any form <br>
                            or by any means, electronic, mechanical, photocopying, recording or otherwise, without the<br>
                            written permission of hardgraft. Designed by monie.ka & James
                        </p>
                    </div>
                </div>
            </div>
        </footer>
        <!--/footer-->

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    @if(!(\Auth::check() && \Auth::user()->type ==1))
        <script src="{{ asset('/js/index.js') }}"></script>
    @else  
        <script src="{{asset('/js/index-admin.js')}}"></script>
    @endif



    @yield('script')

</body>
</html>
