<div class="main-header-wrap">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-3">
                <div class="logo mt-30">
                    <a href="{{url("/")}}"><img src="{{url("assets/front/assets/images/logo/logo-drk.png")}}" alt="logo"></a>
                </div>
            </div>
            <div class="col-xl-7 col-lg-6">
                <div class="main-menu menu-common-style menu-lh-1">
                    <nav>
                        <ul>
                            <li><a href="{{url("/")}}">Home</a>
                            </li>
                            <li><a href="{{url("live-competitions")}}">Live Competitions</a>
                            </li>
                            <li><a href="{{url("/past")}}">Winners</a></li>
                            <li><a href="#">FAQ</a>
                            </li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3">
                <div class="header-right-wrap mt-40">
                    <div class="header-login mr-20">
                        <a href="{{url("login")}}"><i class="las la-user-circle"></i></a>
                    </div>
                    @if(Sentinel::getUser())
                    <div class="cart-wrap common-style">
                        <a href="{{url("cart")}}/0" class="cart-active">
                            <i class="las la-shopping-cart"></i>
                            <?php $cartCount = Sentinel::getUser()->getCartCount();?>
                            @if($cartCount > 0)
                            <span class="count-style" id = "cart-num">{{$cartCount}}</span>
                            @endif    
                        </a>
                    </div>
                    @endif    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="header-small-mobile">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-6">
                <div class="mobile-logo">
                    <a href="{{url("/")}}">
                        <img alt="" src="{{url("assets/front/assets/images/logo/logo-drk.png")}}">
                    </a>
                </div>
            </div>
            <div class="col-6">
                <div class="header-right-wrap">
                    <div class="cart-wrap common-style">
                        @if(Sentinel::getUser())
                        <a href="{{url("cart")}}/0" class="cart-active">
                            <i class="la la-shopping-cart"></i>
                            <span class="count-style">12</span>
                        </a>
                        @endif    
                    </div>
                    <div class="mobile-off-canvas">
                        <a class="mobile-aside-button" href="#"><i class="la la-navicon la-2x"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>