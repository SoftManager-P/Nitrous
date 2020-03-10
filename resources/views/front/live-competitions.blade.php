@extends('front/layouts/default')
@section('title')
    Live Competitions | Nitrous Competitions
    @stop
    

@section("content")
<div class="breadcrumb-area bg-img">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h1>Live Competitions</h1>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 breadcrumb-content">
                <ul>
                <li>
                    <a href="{{url("/")}}">Home</a>
                </li>
                <li class="active">Live Competitions</li>
            </ul>
            </div>
        </div>
    </div>
</div>
<div class="competitions-area pt-20 pb-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form action = "{{url("live-competitions")}}" id = "searchForm">
                    <input type = "hidden" name = "_token" value = "{!! csrf_token() !!}"/>
                    <div class="shop-topbar-wrapper">
                        <div class="shop-topbar-left">
                            <p>Showing {{$pageInfo['startNumber']}} - {{$pageInfo['startNumber'] + $pageInfo['perPageSize']}} of {{$pageInfo['totalCount']}} results </p>
                        </div>
                        <div class="competition-sorting-wrapper">
                            <div class="competition-shorting shorting-style">
                                <label>View:</label>
                                <select name = "perPageSize" class = "searchInput">
                                    <option value="20" @if($pageInfo['perPageSize']*1 == 20) selected @endif> 20</option>
                                    <option value="23" @if($pageInfo['perPageSize']*1 == 23) selected @endif> 23</option>
                                    <option value="30" @if($pageInfo['perPageSize']*1 == 30) selected @endif> 30</option>
                                </select>
                            </div>
                            <div class="competition-show shorting-style">
                                <label>Sort by:</label>
                                <select name = "sortKey" class = "searchInput">
                                    <option value="" @if($sortKey == '') selected @endif>Default</option>
                                    <option value="name" @if($sortKey == 'name') selected @endif> Name</option>
                                    <option value="price" @if($sortKey == 'price') selected @endif> Price</option>
                                    <option value="remain" @if($sortKey == 'remain') selected @endif> Remaining Tickets</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>    
                <div class="competitions-bottom-area">
                    <div class="tab-content jump">
                        <div id="shop-1" class="tab-pane active">
                            <div class="row">
                                @foreach($list as $item)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                    <div class="competition-wrap mb-35">
                                        <div class="competition-img mb-15">
                                            <a href="{{url("competition-page")}}/{{$item['id']}}"><img src="{{correctImgPath($item['main_image'])}}" alt="Banshee" onerror="noExitImg(this)"></a>
                                        </div>
                                        <div class="competition-content">
                                            <div class="progress">
                                              <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                              aria-valuemin="0" aria-valuemax="100" style="width:{{$item->getSoldPro()}}%">
                                              </div>
                                            </div>
                                            <h4><a href="{{url("competition-page")}}">{{$item['name']}}</a></h4>
                                            <div class="price-addtocart">
                                                <div class="competition-price">
                                                    <span>£{{$item['price']}}</span>
                                                </div>
                                                <div class="competition-addtocart">
                                                    <a title="Enter Comp" href="#">+ More Info</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @include("front/layouts.pagination")
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop        