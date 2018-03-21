@extends('layouts.default') 

@section('title')
	Users
@stop

@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>Groups</h1>
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
                        <select name="sort" class="form-control text_box" id="sort-group">
                            <option @if($sort == 'asc') selected @endif value="asc">Name Ascending</option>
                            <option @if($sort == 'desc') selected @endif value="desc">Name Descending</option>
                        </select>
                         <span class="fa fa-angle-down form-control-feedback"></span>
                    </div>
				</div>
			</div>
			<a class="fa fa-refresh text-green pull-right" data-toggle="tooltip" title="Reset" href="{{ URL::route('get:groups','asc') }}"></a>
              <div class="col-md-4 pull-right">
                <div class="has-feedback">
                  {!! Form::open(['id' => 'search-group','method'=>'get']) !!}
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
							<th class="text-center">Group Image</th>
							<th class="text-center">Total Members</th>									
							<th class="text-center">Action</th>										
						</tr>
					</thead>
					<tbody>
						<?php $i = 0; ?>
				        @if (count($groups))
				           {{--*/  $i ='0' /*--}}
    						@foreach ($groups as $group)
    						    <tr>
    								<td>{{ $group->name }}</td>
    								<td class="text-center"><img alt="{{ $group->name }}" src="@if(isset($group->image)&&($group->image!=''))
    						{{ $image=$group->image}}
    						@else
                            {{$image=URL::asset('assets/img/default_large.png') }}
                            @endif"></td>
    								<td class="text-center"><a href="{{url('group-details/'.$group->username.'/asc')}}" target="_self">{{$memberscount[$i]}}</a></td>
    								<td class="text-center">
    									<a
								class="btn btn-box-tool fa fa-eye text-green"
								data-toggle="tooltip" title="View"
								href="{{url('group-details/'.$group->username.'/asc')}}" target="_self">
    								</td>
    							</tr>
    							{{--*/  $i++ /*--}}
    							<?php $i++; ?>
    						@endforeach
    				    @else
    				        <tr><td colspan="10">No Records Found.</td></tr>
    				    @endif
					</tbody>
				</table>
			</div>
			{!!Form::close()!!}
			@include('includes.pagination', ['data' => $groups])
		</div>
	</section>
</div>
@stop
