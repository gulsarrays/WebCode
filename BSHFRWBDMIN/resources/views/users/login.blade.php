@extends('layouts.logindefault') 

@section('title')
	Admin Login
@stop

@section('content')
	<div class="login-box-body">
		<h2 class="login-box-msg">Login</h2>
		
		@include('includes.messages')
		
		{!! Form::open(['route' => 'post:login']) !!}
			
			<div class="form-group">
				<select class="form-control selectrole" name="roleName">
				 	<option selected disabled hidden>Select Role</option>
				 	<option value="1">Admin</option>
					<option value="{{ pjRoleId }} ">Platform Jockey</option>
					<option value="{{ stringerRoleId }}">Stringer</option>
				</select>
			</div>

			<div class="form-group has-feedback">
				{!! Form::text('username', Input::old('username'), ['class' => 'form-control', 'placeholder' => 'User Name', 'autocomplete' => 'off']) !!}
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			
			<div class="form-group has-feedback">
				{!! Form::password('password',['class' => 'form-control','placeholder' => 'Password', 'autocomplete' => 'off']) !!}
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			 
			<div class="row">
				<div class="col-xs-6">
					<div class="checkbox icheck">
						<label> 
							<input type="checkbox"> Remember Me
						</label>
					</div>
				</div>
				<div class="col-xs-6">
					<a href="{{ URL::route('get:forgotpassword') }}" class="checkbox  col-xs-12 text-center">Forgot my password?</a>
				</div>
			</div>
			
			<div class="row">
				<div class="form-group col-xs-12">
					{!!Form::submit('Sign In', ['class' => 'btn  btn-block btn-info'])!!}
				</div>
			</div>
			
		{!!Form::close()!!}
	</div>
@stop
