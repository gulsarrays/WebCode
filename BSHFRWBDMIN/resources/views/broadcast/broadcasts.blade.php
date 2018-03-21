@extends('layouts.default') 

@section('title')
	AR-Triggers
@stop

@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Broadcast</h1>
		<ol class="breadcrumb">
			<li><a href="{{ URL::route('get:users','asc') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Broadcast</li>
		</ol>
	</section>
	<section class="content">
		<div class="box box-info">
		<div class="box-header with-border">
		        @include('includes.messages')
				<h3 class="box-title">Manage Broadcast</h3>
				<a id="delete-all-broadcasts" class="btn btn-sm btn-info btn-flat pull-right margin-left10 deleteAll" data-href="{{url('broadcast/delete/')}}"><i class="fa fa-trash-o"></i> Delete Selected</a>
				<a href="{{ URL::route('get:add-broadcast',0) }}" class="btn btn-sm btn-info btn-flat pull-right "><i class="fa fa-plus"></i> Broadcast</a>
			</div>
					<div class="box-body" >
						<table id="example1" class="table table-hover table-bordered ">
							<thead>
								<tr>
									<th class="text-center">
									{!!Form::checkbox('checkall','1',false,['class'=>'multiselectall'])!!}</th>
									<th>Title</th>
									<th>Message</th>	
									<th>Type</th>	
									<th>Date/Time</th>
									<th class="text-center">Action</th>
									
								</tr>
							</thead>
							<tbody>
						 @if(count($broadcasts))
							 @foreach ($broadcasts as $broadcast)
								<tr>
									<td class="text-center">
    								   {!!Form::checkbox('ids[]',$broadcast->id,false,['class'=>'multiselect'])!!}
    								</td>
    								<td>{{ $broadcast->title }}</td>
									<td>{{ $broadcast -> message }}</td>
									<td>{{ $broadcast -> type }}</td>
									<td class="whitespace">{{ $broadcast -> created_at }}</td>
									<!-- <td>
            						  @if($broadcast->is_active)
            						      <span class="label label-success">Pending</span>
            						  @else
            						      <span class="label label-success">Sent</span>
            						  @endif -->
            						<td class="text-center whitespace">
            							 <a class="btn btn-box-tool fa fa-pencil text-green"
            							data-toggle="tooltip" title="View" href="{{ URL::route('get:add-broadcast', $broadcast->id) }}"></a> 
            							<a class="btn btn-box-tool fa fa-trash text-yellow"
            							data-toggle="modal" title="Action"  data-target="#confirm-delete" data-href="{{ URL::route('get:delete-broadcast', $broadcast->id) }}"></a>
            							<a class="btn btn-box-tool fa fa-bell-o text-green" data-toggle="send message" title="Resend" href="{{ URL::route('get:resend-broadcast', $broadcast->id) }}"></a>
            						</td>  
									
								</tr>
							@endforeach
    				    @else
    				        <tr><td colspan="10">No Records Found.</td></tr>
    				    @endif
							</tbody>
						</table>
						@include('includes.pagination', ['data' => $broadcasts])
					</div>
					<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
	<!-- /.content -->
</div>
@stop
