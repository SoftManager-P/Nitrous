<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
    @section('title')
        Nitrous Competitions -
    @show
    </title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{url("assets/front/assets/images/main/favicon.png")}}">

    <!-- CSS
	============================================ -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{url("assets/front/assets/css/vendor/bootstrap.min.css")}}">
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{{url("assets/front/assets/css/vendor/line-awesome.min.css")}}">
    
    <link rel="stylesheet" href="{{url("assets/front/assets/css/vendor/themify.css")}}">
    <!-- othres CSS -->
    <link rel="stylesheet" href="{{url("assets/front/assets/css/plugins/animate.css")}}">
    <link rel="stylesheet" href="{{url("assets/front/assets/css/plugins/owl-carousel.css")}}">
    <link rel="stylesheet" href="{{url("assets/front/assets/css/plugins/magnific-popup.css")}}">
    <link rel="stylesheet" href="{{url("assets/front/assets/css/plugins/jquery-ui.css")}}">
    <link rel="stylesheet" href="{{url("assets/front/assets/css/style.css")}}">

    <link href="{{asset("assets/swal/css/waves.css")}}" rel="stylesheet" />
    <link href="{{asset("assets/swal/css/animate.css")}}" rel="stylesheet" />
    <link href="{{asset("assets/swal/css/sweetalert.css")}}" rel="stylesheet" />
    <link href="{{asset("assets/swal/css/all-themes.css")}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset("assets/gritter/jquery.gritter.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("assets/gritter/gritter.css")}}">
    <link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/loading/loading.css') }}" rel="stylesheet">
    
    <script src="{{url("assets/front/assets/js/vendor/jquery-3.3.1.min.js")}}"></script>
    <script src="{{asset('assets/swal/js/waves.js')}}"></script>
    <script src="{{asset('assets/swal/js/sweetalert-dev.js')}}"></script>
    <script src="{{ asset('assets/loading/loading.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset("assets/gritter/jquery.gritter.min.js")}}"></script>

    
    <script src="{{ url('assets/front/assets/simplePagination/jquery.simplePagination.js')}}"></script>
    @yield('header_styles')
</head>
<script>
    var public_path = "{{asset("/")}}";
    var _token =  "{{ csrf_token() }}";
</script>
<body>
<div class="main-wrapper">
    <header class="header-area sticky-bar bg-black-2">
        @include("front.layouts.menus")
    </header>
    @include("front.layouts.mobile_canvas")
    <div id="notific">
        @include('notifications')
    </div>
    @yield("content")
    <footer class="footer-area">
        <div class="footer-top bg-black-2 pt-120 pb-85">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-12 col-sm-6">
                        <div class="footer-widget mb-30">
                            <div class="footer-title">
                                <h3>Nitrous Competitions</h3>
                            </div>
                            <p>Nitrous Competitions is a new, innovative competitions service built with you in mind. Our aim is to provide our contenders the chance to win amazing prizes.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12 col-sm-6">
                        <div class="footer-widget mb-30">
                            <div class="footer-title">
                                <h3>Payments Via</h3>
                            </div>
                            <img src="{{url("assets/front/assets/images/main/paytriot.png")}}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-2 col-12 col-sm-6">
                        <div class="footer-widget mb-30">
                            <div class="footer-title">
                                <h3>Useful Links</h3>
                            </div>
                            <div class="footer-list">
                                <ul>
                                    <li><a href="{{url("cart")}}">Live Competitions</a></li>
                                    <li><a href="contact.html">Frequently Asked Questions</a></li>
                                    <li><a href="wishlist.html">My Account</a></li>
                                    <li><a href="checkout.html">Create An Account</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                        <div class="footer-widget mb-30">
                            <div class="footer-title">
                                <h3>You Can Find Us On</h3>
                            </div>
                            <div class="footer-social">
                                <ul>
                                    <li><a href="#"><i class=" ti-facebook "></i> <span>FACEBOOK</span></a></li>
                                    <li><a href="#"><i class=" ti-instagram "></i> <span>INSTAGRAM</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom bg-gray-2 ptb-20">
            <div class="container">
                <div class="copyright text-center">
                    <p>Copyright ©2020 Nitrous Competitions Ltd All Right Reserved | Created By <a href="https://www.wearestartpoint.co.uk" rel="nofollow">StartPoint</a>.</p>
                </div>
            </div>
        </div>
    </footer>
</div>
@include("front/dlg/login_alert")
<!-- JS
============================================ -->

<!-- Modernizer JS -->
<script src="{{url("assets/front/assets/js/vendor/modernizr-3.6.0.min.js")}}"></script>
<!-- Modernizer JS -->

<!-- Popper JS -->
<script src="{{url("assets/front/assets/js/vendor/popper.js")}}"></script>
<!-- Bootstrap JS -->
<script src="{{url("assets/front/assets/js/vendor/bootstrap.min.js")}}"></script>

<!-- Plugin JS -->
<script src="{{url("assets/front/assets/js/plugins/jquery.countdown.js")}}"></script>
<script src="{{url("assets/front/assets/js/plugins/images-loaded.js")}}"></script>
<script src="{{url("assets/front/assets/js/plugins/isotope.js")}}"></script>
<script src="{{url("assets/front/assets/js/plugins/jquery-ui.js")}}"></script>
<script src="{{url("assets/front/assets/js/plugins/jquery-ui-touch-punch.js")}}"></script>
<script src="{{url("assets/front/assets/js/plugins/magnific-popup.js")}}"></script>
<script src="{{url("assets/front/assets/js/plugins/owl-carousel.js")}}"></script>
<script src="{{url("assets/front/assets/js/plugins/scrollup.js")}}"></script>
<script src="{{url("assets/front/assets/js/plugins/waypoints.js")}}"></script>
<script src="{{url("assets/front/assets/js/plugins/wow.js")}}"></script>
<script src="{{url("assets/front/assets/js/plugins/elevatezoom.js")}}"></script>
<script src="{{url("assets/front/assets/js/plugins/smoothscroll.js")}}"></script>
<!-- Main JS -->
<script src="{{url("assets/front/assets/js/main.js")}}"></script>
<script src="{{ asset('assets/jquery.validate.js') }}" type="text/javascript"></script>
<script src="{{asset('assets/swal/js/waves.js')}}"></script>
<script src="{{asset('assets/swal/js/sweetalert-dev.js')}}"></script>
<script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" ></script>
<script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/loading/loading.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset("assets/gritter/jquery.gritter.min.js")}}"></script>
<script src="{{asset('assets/back/common.js')}}"></script>
@yield('footer_scripts')
{{--<div class="modal fade modal-fullscreen " id="paytriotModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
    {{--<div class="modal-dialog">--}}
        {{--<div class="modal-content">--}}
            {{--<div class="modal-body">--}}
                {{--<iframe id="paymentIframe" src="" style="position:fixed; background: #fff; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;">--}}
                    {{--Your browser doesn't support iframes--}}
                {{--</iframe>--}}
            {{--</div>--}}
            {{--<div class="cartExpire" style="position: fixed; width: 350px; height: 50px; right: 0; bottom: 0; z-index: 99999999">--}}
                {{--<div class="cart-countdown">--}}
                    {{--Your Cart Will Expire In: <span class="cart-timer">--}}
                                    {{--<br>--}}
                                    {{--<span class="days"></span>--}}
                                    {{--<span class="hours"></span>--}}
                                    {{--<span class="minutes"></span>--}}
                                    {{--<span class="seconds"></span>--}}
                                {{--</span>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<!-- /.modal-content -->--}}
    {{--</div>--}}
    {{--<!-- /.modal-dialog -->--}}
{{--</div>--}}
<script>
    {{--var order_number = '';--}}
    {{--var cnt = 0;--}}
    {{--var diff = "{{$diff}}";--}}
    {{--function makeTimer1() {--}}
        {{--if(diff == "") return;--}}
        {{--var diffTime = parseInt(diff);--}}
        {{--var timeLeft = diffTime - cnt;--}}

        {{--if(timeLeft <0){--}}
            {{--paymentTimeout();--}}
            {{--clearInterval(payInterval);--}}
            {{--return;--}}
        {{--}--}}

        {{--var days = 0;--}}
        {{--var hours = "00";--}}
        {{--var minutes = Math.floor(timeLeft / 60);--}}
        {{--var seconds = Math.floor((timeLeft - (minutes * 60)));--}}



        {{--/*if (hours < "10") { hours = "0" + hours; }*/--}}
        {{--if (minutes < "10") { minutes = "0" + minutes; }--}}
        {{--if (seconds < "10") { seconds = "0" + seconds; }--}}

{{--//            $(".days").html(days + "<span>D </span>");--}}
{{--//            $(".hours").html(hours + "<span>H </span>");--}}
        {{--$(".minutes").html(minutes + "<span>M</span>");--}}
        {{--$(".seconds").html(seconds + "<span>S </span>");--}}
        {{--cnt++;--}}
    {{--}--}}

    {{--function paymentTimeout(){--}}
        {{--order_number = '0';--}}
        {{--//return;--}}
        {{--$('#paymentIframe').attr("src","{{url("order/timeout")}}/"+order_number);--}}
        {{--$('.cart-countdown').html('Your Cart is expried.');--}}
        {{--$('#paytriotModal').modal('show');--}}
    {{--}--}}

    {{--function removeTimeout() {--}}
        {{--clearInterval(payInterval);--}}
        {{--$('.cart-countdown').remove();--}}
    {{--}--}}

    {{--var payInterval = setInterval(function() { makeTimer1(); }, 1000);--}}
</script>
</body>

</html>    