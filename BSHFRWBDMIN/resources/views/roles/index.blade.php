@extends('layouts.default')
@section('title') Roles @stop

@section('content')
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
	<div class="content-wrapper" style="min-height: 678px;">
		<section class="content-header">
			<h1>Roles and Permissions</h1>
			<!-- <ol class="breadcrumb">
				<li><a href="{{url('/other/users')}}"><i class="fa fa-dashboard"></i>
						{{trans('common.menu.home')}}</a></li>
				<li class="active">Roles</li>
			</ol> -->
		</section>

		<section class="content">
			<div class="box box-info">
			<div class="box-header with-border">
				@include('includes.messages')
				<!-- <h2>Role Management</h2> -->
				@permission('role-create')
	            	<a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
	            @endpermission
			</div>
			<div class="box-body">
			
				<table class="table table-bordered" id='example1'>
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Description</th>
							<th width="280px">Action</th>
						</tr>
					</thead>
<?php
$i=0;
?>
					@foreach ($roles as $key => $role)
						<tr>
							<td>{{ ++$i }}</td>
							<td>{{ $role->display_name }}</td>
							<td>{{ $role->description }}</td>
							<td>
								<!-- <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a> -->
								@permission('role-edit')
								<a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
								@endpermission
								@permission('role-delete')
									<a class="btn btn-danger" data-href="{{route('roles.destroy',$role->id)}}" data-toggle="modal" data-target="#confirm-delete">Delete</a>
					        	@endpermission
							</td>
						</tr>
					@endforeach
				</table>
				

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
@endsection
