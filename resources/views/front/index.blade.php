@extends('front/layouts/default')
@section('title')
    @parent
    In It To Win It
@stop
@section('content')
    <div class="live-draw pt-25 pb-50">
        <div class="container">
            <div class="row">
                <div class="bg-img col-lg-10 col-md-10 col-sm-11 offset-md-1 text-center pt-50 pb-50">
                    <h3 class="text-white">Our Next Live Draw</h3>
                    <p class="text-white">NEXT LIVE DRAW 11/02/20 AT 20:00 THE LAND ROVER</p>
                    <div id="draw-timer">
                        <div id="days"></div>
                        <div id="hours"></div>
                        <div id="minutes"></div>
                        <div id="seconds"></div>
                    </div>
                    <p class="text-white">LIVE DRAWS ARE BROADCASTED FROM OUR FACEBOOK PAGE</p>
                </div>
            </div>
        </div>
    </div>

    <div class="competitions-area pt-25 pb-135">
        <div class="container">
            <div class="section-title text-center mb-40">
                <h2>Featured Competitions</h2>
                <p>We have cherry picked some of the best prizes, as requested by our members. Be quick and grab a number before they sell out.</p>
            </div>
            <div class="competition-slider-active owl-carousel">
                @foreach($liveCompetiotions as $live)
                <div class="competition-wrap">
                    <div class="competition-img mb-15">
                        <a href="{{url("competition-page")}}/{{$live['id']}}"><img src="{{ correctImgPath($live['main_image'])}}" alt="product"></a>
                        @if($live->getSoldPro()*1 == 100)
                        <span class="new-stock"><span>SOLD<br>OUT</span></span>
                        @endif    
                    </div>
                    <div class="competition-content">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                 aria-valuemin="0" aria-valuemax="100" style="width:{{$live->getSoldPro()}}%">
                            </div>
                        </div>
                        <h4><a href="{{url("competition-page")}}/{{$live['id']}}">{{$live['name']}}</a></h4>
                        <div class="price-addtocart">
                            <div class="competition-price">
                                <span>£{{$live['price']}}</span>
                            </div>
                            <div class="competition-addtocart">
                                <a title="Enter Comp" href="#">+ View Comp</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-12 text-center mt-20">
                    <div class="solid-btn btn-hover hover-border-none">
                        <a class="btn-color-white btn-color-theme-bg black-color" href="{{url("live-competitions")}}">View All Live Competitions</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="about-area pb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-6">
                    <div class="about-img">
                        <a href="#">
                            <img src="{{url("assets/front/assets/images/main/about-nitrous-competitions.jpg")}}" alt="Nitrous Competitions">
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="about-content">
                        <h2>About Nitrous Competitions</h2>
                        <p>Nitrous Competitions is a new, innovative competitions service built with you in mind. Our aim is to provide our contenders the chance to win amazing prizes. We will be giving away some exclusive prizes from luxury cars to sports / motorcross bikes and anything in between.</p>
                        <p>It’s simple to get involved – all you need to do is browse our live competitions and click into one that you like the look of. We give you the option to pick your lucky number then you will require your skill and knowledge to answer the mulitple choice question. If you are successful then you’ll be entered into the live draw. The odds are fantastic so go ahead what have you got to lose!</p>
                        <div class="discount-btn default-btn btn-hover">
                            <a class="btn-color-theme btn-size-md btn-style-outline" href="{{url("live-competitions")}}">View Live Competitions</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="how-it-works pb-80">
        <div class="container">
            <div class="section-title text-center mb-40">
                <h3>How It Works</h3>
            </div>
            <div class="feature-border feature-border-about">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                        <div class="feature-wrap mb-30 text-center">
                            <img src="{{url("assets/front/assets/images/main/create-account.png")}}" alt="">
                            <h5>1. Register Your Account</h5>
                            <span>Before you enter any of our competitions you will need to create an account.</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                        <div class="feature-wrap mb-30 text-center">
                            <img src="{{url("assets/front/assets/images/main/choose-comp.png")}}" alt="">
                            <h5>2. Choose Your Competition</h5>
                            <span>Take a look at our live competitions and choose one that you would like to enter.</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                        <div class="feature-wrap mb-30 text-center">
                            <img src="{{url("assets/front/assets/images/main/checkout.png")}}" alt="">
                            <h5>3. Purchase Your Numbers</h5>
                            <span>Once you have found a competition you like the look of then go ahead and purchase your numbers.</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                        <div class="feature-wrap mb-30 text-center">
                            <img src="{{url("assets/front/assets/images/main/live-draw.png")}}" alt="">
                            <h5>4. Watch The Live Draw</h5>
                            <span>Have your ticket number ready and tune in for the live draw via our Facebook page.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="winners-area pb-135">
        <div class="container">
            <div class="section-title text-center mb-40">
                <h2>Nitrous Winners</h2>
                <p>We thrive off seeing our members win our competitions which is why we will always deliver our prizes in person.</p>
            </div>
            <div class="winner-slider-active owl-carousel">
                @foreach($pastCompetitions as $item)
                <div class="winner-wrap">
                    <div class="winner-img mb-15">
                        <img src="{{correctImgPath1($item['photo'])}}" >
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-12 text-center mt-20">
                    <div class="solid-btn btn-hover hover-border-none">
                        <a class="btn-color-white btn-color-theme-bg black-color" href="{{url("past")}}">View All Our Past Winners</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function makeTimer() {

        //		var endTime = new Date("29 April 2018 9:56:00 GMT+01:00");
        var endTime = new Date("29 March 2020 9:56:00 GMT+01:00");
        endTime = (Date.parse(endTime) / 1000);

        var now = new Date();
        now = (Date.parse(now) / 1000);

        var timeLeft = endTime - now;

        var days = Math.floor(timeLeft / 86400);
        var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
        var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
        var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

        if (hours < "10") { hours = "0" + hours; }
        if (minutes < "10") { minutes = "0" + minutes; }
        if (seconds < "10") { seconds = "0" + seconds; }

        $("#days").html(days + "<span>Days</span>");
        $("#hours").html(hours + "<span>Hours</span>");
        $("#minutes").html(minutes + "<span>Minutes</span>");
        $("#seconds").html(seconds + "<span>Seconds</span>");

        }

        setInterval(function() { makeTimer(); }, 1000);
    </script>
@stop  

