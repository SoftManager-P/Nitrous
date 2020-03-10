@extends('admin_panel.layouts.master')

{{-- Web site Title --}}
@section('title')
    Competition Info
    @parent
@stop

@section('header_styles')
    <link href="{{ asset('assets/vendors/summernote/summernote.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset("assets/tree/dtree.css")}}">
    <script src="{{asset("assets/tree/dtree.js")}}"></script>
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}"  rel="stylesheet" type="text/css" />
    
    <link href="{{ asset('assets/vendors/iCheck/css/all.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pages/editor.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/pages/buttons.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/pages/advbuttons.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('breadcrumb')
    <h4 class="page-title">Competition Doing Information</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}"> Dashboard</a>
        </li>
        <li class  ="breadcrumb-item "><a href="#">Competitions Manage</a></li>
        <li class=" breadcrumb-item active">Past Winner</li>
    </ol>
@stop

{{-- Montent --}}
@section('content')
    <!-- Main content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Competition Doing Information</h4>
                        <form class="form-horizontal" id = "infoForm" action="{{url("admin/competition/ajaxUpdateInfo")}}" method = "post">
                            <input type = "hidden" name = "_token" value = "{!! csrf_token() !!}"/>
                            <input type = "hidden" name = "id" value = "{{$id}}"/>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Competition Title</label>
                                <div class="col-md-9">
                                    <input name="name" type="text" placeholder="Competition Title" class="form-control" value = "{{$info['name']}}"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Video Url</label>
                                <div class="col-md-9">
                                    <input name="video_url" type="video_url" placeholder="Video Url" class="form-control" value = "{{$info['video_url']}}"></div>
                            </div>
                            <div class="form-position row" >
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include("dlg/crop_dlg")
    </div>

@stop
{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
    <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script  src="{{ asset('assets/vendors/summernote/summernote.min.js') }}"  type="text/javascript"></script>
    <script>
        $(document).ready(function() {

            $(".logImg").hover(function(){
                $(this).parent().next().removeClass("hidden");
            }, function(e){
                if(!$(e.relatedTarget).hasClass("delBtnWrapper")){
                    $(this).parent().next().addClass("hidden");
                }
            })

        });
        
        function onclickAutoExtend(obj){
            if($(obj).prop("checked")){
                $("input[name='hours_extend']").parent().parent().removeClass("hidden");
            }else{
                $("input[name='hours_extend']").parent().parent().addClass("hidden");
            }
        }

        $("#infoForm").validate({
            rules: {
                name: "required",
                video_url: "required",
            },
            messages: {
            },
            errorPlacement: function (error, element) {
                if($(element).closest('div').children().filter("div.error-div").length < 1)
                    $(element).closest('div').append("<div class='error-div'></div>");
                $(element).closest('div').children().filter("div.error-div").append(error);
            },
            submitHandler: function(form){
                var datas = new FormData();
                var url = $(form).attr("action");
                url += "?"+$(form).serialize();
                loading_start();
                $.ajax({
                    url: url,
                    data: datas,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    type: 'POST',
                    beforeSend: function (data, status) {
                    },
                    success: function (data) {
                        loading_stop();
                        if (data.status == 1) {
                            successMsg(data.msg, function(){
                                goBack();
                            });
                        } else {
                            errorMsg(data.msg);
                            return false
                        }
                    },
                    error: function (data, status, e) {
                        loading_stop();
                        errorMsg("errors happens");
                        return false;
                    }
                });
                return false;
            }
        });
       
    </script>
@stop

