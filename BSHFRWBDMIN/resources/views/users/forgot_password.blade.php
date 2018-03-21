@extends('layouts.logindefault') @section('title') @parent
{{trans('common.user.forgot_password.title')}} - @stop @section('content')
<div class="login-box-body">
	<h2 class="login-box-msg">{{trans('common.user.forgot_password.title')}}</h2>
	<p>{{trans('common.user.forgot_password.tag')}}</p>
	@include('includes/messages')
	{!! Form::open(['url'=>'user/forgotpassword','method'=>'POST','role'=>'form'])!!}
		<div class="form-group has-feedback">
			{!!Form::text('email',old('email'),['class'=>'form-control',
							'placeholder'=>trans('common.user.forgot_password.email')])!!} <span
				class="glyphicon glyphicon-envelope form-control-feedback"></span>
		</div>
		<div class="row">
			<div class="form-group col-xs-12">
				{!!Form::submit(trans('common.user.forgot_password.submit'),
						['class'=>'btn  btn-block btn-flat bg-green'])!!}
			</div>
		</div>
		<div class="form-group">
			<a href="{{url('/')}}" class="extra">{{trans('common.user.forgot_password.login')}}</a>
		</div>
	</form>
</div>
@stop

