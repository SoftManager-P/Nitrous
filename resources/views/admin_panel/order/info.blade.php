@extends('admin_panel.layouts.master')

{{-- Web site Title --}}
@section('title')
    Order Info
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
    <h4 class="page-title">Order Information</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}"> Dashboard</a>
        </li>
        <li class  ="breadcrumb-item "><a href="#"> Orders</a></li>
        <li class=" breadcrumb-item active">Information</li>
    </ol>
@stop

{{-- Montent --}}
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Order Information</h4>
                        <form class="form-horizontal" id = "infoForm" action="{{url("admin/order/ajaxSaveInfo")}}" method = "post">
                            <input type = "hidden" name = "_token" value = "{!! csrf_token() !!}"/>
                            <input type = "hidden" name = "id" value = "{{$id}}"/>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Order Number</label>
                                <div class="col-md-9 control-label" style = "text-align: left;">
                                    {{$info['order_number']}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Total Price</label>
                                <div class="col-md-9 control-label" style = "text-align: left;">
                                    {{$info['total_price']}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">User Name</label>
                                <div class="col-md-9 control-label" style = "text-align: left;">
                                    {{$info['user_name']}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Address</label>
                                <div class="col-md-9 control-label" style = "text-align: left;">
                                   {{$info['address']}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Phone</label>
                                <div class="col-md-9 control-label" style = "text-align: left;">
                                    {{$info['phone']}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Order Time</label>
                                <div class="col-md-9 control-label" style = "text-align: left;">
                                    {{$info['order_time']}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Status</label>
                                <div class="col-md-9">
                                    <select name = "status" class = "form-control" style = "width :200px;">
                                        <option value = "0" @if($info['status']*1 == 0) selected @endif>Created</option>
                                        <option value = "1" @if($info['status']*1 == 1) selected @endif>Payed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-position row" >
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>    
                    <div class = "card-body" style = "margin-bottom:20px;">
                        <div class = "col-md-8 col-md-offset-2" >
                            <h3>Order Detail</h3>
                            <div class="table-scrollable">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Competition Name</th>
                                        <th>Ticket Number</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($detailList as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item['competition']['name']}}</td>
                                        <td>{{$item['ticket']['ticket_no']}}</td>
                                        <td>{{$item['price']}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
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

            

        });
        
        
        $("#infoForm").validate({
            rules: {
                status: "required",
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

        function delImage(obj){
            $("#main_image_img").attr("src", "");
            $("#main_image_val").val("");
            $(obj).addClass("hidden");

        }
    </script>
@stop

