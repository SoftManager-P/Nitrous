@extends('admin_panel.layouts.master')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/admin_panel/assets/plugins/morris/morris.css')}}">
@endsection

@section('breadcrumb')
    <h4 class="page-title">Dashboard</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            Welcome to Ncw Dashboard
        </li>
    </ol>
@endsection

@section('content')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="card mini-stat bg-danger">
                            <div class="card-body mini-stat-img">
                                <div class="mini-stat-icon">
                                    <i class="mdi mdi-cube-outline float-right"></i>
                                </div>
                                <div class="text-white">
                                    <h6 class="text-uppercase mb-3">NUMBER OF ORDERS IN THE PAST 24 HOURS</h6>
                                    <h4 class="mb-4">{{number_format($orderData['curCount'])}}</h4>
                                    <span class="badge badge-info">{{$orderData['curCountPro']}}% </span> <span class="ml-2">From previous period</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card mini-stat bg-danger">
                            <div class="card-body mini-stat-img">
                                <div class="mini-stat-icon">
                                    <i class="mdi mdi-buffer float-right"></i>
                                </div>
                                <div class="text-white">
                                    <h6 class="text-uppercase mb-3">NUMBER OF £££ IN THE PAST 24 HOURS</h6>
                                    <h4 class="mb-4">£ {{number_format($orderData['curPrice'])}}</h4>
                                    <span class="badge badge-danger"> {{$orderData['curPricePro']}}% </span> <span class="ml-2">From previous period</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card mini-stat bg-danger">
                            <div class="card-body mini-stat-img">
                                <div class="mini-stat-icon">
                                    <i class="mdi mdi-tag-text-outline float-right"></i>
                                </div>
                                <div class="text-white">
                                    <h6 class="text-uppercase mb-3">NUMBER OF ACTIVE COMPETITION</h6>
                                    <h4 class="mb-4">{{number_format($competitionData['curCount'])}}</h4>
                                    <span class="badge badge-warning"> {{$competitionData['curCountPro']}}% </span> <span class="ml-2">From previous period</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-9">
                        <div class="card m-b-20">
                            <div class="card-body">
                                <h4 class="mt-0 m-b-30 header-title">ACTIVE COMPETITIONS</h4>

                                <div class="table-responsive">
                                    <table class="table table-vertical mb-1">

                                        <tbody>
                                        @foreach($activeList as $item)
                                        <tr>
                                            <td>#{{$item['id']}}</td>
                                            <td>
                                                <img src="{{correctImgPath1($item['main_image'])}}" alt="user-image" onerror = "noExitImg(this)" class="thumb-sm mr-2 rounded-circle"/>
                                                Riverston Glass Chair
                                            </td>
                                            <td>
                                                @if($item['status']*1 == 0)
                                                    <span class="badge badge-pill badge-success">On sale</span>
                                                @elseif($item['status']*1 == 1)
                                                    <span class="badge badge-pill badge-warning">Doing</span>
                                                @else
                                                    <span class="badge badge-pill badge-danger">Complete</span>
                                                @endif    
                                            </td>
                                            <td>
                                                £{{$item['price']}}
                                            </td>
                                            <td>
                                                {{date("m/d/y", strtotime($item['deadline_date']))}}
                                            </td>
                                            <td>
                                                <a href = "{{url("admin/competition/getInfo")}}/{{$item['id']}}" class="btn btn-secondary btn-sm waves-effect waves-light">Edit</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="card m-b-20">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">Recently Earnings</h4>

                                <div class="row text-center m-t-20">
                                    <div class="col-6">
                                        <h5 class="" id = "price">£ 2548</h5>
                                        <p class="text-muted font-14">Marketplace</p>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="" id = "count">6985</h5>
                                        <p class="text-muted font-14">Total Income</p>
                                    </div>
                                </div>

                                <div id="morris-bar-stacked" class="dashboard-charts morris-charts"></div>
                            </div>
                        </div>
                    </div>

                </div>
               

            </div> <!-- end container-fluid -->
@endsection

@section('script')
		<!--Morris Chart-->
        <script src="{{ URL::asset('assets/admin_panel/assets/plugins/morris/morris.min.js')}}"></script>
        <script src="{{ URL::asset('assets/admin_panel/assets/plugins/raphael/raphael-min.js')}}"></script>
    
        <script>
            function createStackedChart(element, data, xkey, ykeys, labels, lineColors){
                Morris.Bar({
                    element: element,
                    data: data,
                    xkey: xkey,
                    ykeys: ykeys,
                    stacked: true,
                    labels: labels,
                    hideHover: 'auto',
                    resize: true, //defaulted to true
                    gridLineColor: '#eee',
                    barColors: lineColors
                });
            }
            
            $(function(){
               drawChart(); 
            });
            
            function drawChart(){
                var url = "{{url("admin/dashboard/getChartData")}}";
                var param = new Object();
                param._token = _token;
                $.post(url, param, function(data){
                    if(data.status == "1"){
                        createStackedChart('morris-bar-stacked', data.data, 'y', ['a', 'b'], ['Series A', 'Series B'], ['#28bbe3','#f0f1f4']);
                        $("#price").html("£ " + data.price);
                        $("#count").html(data.cnt);
                    }
                }, "json");
                var $stckedData  = [
                    { y: '01', a: 45, b: 180},
                    { y: '02', a: 75,  b: 65},
                    { y: '03', a: 100, b: 90},
                    { y: '2008', a: 75,  b: 65},
                    { y: '2009', a: 100, b: 90},
                    { y: '2010', a: 75,  b: 65},
                    { y: '2011', a: 50,  b: 40},
                    { y: '2012', a: 75,  b: 65},
                    { y: '2013', a: 50,  b: 40},
                    { y: '2014', a: 75,  b: 65},
                    { y: '2015', a: 100, b: 90},
                    { y: '2016', a: 80, b: 65}
                ];
            }

            
            
            
            
        </script>
@endsection