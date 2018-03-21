@extends('layouts.default') 
@section('title')
	Users
@stop
@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>View Users</h1>
		<ol class="breadcrumb">
			<li><a href="{{ URL::route('get:users','asc') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">View Users</li>
		</ol>
	</section>
	
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
			 @include('includes.messages')
			<div class="col-md-4">
				<div class="col-md-3"><label class="label-name">Sort By</label></div>
				<div class="col-md-9">
                    <div class="has-feedback">
                        <select name="sort" class="form-control text_box" id="sort">
                            <option @if($sort == 'asc') selected @endif value="asc">Name Ascending</option>
                            <option @if($sort == 'desc') selected @endif value="desc">Name Descending</option>
                        </select>
                         <span class="fa fa-angle-down form-control-feedback"></span>
                    </div>
				</div>
			</div>
				<a class="fa fa-refresh text-green pull-right" data-toggle="tooltip" title="Reset" href="{{ URL::route('get:users','asc') }}"></a>
              <div class="col-md-4 pull-right">
                <div class="has-feedback">
                  {!! Form::open(['id' => 'searchuser','method'=>'get']) !!}
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
							<th>Name</th>
							<th class="text-center">Image</th>
							<th>Status</th>
							<th>Mobile</th>	
							<th class="text-center">Contacts</th>
							<th class="text-center">Groups</th>								
						</tr>
					</thead>
					<tbody>
				        @if (count($users))
    						@foreach ($users as $user)
    						    <tr>
    								<td>{!! $user->decryptnameEmoji() !!}</td>
    								<td class="text-center"><img alt="{!! $user->decryptnameEmoji() !!}" src="{{ $user->image() }}"></td>
    								<td>{!! $user->decryptEmoji() !!}</td>
    								<td>{{ $user->mobile_number }}</td>
    								<td class="text-center">
    									<a class="btn btn-box-tool fa fa-list-ul text-green text-green"
								        data-toggle="tooltip" title="View" href="{{URL::route('get:contacts',[$user->username])}}" target="_self"> </td>
								    <td class="text-center"><a class="btn btn-box-tool fa fa-users text-green text-green"
								        data-toggle="tooltip" title="View"
								            href="{{URL::route('get:group',[$user->username])}}" target="_self"></td>
    							</tr>
    						@endforeach
    				    @else
    				        <tr><td colspan="10">No Records Found.</td></tr>
    				    @endif
					</tbody>
				</table>
			</div>
			{!!Form::close()!!}
			@if (count($users))
				@include('includes.pagination', ['data' => $users])
			@endif
		</div>
	</section>
</div>
@stop
