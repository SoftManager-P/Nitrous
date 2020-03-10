@extends('admin_panel.layouts.master')

{{-- Web site Title --}}
@section('title')
Find Winner
@parent
@stop

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <h4 class="page-title">Find Winner</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}"> Dashboard</a>
        </li>
        <li class  ="breadcrumb-item "><a href="#">Competitions Manage</a></li>
        <li class  ="breadcrumb-item "><a href="{{url("admin/competition")}}">Competitions</a></li>
        <li class=" breadcrumb-item active">Find Winner</li>
    </ol>
@endsection

{{-- Montent --}}
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title"> Ticket List</h4>
                    <form id = "searchForm" action = "{{url("admin/competition/findWinner/".$competition_id)}}" method = "post">
                    <input type = "hidden" name = "_token" value = "{!! csrf_token() !!}"/>
                    <input type = "hidden" name = "page" value = "{{$pageParam['pageNo']}}"/>
                    <div class = "row form-group">
                        <div class = "col-sm-3 text-left">
                            <input class = "form-control searchInput" name = "search" placeholder="Search"  value = "{{$search}}"/>
                        </div>
                        <div class = "col-sm-6 text-right">
                            <button type="button" class="btn btn-responsive button-alignment btn-success hidden" onclick = "editItem(0)" style="margin-bottom:7px;" data-toggle="button">Add</button>
                        </div>
                    </div>
                    </form>

                    <div class="card-body">
                        <table class="table table-bordered table-hover table-last-bottom">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ticket Number</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Telephone Number</th>
                                <th width="300px;" class = "hidden"></th>
                            </tr>
                            </thead>
                            <tbody >
                                @foreach($list as $key=>$item)
                                    <tr>
                                        <td>{{$key+1+$pageParam['startNumber']}}</td>
                                        <td>
                                            {{$item['ticket_no']}}
                                        </td>
                                        <td>{{$item['order_detail']['order']['user_name']}}</td>
                                        <td>{{$item['order_detail']['order']['address']}}</td>
                                        <td>{{$item['order_detail']['order']['phone']}}</td>
                                        <td class = "hidden">
                                            @if($item['status'] == 2 && $item['is_winner']*1 == 0)
                                            <a href="javascript:void(0);" onclick = "setWinner('{{$item['id']}}')"  class="btn default btn-xs purple">
                                                <i class="livicon" data-name="pen" data-loop="true" data-color="#000" data-hovercolor="black" data-size="14"></i>
                                                Find Winner
                                            </a>
                                            @elseif($item['status'] == 2 && $item['is_winner']*1 == 1)
                                                Winner
                                            @endif
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
</div>
@stop
{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <script src="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/pdfmake.min.js')}}"></script>
    <script src="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/vfs_fonts.js')}}"></script>
    <script src="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/buttons.print.min.js')}}"></script>
    <script src="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
    <!-- Responsive examples -->
    <script src="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
    <script src="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
    
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
    <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>

    <script>
        $(document).ready(function(){

        });
        $(".searchInput").change(function(){
            searchData(0);
        });
        function setWinner(id){
            confirmMsg('Do you sure this item setting winner?', function(){
                setTimeout(function(){
                    var param = new Object();
                    param._token = _token;
                    param.id = id;
                    $.post("{{url("admin/competition/setWinner")}}", param, function(data){
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

