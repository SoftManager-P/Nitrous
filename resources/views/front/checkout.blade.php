@extends('front/layouts/default')
@section('title')
    Checkout | Nitrous Competitions
@stop        
@section("content")
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h1>Checkout</h1>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 breadcrumb-content">
                        <ul>
                        <li>
                            <a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="active">Checkout</li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="checkout-main-area pt-40 pb-40">
            <form id = "submitForm">
            <div class="container">
                <div class="checkout-wrap">
                    <div class="row">
                        <div class="col-lg-7">
                            <input type = "hidden" name = "user_name"/>
                            <input type = "hidden" name = "address"/>
                            <input type = "hidden" name = "_token" value = "{{csrf_token()}}"/>
                            <div class="billing-info-wrap mr-50">
                                <h3>Billing Details</h3>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="billing-info mb-20">
                                            <label>First Name <abbr class="required" title="required">*</abbr></label>
                                            <input type="text" name = "first_name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="billing-info mb-20">
                                            <label>Last Name <abbr class="required" title="required">*</abbr></label>
                                            <input type="text" name = "last_name">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="billing-info mb-20">
                                            <label>Street Address <abbr class="required" title="required">*</abbr></label>
                                            <input class="billing-address" placeholder="House number and street name" name = "address1" type="text">
                                            <input placeholder="Apartment, suite, unit etc." name = "address2" type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="billing-info mb-20">
                                            <label>Town / City <abbr class="required" title="required">*</abbr></label>
                                            <input type="text" name = "city">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="billing-info mb-20">
                                            <label>County <abbr class="required" title="required">*</abbr></label>
                                            <input type="text" name ="county">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="billing-info mb-20">
                                            <label>Postcode <abbr class="required" title="required">*</abbr></label>
                                            <input type="text" name = "postcode">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="billing-select mb-20">
                                            <label>Country <abbr class="required" title="required">*</abbr></label>
                                            <select name ="country">
                                                <option value ="">Select a country</option>
                                                <option value = "England">England</option>
                                                <option value = "Scotland">Scotland</option>
                                                <option value = "Ireland">Ireland</option>
                                                <option value = "Wales">Wales</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                        	<div class="cart-countdown">
                        Your Cart Will Expire In: <span class="cart-timer">
                                    <br>
                                    <span class="days"></span>
                                    <span class="hours"></span>
                                    <span class="minutes"></span>
                                    <span class="seconds"></span>
                                </span>
                    		</div>
                            <div class="your-order-area">
                                <h3>Your order</h3>
                                <div class="your-order-wrap gray-bg-4">
                                    <div class="your-order-info-wrap">
                                        <div class="your-order-info">
                                            <ul>
                                                <li>Competition <span>Total</span></li>
                                            </ul>
                                        </div>
                                        <div class="your-order-middle">
                                            <?php $totalPrice = 0; ?>
                                            <ul>
                                                @foreach($list as $item)
                                                <?php
                                                $elePrice = number_format($item['price']*count(explode(",", $item['ticketNo'])),2) ;
                                                $totalPrice += $elePrice;
                                                ?>
                                                <li>{{$item['name']}}<br> Numbers: {{$item['ticketNo']}}<span>£{{$elePrice}} </span></li>
                                                @endforeach    
                                            </ul>
                                        </div>
                                        <?php $diffPrice = 0;?>
                                        @if(isset($promoCodeInfo['id']))
                                            <?php $diffPrice = $promoCodeInfo->getOffPrice(number_format($totalPrice,2)) ; ?>
                                            @if($diffPrice>0)
                                                <div class="your-order-info order-subtotal">
                                                    <ul>
                                                        <li>Discount <span>- £{{$diffPrice}} </span></li>
                                                    </ul>
                                                </div>
                                             @endif
                                        @endif    
                                        <div class="your-order-info order-total">
                                            <ul>
                                                <li>Total <span>£{{number_format($totalPrice-$diffPrice,2)}} </span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="payment-method">
                                        <div class="pay-top sin-payment">
                                            <input id="payment_method_1" class="input-radio" type="radio" value="cheque" checked="checked" name="payment_method">
                                            <label for="payment_method_1"> Credit / Debit Card </label>
                                            <div class="payment-box payment_method_bacs">
                                                <p>Make your payment through our secure payment gateway managed by PayTriot.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="Place-order mt-40">
                                    <button class = "submit">Proceed To Payment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
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

        .cartExpire{
            position: fixed; width: 350px; height: 50px; right: 0; bottom: 0; z-index: 99999999
        }
        @media only screen and (max-width: 768px) {
            /* For mobile phones: */
            .cartExpire{
                position: fixed; width: 100%; height: 50px; right: 0; bottom: 0; z-index: 99999999
            }
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
                    <div class="cartExpire">
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
@stop
@section("footer_scripts")
    <script>
        var order_number = '';
        $(function(){
            $("#submitForm").validate({
                rules: {
                    first_name: "required",
                    last_name: "required",
                    last_name: "required",
                    address1: "required",
                    address2: "required",
                    city: "required",
                    county: "required",
                    postcode: "required",
                    country: "required",
                },
                messages: {

                },
                errorPlacement: function (error, element) {
                    if($(element).closest('div').children().filter("div.error-div").length < 1)
                        $(element).closest('div').append("<div class='error-div'></div>");
                    $(element).closest('div').children().filter("div.error-div").append(error);
                },
                submitHandler: function(form){
                    var url = "{{url("order/createOrder")}}";
                    var first_name = $("input[name='first_name']").val();
                    var last_name = $("input[name='last_name']").val();
                    
                    $("input[name='user_name']").val(first_name+" "+last_name);
                    var address1 = $("input[name='address1']").val();
                    var address2 = $("input[name='address2']").val();
                    $("input[name='address']").val(address1+" "+address2);
                    
                    $.post(url,$(form).serialize(),function(data){
                        if(data.status==1 ){
                            // console.log(data);
                            {{--window.location.href = "{{url("order/paymentProcess")}}/"+data.order_info.order_number;--}}
                             order_number = data.order_info.order_number;
                            $('#paymentIframe').attr("src","{{url("order/paymentProcess")}}/"+data.order_info.order_number);
                            $('#paytriotModal').modal('show');
                            {{--alert("call pay module");--}}
                            {{--console.log(data);--}}
                            {{--alert("call pay callbackurl");--}}
                            {{--var payReturnUrl = "{{url("order/paySuccess")}}";--}}
                            {{--var param =new Object();--}}
                            {{--param._token = _token;--}}
                            {{--param.order_id = data.order_info.id;--}}
                            {{--$.post(payReturnUrl,param, function(data){--}}
                            {{--    if(data.status == "1"){--}}
                            {{--        window.location.href = "{{url("my-account")}}";--}}
                            {{--    }else{--}}
                            {{--        errorMsg(data.msg);--}}
                            {{--    }--}}
                            {{--},"json");--}}
                        }else{
                            errorMsg(data.msg);
                        }
                    }, "json");
                    return false;
                }
            });
        });

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

//            $(".days").html(days + "<span>D </span>");
//            $(".hours").html(hours + "<span>H </span>");
            $(".minutes").html(minutes + "<span>M</span>");
            $(".seconds").html(seconds + "<span>S </span>");
            cnt++;
        }

        function paymentTimeout(){
            $('#paymentIframe').attr("src","{{url("order/timeout")}}/"+order_number);
            $('.cart-countdown').html('Your Cart is expried.');
            $('#paytriotModal').modal('show');
        }

        function removeTimeout() {
            clearInterval(payInterval);
            $('.cart-countdown').remove();
        }

        var payInterval = setInterval(function() { makeTimer(); }, 1000);
        
    </script>
@stop    