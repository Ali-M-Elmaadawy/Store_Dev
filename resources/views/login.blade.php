@extends('layouts.app')
@section('content')


<section class="create-account my-5 py-5">
    <div class="container">
        <div class="row">
        <!--login-->
        <div class="col-md-6">
            <div class="login py-4">
                <div class="row">
                    <div class="col-md-6 m-auto">
                    <div class="create text-center">
                        <h4 class="bolded-font black mb-5">BEEN HERE BEFORE?</h4>
                        <form action="{{url('postlogin')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>EMAIL</label>
                                <input name="email" placeholder="Email" class="form-control" type="email"/> 
                            </div>
                            @if($errors->has('email')) 
                            
                                {{$errors->first('email')}}
    
                            @endif
                            <div class="form-group">
                                <label>PASSWORD</label>
                                <input name="password" class="form-control" type="password" placeholder="Password" /> 
                            </div>
                            @if($errors->has('password')) 
                                {{$errors->first('password')}}
                            @endif
                            <div class="form-group">
                                
                                <input type="checkbox" name="remember">
                                <label>Remember Me</label>
                            </div>
                            <a href="{{url('/password/reset')}}" class="brown link">
                            FORGOT YOUR PASSWORD?
                            </a>
                            <div class="form-group mt-2">
                                <button class="btn black-btn">LOGIN</button>
                            </div>
                        </form>
                        @if(session()->has('message'))
                        <p style="text-align:center" class="alert alert-dark">{{session()->get('message')}}</p>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="button-sides text-center py-4">
                <h4 class="bolded-font black mb-5">IT'S MY FIRST TIME HERE</h4>
                <div class="form-group">
                    <a href="{{url('create_account_get')}}"> 
                    <button class="btn black-btn">CREATE AN ACOUNT</button>
                    </a>
                </div>
                <span class="light-span text-center">
                If you'd like to save a wishlist, you'll<br> need to create an account.
                </span>
                <div class="form-group mt-3">
                    <a href="{{url('/homepage')}}">
                    <button class="btn black-btn">CONTINUE AS GUEST</button>
                    </a>
                </div>
                <span class="light-span text-center">
                You\'ll have the chance to create an<br> account after your first order.
                </span>
            </div>
        </div>
        </div>
    </div>
</section>

@endsection



