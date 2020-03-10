@extends('admin_panel.layouts.master')

{{-- Web site Title --}}
@section('title')
Competitions
@parent
@stop
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset("assets/tree/dtree.css")}}">
    <script src="{{asset("assets/tree/dtree.js")}}"></script>
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/iCheck/css/all.css') }}"  rel="stylesheet" type="text/css" />
@stop


@section('breadcrumb')
    <h4 class="page-title">Competitions</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}"> Dashboard</a>
        </li>
        <li class  ="breadcrumb-item active"><a href="#">Competitions Manage</a></li>
        <li class=" breadcrumb-item active active">Competitions</li>
    </ol>
@endsection
{{-- Montent --}}
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <h4 class="mt-0 header-title"> Competitions List</h4>
                    </div>

                    <div class="card-body">
                    <form id = "searchForm" action = "{{url("admin/competition")}}" method = "post">
                    <input type = "hidden" name = "_token" value = "{!! csrf_token() !!}"/>
                    <input type = "hidden" name = "page" value = "{{$pageParam['pageNo']}}"/>
                    <div class = "row">
                        <div class = "col-sm-3 text-left">
                            <input class = "form-control searchInput" name = "search" placeholder="Search"  value = "{{$search}}"/>
                        </div>
                        <div class = "col-sm-6 text-right">
                            <button type="button" class="btn btn-responsive button-alignment btn-success hidden" onclick = "editItem(0)" style="margin-bottom:7px;" data-toggle="button">Add</button>
                        </div>
                    </div>
                    </form>

                    <div class="card-body ">
                        <table class="table table-bordered table-hover table-last-bottom">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Sold</th>
                                <th>Remaining</th>
                                <th>Finish Date</th>
                                <th width="400px;"></th>
                            </tr>
                            </thead>
                            <tbody >
                                @foreach($list as $key=>$item)
                                    <tr>
                                        <td>{{$key+1+$pageParam['startNumber']}}</td>
                                        <td>
                                            <a class = "underline" href="javascript:void(0);" onclick = "editItem('{{$item['id']}}')" > {{$item['name']}}</a>
                                        </td>
                                        <td>{{$item->getSoldCount()}}</td>
                                        <td>{{$item->getRemainCount()}}</td>
                                        <td>{{substr($item['deadline_date'],0,10)}}</td>
                                        <td>
                                            <a href="{{url("admin/competition/findWinner/".$item['id'])}}"  class="btn  btn-xs btn-primary">
                                                <i class="livicon" data-name="pen" data-loop="true" data-color="#000" data-hovercolor="black" data-size="14"></i>
                                                Find Winner
                                            </a>
                                            <a href="javascript:void(0);" onclick = "deleteItem('{{$item['id']}}')" class="btn  btn-xs btn-primary">
                                                <i class="livicon" data-name="trash" data-loop="true" data-color="#000" data-hovercolor="black" data-size="14"></i>
                                                Delete
                                            </a>
                                            <a href="javascript:void(0);" onclick = "forceStop('{{$item['id']}}')" class="btn  btn-xs btn-primary">
                                                <i class="livicon" data-name="lab" data-loop="true" data-color="#000" data-hovercolor="black" data-size="14"></i>
                                                Force Stop
                                            </a>
                                        </td>
                                        </td>
                                    </tr>
                                @endforeach
                                @if(count($list) == 0)
                                    <tr>
                                        <td colspan = "9">There is not data</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                        <div class = "text-center">
                            @include("admin_panel.layouts.pagination")
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>





@stop
{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
    <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>

    <script>
        $(document).ready(function(){
            

        });
        $(".searchInput").change(function(){
            searchData(0);
        });
        function editItem(id){
            window.location.href = "{{url("admin/competition/getInfo")}}"+"/"+id;
        }
        
        function  forceStop(id){
            confirmMsg('Do you sure this item  force stop !', function(){
                setTimeout(function(){
                    var param = new Object();
                    param._token = _token;
                    param.id = id;
                    param.status = 1;
                    $.post("{{url("admin/competition/ajaxUpdateInfo")}}", param, function(data){
                        if(data.status == "1"){
                            successMsg(data.msg, function(){
                                window.location.reload();
                            });
                        }else{
                            errorMsg(data.msg);
                        }
                    }, "json");
                }, 300);
            });
        }
        function deleteItem(id){
            confirmMsg('Do you sure delete this item!', function(){
                setTimeout(function(){
                    var param = new Object();
                    param._token = _token;
                    param.id = id;
                    $.post("{{url("admin/competition/ajaxDeleteInfo")}}", param, function(data){
                        if(data.status == "1"){
                            successMsg(data.msg, function(){
                                window.location.reload();
                            });
                        }else{
                            errorMsg(data.msg);
                        }
                    }, "json");
                }, 300);
            });
        }
    </script>

@stop

