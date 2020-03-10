@extends('admin_panel.layouts.master')

{{-- Web site Title --}}
@section('title')
    Promo Code Info
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
    <h4 class="page-title">Promo Code Information</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}"> Dashboard</a>
        </li>
        <li class  ="breadcrumb-item "><a href="#">Promo Code</a></li>
        <li class=" breadcrumb-item active">Information</li>
    </ol>
@endsection
{{-- Montent --}}
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Promo Code Information</h4>
                        <form class="form-horizontal" id = "infoForm" action="{{url("admin/promoCode/ajaxSaveInfo")}}" method = "post">
                            <input type = "hidden" name = "_token" value = "{!! csrf_token() !!}"/>
                            <input type = "hidden" name = "id" value = "{{$id}}"/>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Promo Code</label>
                                <div class="col-md-9">
                                    <input name="promo_code" type="text" placeholder="Promo Code" class="form-control" value = "{{$info['promo_code']}}"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Amount Type</label>
                                <div class="col-md-9">
                                    <select name = "code_type" class ="form-control">
                                        <option value = "0" @if($info['code_type']*1==0 ) selected @endif>%</option>
                                        <option value = "1" @if($info['code_type']*1==1 ) selected @endif>Money</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Amount Worth</label>
                                <div class="col-md-9">
                                    <input name="amount_worth" type="text" placeholder="Amount Worth" class="form-control" value = "{{$info['amount_worth']}}"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Available Times</label>
                                <div class="col-md-9">
                                    <input name="available_times" type="text" placeholder="Available Times" class="form-control" value = "{{$info['available_times']}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Available Times Per Users</label>
                                <div class="col-md-9">
                                    <input name="times_per_user" type="text" placeholder="Available Times Per User" class="form-control" value = "{{$info['times_per_user']}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Expire Date</label>
                                <div class="col-md-9">
                                    <input name="expire_date" data-date-format="YYYY-MM-DD" placeholder="yyyy-mm-dd"  class="form-control date-picker" value = "{{$info['expire_date']}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Used Times</label>
                                <div class="col-md-9">
                                    <input name="used_times" type="text" placeholder="Used Times" class="form-control" value = "{{$info['used_times']}}">
                                </div>
                            </div>
                            <div class="form-position row " >
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("admin_panel/dlg/crop_dlg")
    @include("admin_panel/dlg/answer_type_setting")
    </section>
    
@stop
{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
    <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script  src="{{ asset('assets/vendors/summernote/summernote.min.js') }}"  type="text/javascript"></script>
    <script>
        
        $(document).ready(function() {
            $("#infoForm").validate({
                rules: {
                    promo_code: "required",
                    amount_worth: {required:true,digits:true},
                    available_times: {required:true,digits:true},
                    times_per_user: {required:true,digits:true},
                    expire_date: "required",
                },
                messages: {
                },
                errorPlacement: function (error, element) {
                    if($(element).closest('div').children().filter("div.error-div").length < 1)
                        $(element).closest('div').append("<div class='error-div'></div>");
                    $(element).closest('div').children().filter("div.error-div").append(error);
                },
                submitHandler: function(form){
                    
                    var amount_worth = $("input[name='amount_worth']").val();
                    if(parseInt(amount_worth)>20){
                        errorMsg("Amount Worth is no over 20!");
                        return;
                    }
                    var datas = new FormData();
                    datas.append('_token', _token);

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
        });
        
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>
@stop

