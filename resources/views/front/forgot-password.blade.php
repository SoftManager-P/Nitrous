@extends('front/layouts/default')
@section('title')
    Forgot Password | Nitrous Competitions
@stop
   

@section("content")
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h1>Reset Password</h1>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 breadcrumb-content">
                <ul>
                <li>
                    <a href="{{url("/")}}">Home</a>
                </li>
                <li class="active">Reset Password</li>
            </ul>
            </div>
        </div>
    </div>
</div>
<div class="login-register-area pt-40 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 offset-md-2">
                <div class="login-register-wrapper">
                    <div class="login-form-container">
                        <div class="login-register-form">
                            <h4>Forgot Password</h4>
                            <p>Lost your password? Please enter your registered email address. You will receive a link to create a new password via email.</p>
                            <form action="#" method="post">
                                <input type="text" name="user-name" placeholder="Email">
                                <div class="button-box">
                                    <button type="button">Reset Password</button>
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