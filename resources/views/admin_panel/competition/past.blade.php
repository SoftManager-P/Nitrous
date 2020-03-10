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

@section('breadcrumb')
    <h4 class="page-title">Past Winner</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}"> Dashboard</a>
        </li>
        <li class  ="breadcrumb-item "><a href="#">Competitions Manage</a></li>
        <li class=" breadcrumb-item active">Past Winner</li>
    </ol>
@endsection

{{-- Montent --}}
@section('content')
<!-- Main content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title"> Competitions List</h4>
                    <form id = "searchForm" action = "{{url("admin/competition/past")}}" method = "post">
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
                </div>
                <div class="card-body">
                        <table class="table table-bordered table-hover table-last-bottom">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Sold</th>
                                <th>Remaining</th>
                                <th>Finish Date</th>
                                <th width="300px;"></th>
                            </tr>
                            </thead>
                            <tbody >
                                @foreach($list as $key=>$item)
                                    <tr>
                                        <td>{{$key+1+$pageParam['startNumber']}}</td>
                                        <td>
                                            <a href="javascript:void(0);" onclick = "editItem('{{$item['id']}}')" > {{$item['name']}}</a>
                                        </td>
                                        <td>{{$item->getSoldCount()}}</td>
                                        <td>{{$item->getRemainCount()}}</td>
                                        <td>{{substr($item['deadline_date'],0,10)}}</td>
                                        <td>
                                            <a href="{{url("admin/competition/doing_edit/".$item['id'])}}"  class="btn default btn-xs purple">
                                                <i class="livicon" data-name="pen" data-loop="true" data-color="#000" data-hovercolor="black" data-size="14"></i>
                                                Edit
                                            </a>
                                            @if($item['status']*1 == 1)
                                            <a href="javascript:void(0);" onclick = "completeCompetition('{{$item['id']}}')" class="btn default btn-xs black">
                                                <i class="livicon" data-name="lab" data-loop="true" data-color="#000" data-hovercolor="black" data-size="14"></i>
                                                Complete
                                            </a>
                                            @elseif($item['status']*1 == 2)
                                                Completed
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
        function  completeCompetition(id){
            confirmMsg('Do you sure this item  status competed !', function(){
                setTimeout(function(){
                    var param = new Object();
                    param._token = _token;
                    param.id = id;
                    param.status = 2;
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
    </script>

@stop

