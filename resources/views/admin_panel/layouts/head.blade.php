		<meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ URL::asset('assets/admin_panel/assets/images/favicon.ico')}}">
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->       
        @yield('css')
        @yield('header_styles')
        <link href="{{ URL::asset('assets/admin_panel/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ URL::asset('assets/admin_panel/assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ URL::asset('assets/admin_panel/assets/css/style.css')}}" rel="stylesheet" type="text/css">

        
        <link href="{{asset("assets/swal/css/waves.css")}}" rel="stylesheet" />
        <link href="{{asset("assets/swal/css/animate.css")}}" rel="stylesheet" />
        <link href="{{asset("assets/swal/css/sweetalert.css")}}" rel="stylesheet" />
        <link href="{{asset("assets/swal/css/all-themes.css")}}" rel="stylesheet" />

        
        <link rel="stylesheet" type="text/css" href="{{asset("assets/gritter/jquery.gritter.css")}}">
        <link rel="stylesheet" type="text/css" href="{{asset("assets/gritter/gritter.css")}}">
        <link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/loading/loading.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/back/common.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/admin_panel/css/admin_common.css') }}" rel="stylesheet" type="text/css"/>

        