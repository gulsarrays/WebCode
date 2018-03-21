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
					<li class="active">View Settings</li>
				</ol> -->
			</section>
			<section class="content">
				<div class="box box-info">
					<div class="box-header with-border">
						<div class="col-md-12">
						     @include('includes.messages')
							<h3 class="box-title">View Settings</h3>
						</div>					
					</div>
					<div class="box-body">
						<div class="col-md-12">
							<div class="tab-pane active" id="tab_1">
								<!-- form start -->
								<div class="col-md-8">									
								  <div class="form-group">
										<div class="col-md-4">
											<label for="sip_domain" class="label-name">Mail Domain</label>
										</div>
										<div class="col-md-6">
										    {!! isset($data)?$data->domain:'' !!}
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4">
											<label for="sip_domain" class="label-name">Admin User</label>
										</div>
										<div class="col-md-6">
										    {!! isset($data)?$data->admin_user:'' !!}
										</div>
									</div>
									 <div class="form-group">
										<div class="col-md-4">
											<label for="sip_domain" class="label-name">AWS Secret Key</label>
										</div>
										<div class="col-md-6">
										    {!! isset($data)?$data->secret_key:'' !!}
										</div>
									</div>
									 <div class="form-group">
										<div class="col-md-4">
											<label for="sip_domain" class="label-name">AWS Access Key</label>
										</div>
										<div class="col-md-6">
										    {!! isset($data)?$data->access_key:'' !!}
										</div>
									</div>
									 <div class="form-group">
										<div class="col-md-4">
											<label for="sip_domain" class="label-name">AWS Bucket Name</label>
										</div>
										<div class="col-md-6">
										    {!! isset($data)?$data->bucket_name:''!!}
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4">
											<label for="sip_domain" class="label-name">Mail Login</label>
										</div>
										<div class="col-md-6">
										    {!! isset($data)?$data->mail_login:''!!}
										</div>
									</div>
									
									
									
									
								</div>
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
