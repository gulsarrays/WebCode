@extends('layouts.default')
 
@section('content')
	<div class="content-wrapper" style="min-height: 678px;">
		<section class="content-header">
			<h1>Permissions</h1>
			<ol class="breadcrumb">
				<li><a href="{{url('/other/users')}}"><i class="fa fa-dashboard"></i>
						{{trans('common.menu.home')}}</a></li>
				<li class="active">Permissions</li>
			</ol>
		</section>

		<section class="content">
			
		<div class="box box-info">
			<div class="box-header with-border">
				@include('includes.messages')
				<h2>Permissions Management</h2>
	            @permission('permission-create')
	            	<a class="btn btn-success" href="{{ route('permission.create') }}"> Create New Permission</a>
	            @endpermission
			</div>
			<div class="box-body">

				<table class="table table-bordered">
					<tr>
						<th>No</th>
						<th>Name</th>
						<th>Description</th>
						<th width="280px">Action</th>
					</tr>
					@foreach ($permissions as $key => $permission)
					<tr>
						<td>{{ ++$i }}</td>
						<td>{{ $permission->display_name }}</td>
						<td>{{ $permission->description }}</td>
						<td>
							<a class="btn btn-info" href="{{ route('permission.show',$permission->id) }}">Show</a>
							<!-- @permission('permission-edit')
							<a class="btn btn-primary" href="{{ route('permission.edit',$permission->id) }}">Edit</a>
							@endpermission
							@permission('permission-delete')
							{!! Form::open(['method' => 'DELETE','route' => ['permission.destroy', $permission->id],'style'=>'display:inline']) !!}
				            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
				        	{!! Form::close() !!}
				        	@endpermission -->
						</td>
					</tr>
					@endforeach
				</table>
				{!! $permissions->render() !!}
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
		</section>
	</div>
@endsection