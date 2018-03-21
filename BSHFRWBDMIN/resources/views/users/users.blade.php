@extends('layouts.default') 
@section('title')
Users
@stop
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>App Users</h1>
        <!-- <ol class="breadcrumb">
                <li><a href="{{url('/other/users')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">App Users</li>
        </ol> -->
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                @include('includes.messages')
                <h3 class="box-title">Total Bushfire App users : <span id='id_total_count'></span></h3>

<!--                <h3><a class="btn btn-success" href="{{ url('app-users/download/csv') }}"> Download Full CSV</a></h3>
                <h3><a class="btn btn-success" href="{{ url('app-users/download/xls') }}"> Download Full Excel</a></h3>-->

            </div>

            <div class="box-body">

                <table id="example1" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Mobile number</th>
                            <th>Status</th>
                            <!-- <th>Action</th> -->						
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td colspan="7" height="100px"></td></tr>
                    </tbody>
                </table>
            </div>


        </div>
    </section>
</div>

<script>
    $(document).ready(function () {
        $('#example1').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{url('app-users-ajax')}}",
                "dataType": "json",
                "type": "POST",
                "data": {_token: "{{csrf_token()}}"},
                "deferLoading": 57
            },
            "columns": [
                {"data": "id"},
                {"data": "username"},
                {"data": "mobile_number"},
                {"data": "is_active"}
            ],
            "bFilter": true,
            "lengthMenu": lengthMenu,
            "responsive": true,
            "order": [[0, 'desc']],
//            "aoColumnDefs": [
//                {'bSortable': false, 'aTargets': [6]},
//                {"bSearchable": false, "aTargets": [6]}
//            ],
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
                {"extend": 'csv', "exportOptions": {"columns": [0, 1, 2, 3]}},
                {"extend": 'excel', "exportOptions": {"columns": [0, 1, 2, 3]}},
            ],
            "iDisplayLength": DefaultDisplayLength,
            "fnInitComplete": function (aData)
            {
                console.log(aData['json']);
                $('#id_total_count').text(aData['json']['recordsTotal']);
            }
        });
    });
</script>
@stop
