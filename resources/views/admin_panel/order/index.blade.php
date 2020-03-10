@extends('admin_panel.layouts.master')

{{-- Web site Title --}}

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <h4 class="page-title">Orders</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}"> Dashboard</a>
        </li>
        <li class  ="breadcrumb-item active"><a href="#">Order Manage</a></li>
        <li class=" breadcrumb-item active active">Orders</li>
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
                    <h4 class="mt-0 header-title">Orders List</h4>
                    <form id = "searchForm" action = "{{url("admin/order")}}" method = "post">
                        <input type = "hidden" name = "_token" value = "{!! csrf_token() !!}"/>
                        <input type = "hidden" name = "page" value = "{{$pageParam['pageNo']}}"/>
                        <div class = "row ">
                            <div class = "col-sm-3 text-left">
                                <input class = "form-control searchInput" name = "search" placeholder="Search"  value = "{{$search}}"/>
                            </div>
                            <div class = "col-sm-3 text-left">
                                <input class = "form-control searchInput date-picker" data-date-format="YYYY-MM-DD" name = "start_date" placeholder="Start Date"  value = "{{$start_date}}"/>
                            </div>
                            <div class = "col-sm-3 text-left">
                                <input class = "form-control searchInput date-picker" data-date-format="YYYY-MM-DD" name = "end_date" placeholder="End Date"  value = "{{$end_date}}"/>
                            </div>
                            <div class = "col-sm-3 text-right">
                                <button  class="btn btn-responsive button-alignment btn-primary"  style="margin-bottom:7px;">Search</button>
                            </div>
                        </div>
                    </form>
                </div>    
                <div class="card-body ">
                        <table class="table table-bordered table-hover table-last-bottom">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Number</th>
                                <th>User Name</th>
                                <th>Order Time</th>
                                <th>Ticket Number</th>
                                <th>Status</th>
                                <th width="400px;" class = "hidden"></th>
                            </tr>
                            </thead>
                            <tbody >
                                @foreach($list as $key=>$item)
                                    <tr>
                                        <td>{{$key+1+$pageParam['startNumber']}}</td>
                                        <td>
                                            <a href="javascript:void(0);" onclick = "editItem('{{$item['id']}}')" > {{$item['order_number']}}</a>
                                        </td>
                                        <td>{{$item['user_name']}}</td>
                                        <td>{{$item['order_time']}}</td>
                                        <td>{{$item->getOrderDetailCount()}}</td>
                                        <td>{{getOrderStatusStr($item['status'])}}</td>
                                        <td class = "hidden">
                                            @if($item['status']*1 == "0")
                                            <a href="javascript:void(0);"  class="btn default btn-xs purple">
                                                <i class="livicon" data-name="pen" data-loop="true" data-color="#000" data-hovercolor="black" data-size="14"></i>
                                                Force Pay
                                            </a>
                                            @endif
                                            <a href="javascript:void(0);" onclick = "deleteItem('{{$item['id']}}')" class="btn default btn-xs black hidden">
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
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
    <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>

    <script>
        $(document).ready(function(){
            

        });
        $(".searchInput").change(function(){
            searchData(0);
        });
        function editItem(id){
            window.location.href = "{{url("admin/order/info")}}"+"/"+id;
        }
        
    </script>

@stop

