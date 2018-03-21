@extends('layouts.default') 

@section('title')
	Users
@stop

@section('content')

<div class="content-wrapper">
	<section class="content-header">
		<h1>Group Info of <?php echo isset( $groups[0]['name'] )?$groups[0]['name']:'---';?></h1>
		<ol class="breadcrumb">
			<li><a href="{{ URL::route('get:users','asc') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Group Info</li>
		</ol>
	</section>
	<section class="content">
		<div class="box box-info">
			<!-- <div class="box-header with-border">
				<h3 class="box-title">Manage Users</h3>
				<a href="{{ URL::route('get:users','asc') }}" id="exportall" class="btn btn-sm btn-info btn-flat pull-right  margin-left10 ">Export All</a>
				<a id="deleteall" class="btn btn-sm btn-info btn-flat pull-right"><i class="fa fa-trash-o"></i>Delete Selected</a>
			</div> -->
			@include('includes.messages')
				
				<div class="box-header with-border" >
				<div class="col-md-6">
					<h3 class="box-title">Group Info</h3>
				</div>

				</div>
			
			<div class="box-body">
				<div class="col-md-12">
					<div class="col-md-6">
						<div class="col-md-5">
						                                                           @if (empty($groups[0]['image']))
                                                                <img class="grp_img" alt="{{ $groups[0]['image'] }}" src="{{ URL::asset('assets/img/default.png') }}" >
                                                        @else
                                                                <img alt="{{ $groups[0]['image'] }}" src="{{ $groups[0]['image']}}" class="grp_img">
                                                        @endif
							</div>
						<div class="col-md-7">
							<div class="form-group">
								<div class="col-md-6">
									<label class="bold strong">Group Name</label>
								</div>
								<div class="col-md-6">
									<span class="admin_name">{{ isset($groups[0]['name'])?$groups[0]['name']:'---' }}</span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6">
									<label class="bold strong">Members</label>
								</div>
								<div class="col-md-6">
									<span class="admin_name">{{ count($contact) }}</span>
								</div>
								<div class="col-md-6">
									
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6">
									<label class="bold strong">Chat History</label>
								</div>
								<div class="col-md-6">
									<a class="btn btn-box-tool fa fa-comments-o" data-toggle="tooltip" title="View" href="{{url('group-chat/'.$groups[0]['username'])}}"></a>
								</div>
							</div>
							
						</div>
					</div>
					
						
				</div>
			</div>	
		
		
		<div class="box box-info">
						
				<div class="box-header with-border">
					<h3 class="box-title">List of users</h3>
				</div>
			
			<div class="box-body">
				<div class="col-md-12">
				<div class="col-md-4">
				
			   </div>
				 
					<table id="example1" class="table table-hover table-bordered">
						<thead>
							<tr>
								<th class="text-center">Image</th>
								<th>Name</th>
								<th>Contact</th>
							</tr>
						</thead>
						<tbody>
					        @if (count($contact))
					        
					        @foreach($contact as $user)
	    						    <tr>
	    								<td  class="text-center"><img alt="{{ $user['name'] }}" src="@if(isset($user['image'])&&($user['image']!=''))
    						{{ $image=$user['image']}}
    						@else
                            {{$image=URL::asset('assets/img/default_large.png') }}
                            @endif"></td>
	    								<td>{{ isset($user['name'])?$user['name']:'---' }}</td>
	    								<td>{{ isset($user['mobile_number'])?$user['mobile_number']:'---' }}</td>
	    								
	    							</tr>
	    							
	    					@endforeach
	    				    @else
	    				        <tr><td colspan="10">No Records Found.</td></tr>
	    				    @endif
						</tbody>
					</table>
				</div>	
			</div>
			
			
						
				</div>
		</section>
</div>
@stop
