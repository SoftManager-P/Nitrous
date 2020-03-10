        <!-- jQuery  -->
        <script src="{{ URL::asset('assets/admin_panel/assets/js/jquery.min.js')}}"></script>
        <script src="{{ URL::asset('assets/admin_panel/assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ URL::asset('assets/admin_panel/assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{ URL::asset('assets/admin_panel/assets/js/waves.min.js')}}"></script>

        <script src="{{ URL::asset('assets/admin_panel/assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>

        @yield('script')

        <!-- App js -->
        <script src="{{ URL::asset('assets/admin_panel/assets/js/app.js')}}"></script>
        <script src="{{ URL::asset('assets/js/app.js')}}"></script>
        
        <script src="{{ asset('assets/jquery.validate.js') }}" type="text/javascript"></script>
        <script src="{{asset('assets/swal/js/waves.js')}}"></script>
        <script src="{{asset('assets/swal/js/sweetalert-dev.js')}}"></script>
        <script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" ></script>
        <script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/loading/loading.js') }}" type="text/javascript"></script>
        <script type="text/javascript" src="{{asset("assets/gritter/jquery.gritter.min.js")}}"></script>
        <script src="{{ asset('assets/crop/cropper.js') }}" ></script>
        <script src="{{asset('assets/back/common.js')}}"></script>
        
        @yield('script-bottom')
        @yield('footer_scripts')