@extends('front/layouts/default')
@section('title')
    Order Details | Nitrous Competitions
@stop
@section("content")
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h1>Order Details</h1>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 breadcrumb-content">
                        <ul>
                        <li>
                            <a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="active">Order Details</li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="cart-main-area pt-40 pb-40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <form action="#">
                            <div class="table-content table-responsive cart-table-content">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Ticket Numbers</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $totalPrice = 0; ?>
                                        @foreach($detailList as $item)
                                        <tr>
                                            <td class="product-thumbnail">
                                                <a href="#"><img src="{{correctImgPath1($item['main_image'])}}" alt="" onerror = "noExitImg(this)" style = "width:90px;"></a>
                                            </td>
                                            <td class="product-name"><a href="#">{{$item['name']}}</a></td>
                                            <td class="product-price-cart"><span class="amount">{{$item['ticketNo']}}</span></td>
                                            <?php
                                            $elePrice = number_format($item['price']*count(explode(",", $item['ticketNo'])),2) ;
                                            $totalPrice += $elePrice;
                                            ?>
                                            <td class="product-subtotal">£{{$elePrice}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="checkout-total">
                                    <div class="title-wrap">
                                        <h4 class="cart-bottom-title section-bg-gary-cart">Order Details</h4>
                                    </div>
                                    <h5>Date <span>{{date("j M", strtotime($order['order_time']))}}</span></h5>
                                    <h5>Order # <span>{{$order['order_number']}}</span></h5>
                                    <div class="title-wrap">
                                        <h4 class="cart-bottom-title section-bg-gary-cart">Order Total</h4>
                                    </div>
                                    <h5>Total entries <span>£{{number_format($order['total_price'],2)}}</span></h5>
                                    @if($order['diff_price']*1 >0)
                                    <div class="total-discount">
                                        <h5>Discount Code : NITROUS10OFF <span>- £{{$order['diff_price']}}</span></h5>
                                    </div>
                                    @endif
                                    <h4 class="checkout-total-title">Order Total <span>£{{number_format($order['real_price'],2)}}</span></h4>
                                    <a href="{{url("my-account")}}">Return To Account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop        