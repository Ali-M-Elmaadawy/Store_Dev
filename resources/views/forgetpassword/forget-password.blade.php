@extends('layouts.app')
@php
    $noNavbar = '';
@endphp

<section class="create-account my-5 py-5">
    <div class="container">
        <div class="row">
        <!--reset password-->
        <div class="col-md-6">
            <div class="login py-4">
                <div class="row">
                    <div class="col-md-6 m-auto">
                    <div class="create text-center">
                        <h4 class="bolded-font black mb-5">RESET YOUR PASSWORD</h4>
                        <form action="{{url('password/reset/post')}}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>EMAIL</label>
                                <input name="email" class="form-control" type="email"/> 
                            </div>
                            <span class="light-span text-center">
                            We'll send you an email to reset your<br> password.                                             </span>
                            <div class="form-group mt-2">
                                <button class="btn black-btn">RESET</button>
                            </div>
                            <a href="login.html" class="brown link">
                            CANCEL
                            </a>
                        </form>
                        @if(session()->has('message'))
                            <p style="text-align:center" class="alert alert-dark">{{session()->get('message')}}</p>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!--buttons-->
        <div class="col-md-6">
            <div class="button-sides text-center py-4">
                <h4 class="bolded-font black mb-5">IT'S MY FIRST TIME HERE</h4>
                <div class="form-group">
                    <a href="create-account.html"> 
                    <button class="btn black-btn">CREATE AN ACOUNT</button>
                    </a>
                </div>
                <span class="light-span text-center">
                If you'd like to save a wishlist, you'll<br> need to create an account.
                </span>
                <div class="form-group mt-3">
                    <a href="index.html">
                    <button class="btn black-btn">CONTINUE AS GUEST</button>
                    </a>
                </div>
                <span class="light-span text-center">
                You'll have the chance to create an<br> account after your first order.
                </span>
            </div>
        </div>
        </div>
    </div>
</section>


