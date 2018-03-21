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
				<h3 class="box-title">Total Admin Users: {{count($data)}} </h3>

				@permission('user-create')
					<h3><a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a></h3>
				@endpermission
			</div>
			<div class="box-body">

				<table id="example1" class="table table-bordered table-hover stuff_table">
					<thead>
					<tr>
						<th>No</th>
						<th>Name</th>
						<th>Email</th>
						<th>Mobile number</th>
						<th>Roles</th>
						<th class="text-center">Status</th>
						<th>Action</th>
					</tr>
					</thead>
                                        
					<?php $i=0; ?>

					@foreach ($data as $key => $user)
					<tr>
						<td>{{ ++$i }}</td>
						<td>{{ $user->username }}</td>
						<td>{{ $user->email }}</td>
						<td>{{ $user->mobile_number }}</td>
						<td>
							@if(!empty($user->roles))
								@foreach($user->roles as $v)
									<label class="label label-success">{{ $v->display_name }}</label>
								@endforeach
							@endif
						</td>
						@if($user->is_active == 1)
							<td class="text-center">
							 <span class="label label-success">Active</span>
							 </td>
							 @else
							 <td class="text-center">
							 <span class="label label-error">Inactive</span>
							</td>
						@endif
						<td>			
							<!-- <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>			 -->
							
							@permission('user-edit')
							<a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
							@endpermission
							
							@if(!$user->hasRole('super-admin'))
							@permission('user-delete')
									<a class="btn btn-danger" data-href="{{url('other/user/delete/'.$user->id)}}" data-toggle="modal" data-target="#confirm-delete">Delete</a>
				        	@endpermission
				        	@endif
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
                {'bSortable': false, 'aTargets': [6]},
                {"bSearchable": false, "aTargets": [6]}
            ],
            "dom": 'lfrtipB',
            "oLanguage": {
                "sSearch": "Filter"
             },
            "buttons": [
                {"extend": 'csv', "exportOptions": {"columns": [ 0, 1, 2, 3, 4, 5]} },
                {"extend": 'excel', "exportOptions": {"columns": [ 0, 1, 2, 3, 4, 5]} },
            ],
            "iDisplayLength": DefaultDisplayLength,        
        } );
    } );
</script>    
@endsection
