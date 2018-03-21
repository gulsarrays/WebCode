@extends('layouts.admin') @section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>{{trans('common.user.profile')}}</h1>
		<ol class="breadcrumb">
			<li><a href="{{url('/admin')}}"><i class="fa fa-dashboard"></i>
					{{trans('common.menu.home')}}</a></li>
			<li class="active">{{trans('common.user.profile')}}</li>
		</ol>
	</section>
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">{{trans('common.user.profile')}}</h3>
			</div>
			<div class="box-body">
				@include('includes.messages') @if(!empty($user) && count($user)>0)
				<table id="example1" class="table table-hover">
					<tbody>

						<tr>
							<td>{{trans('common.user.name')}}</td>
							<td>{{ucfirst($user->name)}}</td>
						</tr>
						<tr>
							<td>{{trans('common.user.email')}}</td>
							<td>{{$user->email}}</td>
						</tr>
						<tr>
							<td>{{trans('common.user.status')}}</td>
							<td>{{(!empty($user->is_active)?trans('common.user.active'):trans('common.user.in_active'))}}</td>
						</tr>
						@if(!empty($user->image) && substr_count($user->image,'/uploads/')>0)
						<td>{{trans('common.user.image')}}</td>
						<td><img alt="{{$user->name}}" src="{{$user->image}}" width="100px" height="100px">
						</td>
						
						@endif
						<tr>
							<td><button class='btn btn-default btn-flat cancel_btn'>{{trans('common.user.back')}}</button></td>
						</tr>
					</tbody>
				</table>

				@else {{trans('admin.no_records')}} @endif
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
	<!-- /.content -->
</div>
@stop
