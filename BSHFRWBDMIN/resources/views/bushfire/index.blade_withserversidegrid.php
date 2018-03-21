@extends('layouts.default')
@section('title') Web Admins @stop 

@section('content')

<div class="content-wrapper" style="min-height: 678px;">
    <section class="content-header">
        <h1>Web Admins</h1>
    </section>

    <section class="content">
        <style type="text/css">
            .modal-body.channelbody{
                height: 400px;
                overflow: auto;
            }
            .modal-content.channelContent{
                width: 60% !important;
                margin-top: 0 !important;
            }
            .modal-dialog{
                position: relative !important;
                width: auto !important;
            }
            .thead{
                background-color: #d2d6de;
            }
        </style>
        <div class="box box-info">
            <div class="box-header with-border">
                @include('includes.messages')
                <h3 class="box-title">Total Admin Users: <span id='id_total_count'></span></h3>

                @permission('user-create')
                <h3><a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a></h3> 
<!--                <h3><a class="btn btn-success" href="{{ url('other/users/download/csv') }}"> Download Full CSV</a></h3>
                <h3><a class="btn btn-success" href="{{ url('other/users/download/xls') }}"> Download Full Excel</a></h3>-->
                @endpermission
            </div>
            <div class="box-body">

                <table id="example1" class="table table-bordered table-hover stuff_table">
                    <thead>
                        <tr>
                            <th class="width30 text-center">No</th>
                            <th class="width50 text-center">Name</th>
                            <th class="width50 text-center">Email</th>
                            <th class="width50 text-center">Mobile number</th>
                            <th class="width100 text-center">Roles</th>
                            <th class="width50 text-center">Status</th>
                            <th class="width200 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td colspan="7" height="100px"></td></tr>
                    </tbody>
                </table>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
</div>
<script>
    $(document).ready(function () {
        $('#example1').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{url('other/usersajax/')}}",
                "dataType": "json",
                "type": "POST",
                "data": {_token: "{{csrf_token()}}"},
                "deferLoading": 57
            },
            "columns": [
                {"data": "id"},
                {"data": "username"},
                {"data": "email"},
                {"data": "mobile_number"},
                {"data": "user_type"},
                {"data": "is_active"},
                {"data": "options"}
            ],
            "bFilter": true,
            "lengthMenu": lengthMenu,
            "responsive": true,
            "order": [[0, 'asc']],
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [6]},
                {"bSearchable": false, "aTargets": [6]}
            ],
//            "scrollY": 200,
//            "scroller": {
//                "loadingIndicator": true
//            },
//            "dom": 'lfrtipBS',
            "dom": 'lfrtipB',
            "oLanguage": {
                "sSearch": "Filter",
                "sProcessing": "<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate gi-2x'></span>"
            },
            "buttons": [
                {"extend": 'csv', "exportOptions": {"columns": [0, 1, 2, 3, 4, 5]}},
                {"extend": 'excel', "exportOptions": {"columns": [0, 1, 2, 3, 4, 5]}},
            ],
            "iDisplayLength": DefaultDisplayLength,
            "fnInitComplete": function (aData)
            {
//                console.log(aData['json']);
                $('#id_total_count').text(aData['json']['recordsTotal']);
            }
        });
    });
</script>

@endsection
