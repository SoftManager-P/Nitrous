@extends('front/layouts/default')
@section('title')
    Cart | Nitrous Competitions
@stop
@section('content')
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h1>Cart</h1>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 breadcrumb-content">
                        <ul>
                        <li>
                            <a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="active">Cart</li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="cart-main-area pt-40 pb-40">
            <div class="container">
                @if(count($list) > 0)
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h3 class="cart-page-title">Your competition entries</h3>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 offset-lg-3 cart-countdown">
                        Your Cart Will Expire In: <span class="cart-timer"><br>
                                                            <span id="days"></span>
                                                            <span id="hours"></span>
                                                            <span id="minutes"></span>
                                                            <span id="seconds"></span>
                        </span>
                    </div>
                </div>
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
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $totalPrice = 0; ?>
                                        @foreach($list as $item)
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
                                            <td class="product-remove">
                                                <a href="javascript:void(0)" onclick = "deleteBusketCompetition(this)" data-competition-id = "{{$item['id']}}"><i class="la la-trash" title="Remove"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach    
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="discount-code-wrapper">
                                    <div class="title-wrap">
                                        <h4 class="cart-bottom-title section-bg-gray">Use Coupon Code</h4>
                                    </div>
                                    <div class="discount-code">
                                        <p>Enter your coupon code if you have one.</p>
                                        <form id = "couponForm" action = "{{url("basket/applyCoupon")}}">
                                            <input type="text" required="" name="code" method = "post">
                                            <span class="help-block">{{ $errors->first('coupon', ':message') }}</span>
                                            <button class="cart-btn-2">Apply Coupon</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="checkout-total">
                                    <div class="title-wrap">
                                        <h4 class="cart-bottom-title section-bg-gary-cart">Cart Total</h4>
                                    </div>
                                    <h5 >Total entries <span>£{{number_format($totalPrice,2)}}</span></h5>
                                    <?php $diffPrice = 0;?>
                                    @if(isset($promoCodeInfo['id']))
                                    <?php $diffPrice = $promoCodeInfo->getOffPrice(number_format($totalPrice,2)) ; ?>
                                    @if($diffPrice>0)
                                    <div class="total-discount ">
                                        <?php $promoCodeInfo1 = $promoCodeInfo->getPromoCodeInfo(); ?>
                                        <h5>Discount Code : {{$promoCodeInfo1['promo_code']}} OFF <span>- £{{$diffPrice}}</span></h5>
                                    </div>
                                    @endif    
                                    @endif
                                    <h4 class="checkout-total-title" >Checkout Total <span>£{{number_format($totalPrice-$diffPrice,2)}}</span></h4>
                                    <a href="{{url("checkout")}}">Proceed to Checkout</a>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
           <style>
            body {
                padding-top: 50px;
            }

            /*modal fullscreen */

            .modal.modal-fullscreen {
                width: 100%;
                height: 100%;
                background: #fff;
            }
            .modal-fullscreen .modal-dialog{
                max-width: 100%;
            }
            .modal.modal-fullscreen .modal-dialog,
            .modal.modal-fullscreen .modal-content {
                bottom: 0;
                left: 0;
                position: absolute;
                right: 0;
                top: 0;
            }
            .modal.modal-fullscreen .modal-dialog {
                margin: 0;
                width: 100%;
            }
            .modal.modal-fullscreen .modal-content {
                border: none;
                -moz-border-radius: 0;
                border-radius: 0;
                -webkit-box-shadow: inherit;
                -moz-box-shadow: inherit;
                -o-box-shadow: inherit;
                box-shadow: inherit;
                /* change bg color below */
                /* background:#1abc9c; */
            }
            .modal.modal-fullscreen.force-fullscreen {
                /* Remove the padding inside the body */
            }
            .modal.modal-fullscreen.force-fullscreen .modal-body {
                padding: 0;
            }
            .modal.modal-fullscreen.force-fullscreen .modal-header,
            .modal.modal-fullscreen.force-fullscreen .modal-footer {
                left: 0;
                position: absolute;
                right: 0;
            }
            .modal.modal-fullscreen.force-fullscreen .modal-header {
                top: 0;
            }
            .modal.modal-fullscreen.force-fullscreen .modal-footer {
                bottom: 0;
            }
        </style>
        <!-- /.container -->
        <div class="modal fade modal-fullscreen " id="paytriotModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <iframe id="paymentIframe" src="" style="position:fixed; background: #fff; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;">
                            Your browser doesn't support iframes
                        </iframe>
                    </div>
                    <div class="cartExpire" style="position: fixed; width: 350px; height: 50px; right: 0; bottom: 0; z-index: 99999999">
                        <div class="cart-countdown">
                            Your Cart Will Expire In: <span class="cart-timer">
                        <br>
                        <span class="days"></span>
                        <span class="hours"></span>
                        <span class="minutes"></span>
                        <span class="seconds"></span>
                    </span>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
                @else
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <h4 class="cart-page-title">YOU DO NOT HAVE ANY COMPETITION ENTRIES IN YOUR CART</h4>
                            <div class="solid-btn btn-hover hover-border-none">
                                <a class="btn-color-white btn-color-theme-bg black-color" href="{{URL("live-competitions")}}">View All Live Competitions</a>
                            </div>
                        </div>
                    </div>    
                @endif
            </div>
        </div>
    
@stop
@section("footer_scripts")
    <script>

        var cnt = 0;
        var diff = "{{$diff}}";
        function makeTimer() {
            if(diff == "") return;
            var diffTime = parseInt(diff);
            var timeLeft = diffTime - cnt;

            if(timeLeft <0){
                paymentTimeout();
                clearInterval(payInterval);
                return;
            }

            var days = 0;
            var hours = "00";
            var minutes = Math.floor(timeLeft / 60);
            var seconds = Math.floor((timeLeft - (minutes * 60)));

            /*if (hours < "10") { hours = "0" + hours; }*/
            if (minutes < "10") { minutes = "0" + minutes; }
            if (seconds < "10") { seconds = "0" + seconds; }

//            $("#days").html(days + "<span>D </span>");
//            $("#hours").html(hours + "<span>H </span>");
            $("#minutes").html(minutes + "<span>M</span>");
            $("#seconds").html(seconds + "<span>S </span>");
            cnt++;
        }


        function paymentTimeout(){
            $('#paymentIframe').attr("src","{{url("order/timeout")}}/0");
            $('.cart-countdown').html('Your Cart is expried.');
            $('#paytriotModal').modal('show');
        }

        var payInterval = setInterval(function() { makeTimer(); }, 1000);
        
        function deleteBusketCompetition(obj){
            confirmMsg("Do you sure delete this item", function(){
                var competiotion_id = $(obj).attr("data-competition-id");
                var url = "{{url("basket/deleteCartCompetition")}}";
                var param = new Object();
                param._token = _token;
                param.competiotion_id = competiotion_id;
                $.post(url, param,function(data){
                    setTimeout(function(){
                        if(data.status == "1"){
                            successMsg(data.msg, function(){
                                window.location.reload();
                            });
                        }else{
                            errorMsg(data.msg);
                        }
                    }, 1000);
                }, "json");
            });
            
        }
    </script>
@stop    