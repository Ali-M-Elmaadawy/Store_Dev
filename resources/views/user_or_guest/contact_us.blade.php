@extends('layouts.app')

@section('title' , 'Contact Us')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 align="center">Contact Us</h1>
            <form action="{{url('/post_contact_us')}}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Name</label>
                    <input name="username" placeholder="Name" class="form-control" type="text" autocomplete="off"/> 
                </div>
                @if($errors->has('username')) 
                
                    <p class="alert alert-danger">{{$errors->first('username')}}</p>

                @endif
                <div class="form-group">
                    <label>Email</label>
                    <input name="email" placeholder="Email" class="form-control" type="email" autocomplete="off"/> 
                </div>
                @if($errors->has('email')) 
                
                    <p class="alert alert-danger">{{$errors->first('email')}}</p>

                @endif
                <div class="form-group">
                    <label>Message</label>
                    <textarea class="form-control" name="user_message" placeholder="Message Here"></textarea>
                </div>
                @if($errors->has('user_message')) 
                
                   <p class="alert alert-danger">{{$errors->first('user_message')}}</p>

                @endif


                <div class="form-group mt-2">
                    <button type="submit" class="btn black-btn">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@if(session()->has('message'))

    {{session()->get('message')}}
@endif