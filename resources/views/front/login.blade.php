@extends('front/layouts/default')
@section('title')
    Login | Nitrous Competitions
@stop
    

@section("content")
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h1>Login</h1>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 breadcrumb-content">
                <ul>
                <li>
                    <a href="{{url("/")}}">Home</a>
                </li>
                <li class="active">Login Or Register</li>
            </ul>
            </div>
        </div>
    </div>
</div>
<div class="login-register-area pt-40 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="login-register-wrapper">
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <h4> login </h4>
                                    <form action="{{ route('login') }}" method="post">
                                        <input  type = "hidden" name = "_token" value = "{{ csrf_token() }}"/>
                                        <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                                        <input type="text" name="email" placeholder="Email" value="{!! old('email') !!}">
                                        <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                                        <input type="password" name="password" placeholder="Password" value="{!! old('password') !!}">
                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <input type="checkbox" name = "remember-me" value = "1" >
                                                <label>Remember me</label>
                                                <a href="{{url("/forgot-password")}}">Forgot Password?</a>
                                            </div>
                                            <button type="submit">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="login-register-wrapper">
                <div class="login-form-container">
                                <div class="login-register-form">
                                    <h4> register </h4>
                                    <form action="{{route('register')}}" method="post">
                                        <input  type = "hidden" name = "_token" value = "{{ csrf_token() }}"/>
                                        <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
                                        <input type="text" name="first_name" placeholder="First Name" value="{!! old('first_name') !!}">
                                        <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
                                        <input type="text" name="last_name" placeholder="Last Name" value="{!! old('last_name') !!}">
                                        <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                                        <input name="email" placeholder="Email" type="email" value="{!! old('email') !!}">
                                        <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                                        <input type="password" name="password" placeholder="Password" value="{!! old('password') !!}">
                                        <span class="help-block">{{ $errors->first('password_confirm', ':message') }}</span>
                                        <input type="password" name="password_confirm" placeholder="Password" value="{!! old('password_confirm') !!}">
                                        <div class="button-box">
                                            <button type="submit">Create An Account</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>
@stop 
@section("footer_scripts")
    <script>
    /*$(function(){
        $("#loginForm").validate({
            rules: {
                email: {required:true, email:true},
                password: "required",
            },
            messages: {
            },
            errorPlacement: function (error, element) {
                if($(element).closest('div').children().filter("div.error-div").length < 1)
                    $(element).closest('div').append("<div class='error-div'></div>");
                $(element).closest('div').children().filter("div.error-div").append(error);
            },
            submitHandler: function(form){
                return true;
            }
        });
    })*/
    </script>
@stop
        