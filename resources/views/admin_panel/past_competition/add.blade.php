@extends('admin_panel.layouts.master')

{{-- Web site Title --}}
@section('title')
    Competition title and video
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
    <h4 class="page-title">Competition title and video </h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}"> Dashboard</a>
        </li>
        <li class  ="breadcrumb-item "><a href="#">PAST WINNER</a></li>
        <li class=" breadcrumb-item active">Competition title and video </li>
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
                        <h4 class="mt-0 header-title">Competition title and video </h4>
                        <form class="form-horizontal" id = "infoForm" action="{{url("admin/past/ajaxUpdateInfo")}}" method = "post">
                            <input type = "hidden" name = "_token" value = "{!! csrf_token() !!}"/>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Name</label>
                                <div class="col-md-9">
                                    <select class="form-control select2" name = "id">
                                        <option value = "">Select Competition</option>
                                        @foreach($competitionList as $item)
                                            <option value = "{{$item['id']}}">{{$item['name']}}</option>
                                        @endforeach    
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Photo</label>
                                <div class="col-md-3">
                                    <img id = "photoImg_img"  ratio = "1.6" class = "photoImg "  style = "width:100%;" />
                                    <input type = "hidden" class = "photoImgData" id = "photoImg_val" value = "" />
                                </div>
                                <div class="col-md-3">
                                    <button type="button" onclick = "onClickFilgDlg('#photoImg');" class="btn btn-primary waves-effect waves-light">File</button>
                                    &nbsp;&nbsp;
                                    <button type="button" onclick = "delImage()" class="btn btn-danger waves-effect waves-light">Delete</button>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Draw Video Url</label>
                                <div class="col-md-9">
                                    <input name="draw_video_url" type="text" placeholder="Draw Video Url" class="form-control" value = ""></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Delivery Video Ur1</label>
                                <div class="col-md-9">
                                    <input name="delivery_video_ur1" type="text" placeholder="Delivery Video Ur1" class="form-control" value = ""></div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Winner User Name</label>
                                <div class="col-md-9">
                                    <input name="winner_user_name" type="text" placeholder="Winner User Name" class="form-control" value = ""></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Ticket Number</label>
                                <div class="col-md-9">
                                    <input name="ticket_number" type="text" placeholder="Ticket Number" class="form-control" value = ""></div>
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
        @include("admin_panel/dlg/crop_dlg")
    </div>

@stop
{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
    <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script  src="{{ asset('assets/vendors/summernote/summernote.min.js') }}"  type="text/javascript"></script>
    <script>
        $(document).ready(function() {


        });
        function delImage(){
            $("#photoImg_val").val("");
            $("#photoImg_img").attr("src","");
        }
        $("#infoForm").validate({
            rules: {
                id:"required",
                
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
                if($("#photoImg_val").val() == ""){
                    errorMsg("Please select the photo!");
                    return;
                }
                datas.append("photo", $("#photoImg_val").val());
                loading_start();
                $.ajax({
                    url: url,
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

