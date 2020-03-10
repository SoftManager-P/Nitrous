@extends('front/layouts/default')
@section('title')
    My Account | Nitrous Competitions
    @stop
   

@section("content")
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h1>My Account</h1>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 breadcrumb-content">
                <ul>
                <li>
                    <a href="{{url("/")}}">Home</a>
                </li>
                <li class="active">My Account</li>
            </ul>
            </div>
        </div>
    </div>
</div>
<!-- my account wrapper start -->
<div class="my-account-wrapper pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- My Account Page Start -->
                <div class="myaccount-page-wrapper">
                    <!-- My Account Tab Menu Start -->
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <div class="myaccount-tab-menu nav" role="tablist">
                                <a href="#orders" class="active" data-toggle="tab"><i class="las la-cart-arrow-down"></i>
                                    Orders</a>
                                <a href="#account-info" data-toggle="tab"><i class="las la-user"></i> Account Details</a>
                                <a href="#change-password" data-toggle="tab"><i class="las la-lock"></i> Change Password</a>
                                <a href="{{url("/logout")}}"><i class="las la-sign-out-alt"></i> Logout</a>
                            </div>
                        </div>
                        <!-- My Account Tab Menu End -->
                        <!-- My Account Tab Content Start -->
                        <div class="col-lg-9 col-md-8">
                            <div class="tab-content" id="myaccountContent">
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade show active" id="orders" role="tabpanel">
                                    <div class="myaccount-content">
                                        <div class="welcome mb-20">
                                            <p>Hello, <strong>{{Sentinel::getUser()->getFullNameAttribute()}}</strong> (If Not <strong>{{Sentinel::getUser()->first_name}} !</strong><a href="{{url("logout")}}" class="logout"> Logout</a>)</p>
                                        </div>
                                        <h3>Orders</h3>
                                        <div class="myaccount-table table-responsive text-center">
                                            <table id="past-orders" class="table table-bordered">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Order #</th>
                                                        <th>Date</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $orders = Sentinel::getUser()->getOrderList(); ?>
                                                    @foreach($orders as $order)
                                                    <tr>
                                                        <td>{{$order['order_number']}}</td>
                                                        <td>{{date("M j , Y", strtotime($order['order_time']))}}</td>
                                                        <td>£{{$order['real_price']}}</td>
                                                        <td><a href="{{url("order-details")}}/{{$order['id']}}" class="check-btn sqr-btn ">View</a></td>
                                                    </tr>
                                                    @endforeach
                                                    @if(count($orders) == 0)
                                                        <tr>
                                                            <td colspan = "4">There is no data</td>
                                                        </tr>
                                                    @endif    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
                                <?php $user = Sentinel::getUser();?>
                                <div class="tab-pane fade" id="account-info" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Account Details</h3>
                                        <div class="account-details-form">
                                            <form action="{{url("my-account")}}" method = "post">
                                                <input type = "hidden" name = "_token" value = "{{csrf_token()}}"/>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="single-input-item">
                                                            <label for="first-name" class="required">First Name</label>
                                                            <input type="text" name="first_name" value="{{$user['first_name']}}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="single-input-item">
                                                            <label for="last-name" class="required">Last Name</label>
                                                            <input type="text" name="last_name" value="{{$user['last_name']}}"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="single-input-item">
                                                    <label for="display-name" class="required">Username</label>
                                                    <input type="text" id="display-name" placeholder="" value = "{{$user['first_name']}} {{$user['last_name']}}" disabled />
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="single-input-item">
                                                            <label for="email" class="required">Email Addres</label>
                                                            <input type="email"  name="email" value="{{$user['email']}}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="single-input-item">
                                                            <label for="last-name" class="required">Phone Number</label>
                                                            <input type="text" name="phone" value="{{$user['phone']}}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="single-input-item">
                                                    <button class="check-btn sqr-btn ">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="change-password" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Change Password</h3>
                                        <div class="account-details-form">
                                            <form action="{{url("update_password")}}" method = "post">
                                                    <input name = "_token" type = "hidden" value = "{{csrf_token()}}"/>
                                                    <div class="single-input-item">
                                                        <span class="help-block">{{ $errors->first('old_password', ':message') }}</span>
                                                        <label for="current-pwd" class="required">Current Password</label>
                                                        <input type="password"  name ="old_password" />
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                                                                <label for="new-pwd" class="required">New Password</label>
                                                                <input type="password" name="password"  />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <span class="help-block">{{ $errors->first('password_confirm', ':message') }}</span>
                                                                <label for="confirm-pwd" class="required">Confirm Password</label>
                                                                <input type="password" name="password_confirm" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div class="single-input-item">
                                                    <button class="check-btn sqr-btn ">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- Single Tab Content End -->
                            </div>
                        </div> <!-- My Account Tab Content End -->
                    </div>
                </div> <!-- My Account Page End -->
            </div>
        </div>
    </div>
</div>
<!-- my account wrapper end -->
@stop        