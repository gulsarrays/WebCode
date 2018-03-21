@extends('layouts.default')
@section('title') Audits @stop 

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Audits</h1>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                @include('includes.messages')
            </div>
            <div class="box-body">
                <h4>Total Audits :<span id='id_total_count'></span></h4>
                
<!--                <h3><a class="btn btn-success" href="{{ url('/audits/download/csv') }}"> Download Full CSV</a></h3>
                <h3><a class="btn btn-success" href="{{ url('/audits/download/xls') }}"> Download Full Excel</a></h3>-->
                
                <table id="listAudits" class="table table-bordered table-hover stuff_table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Change By</th>
                            <th>Module</th>
                            <th>Event</th><!-- 
                            <th>Changed Fields</th> -->
                            <th>Old values</th>
                            <th>New values</th>
                            <th>Modified Timings</th>
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
        $('#listAudits').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{url('audits-ajax')}}",
                "dataType": "json",
                "type": "POST",
                "data": {_token: "{{csrf_token()}}"},
                "deferLoading": 57
            },
            "columns": [
                {"data": "id"},
                {"data": "username"},
                {"data": "auditable_type"},
                {"data": "event"},
                {"data": "str_old_values"},
                {"data": "str_new_values"},
                {"data": "updated_at"}
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
                {"extend": 'csv', "exportOptions": {"columns": [0, 1, 2, 3, 4, 5, 6]}},
                {"extend": 'excel', "exportOptions": {"columns": [0, 1, 2, 3, 4, 5, 6]}},
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