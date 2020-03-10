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
        <li class  ="breadcrumb-item "><a href="#">PAST WINNERS</a></li>
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
                    <form id = "searchForm" action = "{{url("admin/past")}}" method = "post">
                    <input type = "hidden" name = "_token" value = "{!! csrf_token() !!}"/>
                    <input type = "hidden" name = "page" value = "{{$pageParam['pageNo']}}"/>
                    <div class = "row">
                        <div class = "col-sm-3 text-left">
                            <input class = "form-control searchInput" name = "search" placeholder="Search"  value = "{{$search}}"/>
                        </div>
                        <div class = "col-sm-9 text-right">
                            <a href="{{url("admin/past/info")}}/0" class="btn btn-responsive button-alignment btn-primary"  style="margin-bottom:7px;">Add</a>
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
                                <th>Photo</th>
                                <th>Draw Video Link</th>
                                <th>Delivery Video Link</th>
                                <th>Winner Username</th>
                                <th>Ticket Number</th>
                                <th width="300px;"></th>
                            </tr>
                            </thead>
                            <tbody >
                                @foreach($list as $key=>$item)
                                    <tr>
                                        <td>{{$key+1+$pageParam['startNumber']}}</td>
                                        <td>{{$item['name']}}</td>
                                        <td>
                                            @if($item['photo'] != '')
                                                <img src = "{{correctImgPath1($item['photo'])}}" style = "width:80px;"/>
                                            @endif    
                                        </td>
                                        <td>{{$item->draw_video_url}}</td>
                                        <td>{{$item->delivery_video_ur1}}</td>
                                        <td>{{$item->winner_user_name}}</td>
                                        <td>{{$item->ticket_number}}</td>
                                        <td>
                                            <a href="{{url("admin/past/info/".$item['id'])}}"  class="btn default-primary btn-xs ">
                                                <i class="livicon" data-name="pen" data-loop="true" data-color="#000" data-hovercolor="black" data-size="14"></i>
                                                Edit
                                            </a>
                                            <a href="javascript:void(0)" onclick = "deleteItem('{{$item['id']}}')"  class="btn default-primary btn-xs purple">
                                                <i class="livicon" data-name="trash" data-loop="true" data-color="#000" data-hovercolor="black" data-size="14"></i>
                                                Delete
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
        function deleteItem(id){
            confirmMsg("Do you sure delete this item?", function(){
                window.location.href = "{{url("admin/past/ajaxDeleteInfo")}}/"+id;
            })
        }
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

