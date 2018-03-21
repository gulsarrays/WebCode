@extends('layouts.default') 

@section('title')
	Users
@stop

@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>Contacts of <?php echo isset($username)?$username:'---';?></h1>
		<ol class="breadcrumb">
			<li><a href="{{ URL::route('get:users','asc') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Contacts</li>
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
			<div class="box-header with-border">
			<div class="col-md-4">
			<input type="hidden" value="{{$userid}}" id="user-id">
				<!-- <div class="col-md-3"><label>Sort By</label></div>
				<div class="col-md-9">
                    <div class="has-feedback">
                    
                        <select name="sort" class="form-control text_box" id="contact-sort">
                            <option @if($sort == 'asc') selected @endif value="asc">Name Ascending</option>
                            <option @if($sort == 'desc') selected @endif value="desc">Name Descending</option>
                        </select>
                         <span class="glyphicon glyphicon-triangle-bottom form-control-feedback"></span>
                    </div>
				</div> -->
			</div>
              <a class="fa fa-refresh text-green pull-right" data-toggle="tooltip" title="Reset" href="{{ URL::route('get:users','asc') }}"></a>
               <div class="col-md-4 pull-right">
                <div class="has-feedback">
                  {!! Form::open(['id' => 'search-contact','method'=>'get']) !!}
                  <input type="text" name="search" class="form-control input-sm text_box" placeholder="Search User" id="search" value="{{ $search }}">
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
							<th class="text-center">Image</th>
							<th>Name</th>
							<th>Mobile</th>
							<th class="text-center">Action</th>										
						</tr>
					</thead>
					<tbody>
				        @if (count($users)>0)
    						@foreach ($users as $user)
    						
    						    <tr>
    								<td class="text-center"><img alt="{{ $user['name'] }}" src="@if(isset($user['image'])&&($user['image']!=''))
    						{{ $image=$user['image']}}
    						@else
                            {{$image=URL::asset('assets/img/default_large.png') }}
                            @endif"></td>
    								<td>{{ isset($user['name'])?$user['name']:'---' }}</td>
    								<td>{{ $user['mobile_number'] }}</td>
    								<td class="text-center">
    							<a
								class="btn btn-box-tool fa fa-comments-o text-green"
								data-toggle="tooltip" title="View"
								href="{{URL::route('get:conversation',[$userid, $user['username']])}}" target="_self">
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
			@include('includes.pagination', ['data' => $users])
		</div>
	</section>
</div>
@stop
