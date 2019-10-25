@extends('layouts.app')
@section('content')


<!--create account-->
<section class="create-account my-5 py-5">
    <div class="container">
        <div class="row">
        <div class="col-md-4 col-sm-6 m-auto">
            <div class="create text-center">
                <h4 class="bolded-font black mb-5">CREATE AN ACCOUNT</h4>
                <form action="{{url('create_account_post')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                    <label>FIRST NAME</label>
                    
                    <input name="firstname" class="form-control" type="text" value="{{old('firstname')}}"/> 
                    </div>
                    @if($errors->has('firstname'))
                    <p style="text-align:center" class="alert alert-dark">{{$errors->first('firstname')}}</p>
                    @endif
                    <div class="form-group">
                    <label>LAST NAME</label>
                    <input name="lastname" class="form-control" type="text" value="{{old('lastname')}}"/> 
                    </div>
                    @if($errors->has('lastname')) 
                        {{$errors->first('lastname')}}
                    @endif
                    <div class="form-group">
                    <label>EMAIL</label>
                    <input name="email" class="form-control" type="email" value="{{old('email')}}"/> 
                    </div>
                    @if($errors->has('email')) 
                        {{$errors->first('email')}}
                    @endif
                    <div class="form-group">
                    <label>PASSWORD</label>
                    <input name="password" class="form-control" type="password"/> 
                    </div>
                    @if($errors->has('password')) 
                        {{$errors->first('password')}}
                    @endif
                    <div class="form-group">
                    <label>CONFIRM PASSWORD</label>
                    <input name="confirmpass" class="form-control" type="password"/> 
                    </div>
                    @if($errors->has('confirmpass')) 
                        {{$errors->first('confirmpass')}}
                    @endif
                    <div class="form-group">
                    <button type="submit" class="btn black-btn">CREATE</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
</section>
<!--/create account-->
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
                <a href="login.html">Login</a>
            </div>
            <a href="index.html">
            <img class="img-fluid store-logo" src="imgs/logo.png"/>
            </a>
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
@endsection
