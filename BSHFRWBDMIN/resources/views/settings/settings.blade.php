@extends('layouts.default') 

@section('title')
	View-Settings
@stop

@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Settings</h1>
		<!-- <ol class="breadcrumb">
			<li><a href="{{url('/other/users')}}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Setting</li>
		</ol> -->
	</section>
	<section class="content">
		<div class="box box-info">
		<div class="box-header with-border">
		        @include('includes.messages')
				<h3 class="box-title">Manage Settings</h3>
				<a id="delete-all-broadcasts" class="btn btn-sm btn-info btn-flat pull-right margin-left10 deleteAll" data-href="{{url('settings/delete/')}}"><i class="fa fa-trash-o"></i> Delete Selected</a>
				<a href="{{ URL::route('get:add-settings',0) }}" class="btn btn-sm btn-info btn-flat pull-right "><i class="fa fa-plus"></i> Settings</a>
			</div>
		              
					<div class="box-body" >
						<table id="example1" class="table table-hover table-bordered ">
							<thead>
								<tr>
									<th>Domain </th>
									<th>Admin_User </th>
									<th>AWS Secret key</th>
									<th>AWS Access Key</th>
									<th>Bucket Name</th>
									<th>Mail login</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
						 @if(count($data))
							 @foreach ($data as $settings)
								<tr>
									
    								
									<td class="whitespace">{{ $settings ->domain }}</td>
									<td class="whitespace">{{ $settings ->admin_user}}</td>
									<td class="whitespace">{{ $settings ->secret_key }}</td>
									<td class="whitespace">{{ $settings ->access_key }}</td>
									<td class="whitespace">{{ $settings ->bucket_name }}</td>
									<td class="whitespace">{{ $settings ->mail_login }}</td>
									
									<td class="text-center whitespace">
                                       <a class="btn btn-box-tool fa fa-pencil text-green" data-toggle="tooltip" title="Edit" href="{{ URL::route('get:add-settings', $settings->id) }}"></a> 
            						   <a class="btn btn-box-tool fa fa-eye text-green" data-toggle="send message" title="View Settings" href="{{ URL::route('get:view-settings', $settings->id) }}"></a>
            						   <a class="btn btn-box-tool fa fa-trash text-yellow" data-toggle="modal" title="Delete"  data-target="#confirm-delete" data-href="{{ URL::route('get:delete-settings', $settings->id) }}"></a>
            						</td>
								</tr>
							@endforeach
    				    @else
    				        <tr><td colspan="10">No Records Found.</td></tr>
    				    @endif
							</tbody>
						</table>
						@include('includes.pagination', ['data' => $data])
					</div>
					<!-- /.box-body -->
		</div>
		<!-- /.box -->
		
	</section>
	<!-- /.content -->
	<!-- /.content -->
</div>
@stop
