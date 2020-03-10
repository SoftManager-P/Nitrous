@extends('front/layouts/modal')
@section('title')
    Checkout | Nitrous Competitions
@stop        
@section("content")
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h1>Checkout</h1>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 breadcrumb-content">
                        <ul>
                        <li>
                            <a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="active">Payment processing</li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="checkout-main-area pt-40 pb-40">
            <div class="container text-center">
                <div><img src="{{asset('assets/front/assets/images/main/paytriot.png')}}"/></div>
                <div><img src="{{asset('assets/processing.gif')}}"/></div>
                <div style="margin: auto; max-width: 250px;">
           {!!$process_form!!}
                </div>
            </div>
        </div>
@stop
@section("footer_scripts")
    <script>
         setTimeout(function () {
                $('#frmPaytriotPayment').submit();
         },700)
        
    </script>
@stop    