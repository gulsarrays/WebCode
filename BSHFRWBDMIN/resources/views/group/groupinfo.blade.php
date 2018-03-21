@extends('layouts.default') 

@section('title')
	Users
@stop

@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>Groups of <?php echo isset($username)?$username:'---'; ?></h1>
		<ol class="breadcrumb">
			<li><a href="{{ URL::route('get:users','asc') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Groups</li>
		</ol>
	</section>
	<section class="content">
		<div class="box box-info">
			@include('includes.messages')
			<div class="box-header with-border">
			<div class="col-md-4">
				<div class="col-md-3"><label class="label-name">Sort By</label></div>
				<div class="col-md-9">
                    <div class="has-feedback">
                        <select name="sort" class="form-control text_box" id="sort-group_by_id">
                            <option @if($sort == 'asc') selected @endif value="asc">Name Ascending</option>
                            <option @if($sort == 'desc') selected @endif value="desc">Name Descending</option>
                        </select>
                        <input type="hidden" value="{{ $groupid }}" name="groupid" id="groupid">
                         <span class="fa fa-angle-down form-control-feedback"></span>
                    </div>
				</div>
			</div>
			<a class="fa fa-refresh text-green pull-right" data-toggle="tooltip" title="Reset" href="{{ URL::route('get:group',$groupid,'asc') }}"></a>
              <div class="col-md-4 pull-right">
                <div class="has-feedback">
                  {!! Form::open(['id' => 'search-group-by-id','method'=>'get']) !!}
                  <input type="text" name="search" class="form-control input-sm text_box" placeholder="Search Group" id="search" value="{{ $search }}">
                  <button type="submit" class="glyphicon glyphicon-search form-control-feedback"></button>
                  {!!Form::close()!!}
                </div>
              </div>
              <div class="clearfix"></div>
              <!-- /.box-tools -->
            </div>
            {!! Form::open(['route' => 'post:login', 'id' => 'manage-datas']) !!}
			<div class="box-body">
				<table id="example1" class="table table-hover table-bordered">
					<thead>
						<tr>
							
							<th>Group Name</th>
							<th>Description</th>
							<th>Admin Name</th>	
							<th>Admin Mobile No</th>
							<th>Members</th>											
							<th class="text-center">Action</th>										
						</tr>
					</thead>
					<tbody>
					
				        @if (count($groups)>0 && !empty($groups))
    						@foreach ($groups as $group)
    						    <tr>
    								<td>{{ $group['name'] }}</td>
    								<td>{{ $group['description'] }}</td>
    								<td>{{ $username }}</td>
    								<td>{{ $group['admin'] }}</td>
    								<td><a href="{{url('group-details/'.$group->id)}}" target="_blank">{{ $group['member_count'] }}</td>
    								<td class="text-center">
    									<a
								class="btn btn-box-tool fa fa-comments-o text-green"
								data-toggle="tooltip" title="View"
								href="{{url('group-chat/'.$group->id)}}" target="_blank">
    								</td>
    							</tr>
    						@endforeach
    				    @else
    				        <tr><td colspan="10">No Records Found.</td></tr>
    				    @endif
					</tbody>
				</table>
			</div>
			{!!Form::close()!!}
			
		</div>
	</section>
</div>
@stop