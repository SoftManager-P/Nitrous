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
                        <li class="active">Payment failure</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
        <div id="loadingDiv" class="mt-70 text-center"><img src="{{asset('assets/processing.gif')}}"/></div>
        <div  style="display: none" class="mainMessage mt-70 checkout-main-area pt-40 pb-40">
            <div class="container text-center">
                    <div><img width="150" src="{{asset('assets/submission_failure.png')}}" /></div>
                    <h1 class="mt-5" style="font-size: 68px">SORRY!</h1>
                    <div style="font-size: 1.5em">We were unable to process your payment</div>

                    <div class="mt-5 mb-30" style="color: red;font-size: 1.5em">
                        {{$error}}
                    </div>
                    <div class="mt-5 mb-70" style="font-size: 1.5em">
                        <a href="{{url("/")}}" target="_top" class="btn btn-lg btn-warning">Back To Homepage</a>
                    </div>
            </div>
        </div>
@stop
@section("footer_scripts")
    <script>
        function goHome(){
            top.location = '{{url("/")}}';
        }

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