@extends('layouts.default') 

@section('title')
	Change Password
@stop

@section('content')

<div class="content-wrapper">
	<section class="content-header">
		<h1>Settings</h1>
		<!-- <ol class="breadcrumb">
			<li><a href="{{ URL::route('get:login') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="">Settings</li>
		</ol> -->
	</section>
	<section class="content">
		<div class="box box-info">
			<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						@include('includes.messages')
						{!! Form::open(['route' => 'post:forgotpassword']) !!}
							<div class="col-md-8">
								
								<div class="form-group">
									<div class="col-md-6">
										<label for="old_password">Old Password</label>
									</div>
									<div class="col-md-6">
										{!! Form::password('old_password', ['class' => 'form-control', 'placeholder' => 'Old Password', 'id' => 'old_password']) !!}
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-6">
										<label for="password">New Password</label>
									</div>
									<div class="col-md-6">
										{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'New Password', 'id' => 'password']) !!}
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-6">
										<label for="password_confirmation">Confirm Password</label>
									</div>
									<div class="col-md-6">
										{!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password', 'id' => 'password_confirmation']) !!}
									</div>
								</div>	
								<div class="col-md-6">&nbsp;</div>
								<div class="col-md-6">
									<button type="submit"
										class="btn btn-primary bg-red btn-flat mar-right">Save</button>
									<a href="{{url('users')}}" class="btn btn-default btn-flat">Cancel</a>
								</div>
							</div>
						{!!Form::close()!!}
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@stop