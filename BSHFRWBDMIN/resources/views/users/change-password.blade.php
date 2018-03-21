@extends('layouts.default')

@section('content')
		<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>{{trans('common.change-password.change-password')}}</h1>
		<!-- <ol class="breadcrumb">
		@if(auth()->user()->user_type==1)
			<li><a href="{{url('/other/users')}}"><i class="fa fa-dashboard"></i>{{trans('common.menu.home')}}</a></li>
		@else	
		    <li><a href="{{url('users/asc')}}"><i class="fa fa-dashboard"></i>{{trans('common.menu.home')}}</a></li>
		@endif
			<li class="active">{{trans('common.change-password.change-password')}}</li>
		</ol> -->
	</section>
	<section class="content">
		<div class="box box-info">
			<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						@include('includes.messages')
						<!-- Custom Tabs -->
						{!!
						Form::open(['url'=>'user/change-password','method'=>'POST','role'=>'form','class'=>'col-md-12
						box-body changepassword-form'])!!}
						<div class="col-md-8">
							<div class="form-group company-start">
								<div class="col-md-6">
									<label class="label-name">{{trans('common.change-password.old-password')}}</label>
								</div>
								<div class="col-md-6">
									{!!Form::password('password',['class'=>'form-control text_box required'])!!}
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6">
									<label class="label-name">{{trans('common.change-password.new-password')}}</label>
								</div>
								<div class="col-md-6">
									{!!Form::password('newpassword',['class'=>'form-control text_box required','id'=>'newpassword'])!!}
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6">
									<label class="label-name">{{trans('common.change-password.confirm-password')}}</label>
								</div>
								<div class="col-md-6">
									{!!Form::password('confirmpassword',['class'=>'form-control text_box required'])!!}
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="col-md-4">&nbsp;</div>
							<div class="col-md-8">
								<button type="submit" class="btn  bg-green btn-flat mar-right">{{trans('common.user.update')}}</button>
								<a class="btn btn-default btn-flat btn-rad-sm btn-org mar-top" href="{{url('/other/users')}}">{{trans('common.user.back')}}</a>								
							</div>
						</div>
						{!! Form::close() !!}
						<!-- nav-tabs-custom -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->

			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</section>
</div>
@stop