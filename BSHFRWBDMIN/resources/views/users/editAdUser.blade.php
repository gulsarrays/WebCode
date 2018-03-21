@extends('layouts.default')
@section('title') Edit Ad Users @stop
@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>{{trans('common.user.edit_title')}}</h1>
		<!-- <ol class="breadcrumb">
			<li><a href="{{url('other/users')}}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">{{trans('common.user.edit_title')}}</li>
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
						Form::open(['url'=>'adUser/'.$user->id,'method'=>'POST','role'=>'form','class'=>'col-md-12
						box-body user-edit','files'=>'true'])!!}
						
						<div class="col-md-8">
							<div class="form-group">
								<div class="col-md-4">
									<label class="label-name">{{trans('common.user.name')}}</label>
								</div>
								<div class="col-md-8">
									{!!Form::text('name',$user->username,['', 'class'=>'form-control required text_box','minlength'=>3,'maxlength'=>75])!!}
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									<label class="label-name">Mobile number</label>
								</div>
								<div class="col-md-8">
									{!!Form::text('mobile_number',$user->mobile_number,['readonly', 'class'=>'form-control required text_box','id'=>'mobile','minlength'=>7,'maxlength'=>13])!!}
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									<label  class="label-name">{{trans('common.user.email')}}</label>
								</div>
								<div class="col-md-8">
									{!!Form::text('email',$user->email,['readonly', 'class'=>'form-control email required text_box'])!!}
								</div>
							</div>
							
							 @if(auth()->user()->user_type!=2)
	                         @if($user->user_type!=1)
							  <div class="form-group">
								<div class="col-md-4">
									<label for="exampleInputPassword1">{{trans('common.user.status')}}</label>
								</div>
								<div class="col-md-8">
									<label class="mar-right"> 
										<?php $active=false;
										$inactive=false;
										($user->is_active=='1') ?$active=true:$inactive=true;
										?>

										{!!Form::radio('is_active',1,$active,['class'=>'minimal'])!!}
										{{trans('common.user.active')}} </label> 
										<label>{!!Form::radio('is_active',0,$inactive,['class'=>'minimal'])!!}
										{{trans('common.user.in_active')}} </label>
								</div>
							</div>
							  @else
							     {!!Form::hidden('is_active',$user->is_active)!!}
							  @endif
							  @endif
							{!!Form::hidden('user_type',$user->user_type)!!}
						
						<div class="form-group">
							<div class="col-md-4">
								<label  class="label-name">Role</label>
							</div>
							<div class="col-md-8">
								{!! Form::select('roles[]', $roles,$userRole, array('readonly', 'class' => 'form-control','multiple', 'required')) !!}
							</div>
						</div>
						</div>
						<div class="col-md-8">
							<div class="col-md-6">&nbsp;</div>
							<div class="col-md-6">
								<button type="submit"
									class="btn btn-primary bg-red btn-flat">{{trans('common.user.update')}}</button>
									@if(auth()->user()->user_type==1)
									<a class="btn btn-default btn-flat btn-rad-sm btn-org mar-top" href="{{url('/adUser')}}">{{trans('common.user.back')}}</a>
								    @else	
								    <a class="btn btn-default btn-flat btn-rad-sm btn-org mar-top" href="{{url('adUser/asc')}}">{{trans('common.user.back')}}</a>
								   @endif
								<!-- <button type="submit" class="btn btn-default btn-flat cancel_btn">
								{{trans('common.user.cancel')}}</button> -->
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
<script>
$('#mobile').keypress(function (e) {
    var regex = new RegExp("^[0-9]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }
    e.preventDefault();
    return false;
});
</script>
@stop
