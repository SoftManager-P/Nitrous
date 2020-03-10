@extends('front/layouts/modal')
@section('title')
    Time up! | Nitrous Competitions
@stop        
@section("content")

        <div   class=" mt-70 checkout-main-area pt-40 pb-40">
            <div class="container text-center">
                    <div><img width="150" src="{{asset('assets/submission_failure.png')}}" /></div>
                    <h1 class="mt-5" style="font-size: 68px">TIME UP!</h1>
                    <div style="font-size: 1.5em">We were unable to process your payment</div>

                    <div class="mt-5 mb-70" style="font-size: 1.5em">
                        <a  href="{{url("/")}}" target="_top" class="btn btn-lg btn-warning">Back To Homepage</a>
                    </div>
            </div>
        </div>
@stop