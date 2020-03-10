@extends('front/layouts/default')
@section('title')
    Checkout | Nitrous Competitions
@stop        
@section("content")
    <div class="breadcrumb-area bg-img">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h1>Payment Process</h1>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 breadcrumb-content">
                    <ul>
                        <li>
                            <a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="active">Payment successful</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
        <div id="loadingDiv" class="mt-70 text-center"><img src="{{asset('assets/processing.gif')}}"/></div>
        <div style="display: none" class="mainMessage checkout-main-area mt-70 pt-40 pb-40">
            <div class="container text-center">
                <div><img width="150" src="{{asset('assets/icon-success.png')}}" /></div>
                <h1 class="mt-5" style="font-size: 68px">THANK YOU!</h1>
                <div class="mt-5 mb-30" style="font-size: 1.5em">Your order has been successful <br> and your ticket numbers have been reserved.</div>
                <div class="mt-5 mb-70" style="font-size: 1.5em">
                    <a href="{{url("/my-account")}}" target="_top" class="btn btn-lg btn-success">View Order details</a>
                </div>
            </div>
        </div>
@stop
@section("footer_scripts")
    <script>

        setTimeout(function () {
            $('.mainMessage').show();
            $('#loadingDiv').hide();
        },3000);

        parent.removeTimeout();

        $("a").click(function (event ) {
            event.preventDefault();
            top.location = $(this).attr('href');
        })
    </script>
@stop    