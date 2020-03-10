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

    @yield("content")

</div>
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

<script>
    
</script>
</body>

</html>    