@extends('admin_panel.layouts.master')
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
{{-- Page title --}}
@section('title')
Users List
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('breadcrumb')
    <h4 class="page-title">Users</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}"> Dashboard</a>
        </li>
        <li class  ="breadcrumb-item active"><a href="#"> Users</a></li>
        <li class=" breadcrumb-item active active">Users List</li>
    </ol>
@endsection

@section('content')
<!-- Main content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title"> Users List</h4>
                </div>
                <br />
                <div class="card-body">
                    <div class = "form-group row">
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-responsive button-alignment btn-primary" onclick = "exportTableUserToCSV()" style="margin-bottom:7px;" data-toggle="button">CSV</button>
                        </div>
                        <div class="col-lg-4">
                            <label class="control-label inline-block"> Show only:
                                <select name = "show_only" class = "form-control inline-block" style = "width:200px;">
                                    <option value = "">All</option>
                                    <option value = "1">Admin</option>
                                    <option value = "2">User</option>
                                </select>
                            </label>
                        </div>
                    </div>    
                </div>
                <div class="card-body">
                <table class="table table-bordered nowrap" id="table">
                    <thead>
                        <tr class="filters">
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>User E-mail</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>    <!-- row-->
</div>
<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>
@stop

{{-- page level scripts --}}
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
    
    
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script>
    $(document).ready(function() {
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('admin.users.data') !!}',
                data: function (d) {
                    d.show_only = $("select[name='show_only']").val();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'first_name', name: 'first_name' },
                { data: 'last_name', name: 'last_name' },
                { data: 'email', name: 'email' },
                { data: 'status', name: 'status'},
                { data: 'created_at', name:'created_at'},
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
        table.on( 'draw', function () {
            /*$('.livicon').each(function(){
                $(this).updateLivicon();
            });*/
        } );

        $("select[name='show_only']").change(function () {
            show_only = $(this).val();
            table.draw();
        });
    });


    function exportTableUserToCSV(filename) {
        if(filename == undefined || filename == ''){
            filename = 'export-data.csv';
        }
        var csv = [];
        var rows = document.querySelectorAll("table tr");

        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < 7; j++){
                row.push(cols[j].innerText.replace(",",""));
            }
            if(i==0){
                row.push("top seller");
            }else{
                var top_seller = false;
                var innerText = cols[1];
                innerText = $(innerText).html();
                if(innerText.indexOf("blue")>-1){
                    top_seller = true;
                }
                if(top_seller){
                    row.push("top seller");
                }else{
                    row.push("");
                }

            }

            csv.push(row.join(","));
        }
        downloadCSV(csv.join("\n"), filename);
    }

</script>


<script>
$(function () {
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
});
</script>
@stop
