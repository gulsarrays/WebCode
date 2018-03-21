@extends('layouts.default')
@section('title')
Gender
@stop
@section('content')
<div class="content-wrapper" style="min-height: 440px;">
	<section class="content-header">
			<h1>Gender List</h1>
		</section>

		<section class="content">
			<div class="box box-info">
				<div class="box-header with-border">
					@include('includes.messages')
					<!-- <h3 class="box-title">Gender</h3> -->
				</div>

				<div class="box-body">
	    			
					<input id="total_data_count" name="totalcount" type="hidden" value="3">
					<table id="example1" class="table table-bordered table-hover stuff_table">
						<thead>
	                        <tr>
	                            <th>No</th>
	                            <th>Genders</th>
	                            <th class="text-center">Status</th>
	                            <!-- <th class="text-center">Action</th> -->
	                        </tr>
	                    </thead>
	                    <tbody><?php $i=0; ?>
	                    	@foreach($genders as $gender)
	                    	<tr>
	                            <td>{{ ++$i }}</td>
	                            <td>{{ $gender['genderName'] }}</td>
	                            <td class="text-center">
							 		<span class="label label-success">Active</span>
							 	</td>
								<!--  <td class="text-center">
									<a class="btn btn-box-tool fa fa-pencil text-aqua" data-toggle="tooltip" title=""  data-original-title="Edit"></a> <a class="btn btn-box-tool fa fa-trash text-yellow" data-toggle="modal" data-target="#confirm-delete" title="Delete" data-href="http://bushfiresuperadmin.app/staff/delete/23">
									</a>
								</td> -->
	                        </tr>
	                    	@endforeach
	                    </tbody>
					</table>
					<div class="pagination clearfix">
					    <input type="hidden" name="page" id="page" value="">
					</div>
	 			</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</section>
</div>
<script>
    $(document).ready(function() {
        $('#example1').DataTable( {
            "bFilter": true,
            "lengthMenu": lengthMenu,
            "responsive": true,
            "order": [[0, 'asc']],
//            "aoColumnDefs": [
//                {'bSortable': false, 'aTargets': [2]},
//                {"bSearchable": false, "aTargets": [2]}
//            ],
            "dom": 'lfrtipB',
            "oLanguage": {
                "sSearch": "Filter"
             },
            "buttons": [
                {"extend": 'csv', "exportOptions": {"columns": [ 0, 1, 2]} },
                {"extend": 'excel', "exportOptions": {"columns": [ 0, 1, 2]} },
            ],
            "iDisplayLength": DefaultDisplayLength,        
        } );
    } );
</script>
@stop