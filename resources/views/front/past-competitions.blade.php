@extends('front/layouts/default')
@section('title')
    Past Winner | Nitrous Competitions
@stop

@section('header_styles')
    <link href="{{ asset('assets/css/frontend/modal-video.min.css') }}" rel="stylesheet" type="text/css">
@stop
@section("content")
<div class="breadcrumb-area bg-img">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h1>Past Winner</h1>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 breadcrumb-content">
                <ul>
                <li>
                    <a  href="{{url("/")}}" target="_top">Home</a>
                </li>
                <li class="active">Past Winner</li>
            </ul>
            </div>
        </div>
    </div>
</div>
<div class="winners-area  pt-20 pb-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form action = "{{url("past")}}" id = "searchForm">
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
                        </div>
                    </div>
                </form>    
                <div class="competitions-bottom-area">
                    <div class="tab-content jump">
                        <div id="shop-1" class="tab-pane active">
                            <div class="row">
                                @foreach($list as $item)
                                    <div class="col-lg-4 mt-20 mb-20">
                                        <h4>{{$item['title']}}</h4>
                                        <div class="winner-pic">
                                            <img style = "width:100%" src="{{correctImgPath1($item['photo'])}}">
                                        </div>
                                        <div class="winner-table pt-10">
                                            <div class="data-responsive">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    <tr>
                                                        <td>Competition</td>
                                                        <td>{{$item['title']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Winner</td>
                                                        <td>{{$item['winner_user_name']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ticket Number</td>
                                                        <td>{{$item['ticket_number']}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <button class="js-video-button btn live-draw-video" data-channel="facebook" data-video-id="{{$item['draw_video_url']}}">View Live Draw Video</button>
                                            </div>
                                            <div class="col-lg-6">
                                                <button class="js-video-button btn winner-video" data-channel="facebook" data-video-id="{{$item['delivery_video_ur1']}}">View Winner Video</button>
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
@section("footer_scripts")
    <script src="{{ asset('assets/js/frontend/modalVideo.js') }}" ></script>
    <script>
        $(".js-video-button").modalVideo();
    </script>
@stop