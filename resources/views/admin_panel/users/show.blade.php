@extends('admin_panel.layouts.master')

{{-- Page title --}}
@section('title')
    View User Details
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/vendors/x-editable/css/bootstrap-editable.css') }}" rel="stylesheet"/>

    <link href="{{ asset('assets/css/pages/user_profile.css') }}" rel="stylesheet"/>
@stop
@section('breadcrumb')
    <h4 class="page-title">User Profile</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}"> Dashboard</a>
        </li>
        <li class  ="breadcrumb-item "><a href="#"> Users</a></li>
        <li class=" breadcrumb-item active">User Profile</li>
    </ol>
@endsection

{{-- Page content --}}
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <ul class="nav  nav-tabs ">
                            <li class="nav-item active">
                                <a href="#tab1" class = "nav-link active" data-toggle="tab">
                                    User Profile</a>
                            </li>
                            <li class = "nav-item">
                                <a href="#tab2" class = "nav-link " data-toggle="tab">
                                    Change Password</a>
                            </li>
        
                        </ul>
                        <div  class="tab-content mar-top">
                        <div id="tab1" class="tab-pane fade active show in">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel">
                                        <div class="card-body">
                                            <div class="col-md-8">
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped" id="users">
    
                                                            <tr>
                                                                <td>First Name</td>
                                                                <td>
                                                                    <p class="user_name_max">{{ $user->first_name }}</p>
                                                                </td>
    
                                                            </tr>
                                                            <tr>
                                                                <td>Sure Name</td>
                                                                <td>
                                                                    <p class="user_name_max">{{ $user->last_name }}</p>
                                                                </td>
    
                                                            </tr>
                                                            <tr>
                                                                <td>@lang('users/title.email')</td>
                                                                <td>
                                                                    {{ $user->email }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Phone Number</td>
                                                                <td>
                                                                    {{ $user->phone }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Billing Address</td>
                                                                <td>
                                                                    {{ $user->billing_address }}
                                                                </td>
                                                            </tr>
                                                            </tr>
                                                            <tr>
                                                                <td>@lang('users/title.status')</td>
                                                                <td>
    
                                                                    @if($user->deleted_at)
                                                                        Deleted
                                                                    @elseif($user->is_active*1 == 1)
                                                                        Activated
                                                                    @else
                                                                        Pending
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>@lang('users/title.created_at')</td>
                                                                <td>
                                                                    {!! $user->created_at->diffForHumans() !!}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab2" class="tab-pane fade">
                            <div class="row">
                                <div class="col-md-12 pd-top">
                                    <form class="form-horizontal">
                                        <div class="form-body">
                                            <div class="form-group">
                                                {{ csrf_field() }}
                                                <label for="inputpassword" class="col-md-3 control-label">
                                                    Password
                                                    <span class='require'>*</span>
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                                </span>
                                                        <input type="password" id="password" placeholder="Password" name="password"
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputnumber" class="col-md-3 control-label">
                                                    Confirm Password
                                                    <span class='require'>*</span>
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                                </span>
                                                        <input type="password" id="password-confirm" placeholder="Confirm Password" name="confirm_password"
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn btn-primary" id="change-password">Submit
                                                </button>
                                                &nbsp;
                                                <input type="reset" class="btn btn-default" value="Reset"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                     </div>
            
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- Bootstrap WYSIHTML5 -->
    <script  src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#change-password').click(function (e) {
                e.preventDefault();
                var check = false;
                if ($('#password').val() ===""){
                    alert('Please Enter password');
                }
                else if  ($('#password').val() !== $('#password-confirm').val()) {
                    alert("confirm password should match with password");
                }
                else if  ($('#password').val() === $('#password-confirm').val()) {
                    check = true;
                }

                if(check == true){
                var sendData =  '_token=' + $("input[name='_token']").val() +'&password=' + $('#password').val() +'&id=' + {{ $user->id }};
                    var path = "passwordreset";
                    $.ajax({
                        url: path,
                        type: "post",
                        data: sendData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        success: function (data) {
                            alert('password reset successful');
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert('error in password reset');
                        }
                    });
                }
            });
        });
    </script>

@stop
