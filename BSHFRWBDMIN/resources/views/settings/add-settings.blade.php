@extends('layouts.default') 

@section('title')
	Add-Settings
@stop

@section('content')
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>General Settings</h1>
				<!-- <ol class="breadcrumb">
					<li><a href="{{url('/other/users')}}"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">{!! isset($data)?$data['title']:'Add Settings' !!}</li>
				</ol> -->
			</section>
			<section class="content">
				<div class="box box-info">
					<div class="box-header with-border">
						<div class="col-md-12">
						     @include('includes.messages')
							<h3 class="box-title">{!! isset($data)?$data['title']:'Add Settings' !!}</h3>
						</div>					
					</div>
					<div class="box-body">
						<div class="col-md-12">
							<div class="tab-pane active" id="tab_1">
								<!-- form start -->
								{!! Form::open(['route' => ['post:store-settings',isset($data)?$data->id:'0'], 'class' => 'col-md-12 box-body']) !!}
								<div class="col-md-8">									
								  <div class="form-group">
										<div class="col-md-4">
											<label for="domain" class="label-name">Mail Domain</label>
										</div>
										<div class="col-md-6">
										    {!! Form::text('domain', Input::old('domain',isset($data)?$data->domain:''), ['class' => 'form-control text_box', 'placeholder' => 'Mail Domain', 'id' => 'domain']) !!}
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4">
											<label for="domain" class="label-name">Admin User</label>
										</div>
										<div class="col-md-6">
										    {!! Form::text('admin_user', Input::old('admin_user',isset($data)?$data->admin_user:''), ['class' => 'form-control text_box', 'placeholder' => 'Admin User', 'id' => 'admin_user']) !!}
										</div>
									</div>
									 <div class="form-group">
										<div class="col-md-4">
											<label for="secret_key" class="label-name">AWS Secret Key</label>
										</div>
										<div class="col-md-6">
										    {!! Form::text('secret_key', Input::old('secret_key',isset($data)?$data->secret_key:''), ['class' => 'form-control text_box', 'placeholder' => 'AWS Secret Key', 'id' => 'secret_key']) !!}
										</div>
									</div>
									 <div class="form-group">
										<div class="col-md-4">
											<label for="access_key" class="label-name">AWS Access Key</label>
										</div>
										<div class="col-md-6">
										    {!! Form::text('access_key', Input::old('access_key',isset($data)?$data->access_key:''), ['class' => 'form-control text_box', 'placeholder' => 'AWS Access Key', 'id' => 'access_key']) !!}
										</div>
									</div>
									 <div class="form-group">
										<div class="col-md-4">
											<label for="bucket_name" class="label-name">AWS Bucket Name</label>
										</div>
										<div class="col-md-6">
										    {!! Form::text('bucket_name', Input::old('bucket_name',isset($data)?$data->bucket_name:''), ['class' => 'form-control text_box', 'placeholder' => 'AWS Bucket Name', 'id' => 'bucket_name']) !!}
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4">
											<label for="mail_login" class="label-name">Mail Login</label>
										</div>
										<div class="col-md-6">
										    {!! Form::text('mail_login', Input::old('mail_login',isset($data)?$data->mail_login:''), ['class' => 'form-control text_box', 'placeholder' => 'Mail Login', 'id' => 'mail_login']) !!}
										</div>
									</div>
									
									
										
 									</div>
									<div class="col-md-4">&nbsp;</div>
									<div class="col-md-6 text-center">
										<button type="submit" class="btn btn-primary bg-red btn-flat mar-right">Save</button>
									</div>
								</div>
								{!!Form::close()!!}
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</section>
			<!-- /.content -->
			<!-- /.content -->
		</div>
         
@stop
