@extends('layouts.default')
@section('title')
AgeGroups
@stop
@section('content')

<div class="content-wrapper" style="min-height: 440px;">		
	<section class="content-header">
		<h1>Age Group List</h1>
	</section>

	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				@include('includes.messages')
					<h3 class="box-title">Total Age Groups: {{ count($ageGroups) }}</h3>
				<h3><a href="{{ url('others/createagegroup') }}" class="btn btn-success"><i class="fa fa-plus"></i>Add Age Group</a></h3>
			</div>
						
			
			<div class="box-body">
    			
				<input id="total_data_count" name="totalcount" type="hidden" value="">
				<table id="example1" class="table table-bordered table-hover stuff_table">
					<thead>
                        <tr>
                            <th>No</th>
                            <th>Age Range</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1?>
                    	@foreach($ageGroups as $ageGroup)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$ageGroup['ageGroupDescription']}}</td>
                                <td class="text-center">
                                	@if($ageGroup['isactive'] == 1)
									<span class="label label-success">Active</span>
									@else
									<span class="label label-error">Inactive</span>
									@endif										
								</td>
								<td class="text-center">
									<a
									class="btn btn-box-tool fa fa-pencil text-aqua"
									data-toggle="tooltip" title="Edit"
									href="{{url('others/ageGroup/edit').'/'.$ageGroup['ageGroupId']}}"></a>
									<!-- <a
									class="btn btn-box-tool fa fa-trash text-yellow"
									data-toggle="modal" data-target="#confirm-delete" title="Delete"										
									data-href="{{url('others/ageGroup/delete').'/'.$ageGroup['ageGroupId']}}"></a> -->
								</td>
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
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [3]},
                {"bSearchable": false, "aTargets": [3]}
            ],
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