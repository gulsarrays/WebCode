@extends('layouts.default')
@section('title') Edit Business Admin @stop 
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
						Form::open(['url'=>'admin/'.$user->id,'method'=>'POST','role'=>'form','class'=>'col-md-12
						box-body user-edit','files'=>'true'])!!}
						
						<div class="col-md-8">
							<div class="form-group">
								<div class="col-md-4">
									<label class="label-name">{{trans('common.user.name')}}</label>
								</div>
								<div class="col-md-8">
									{!!Form::text('name',$user->username,['required', 'class'=>'form-control text_box','minlength'=>3,'maxlength'=>75])!!}
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									<label class="label-name">Mobile number</label>
								</div>
								<div class="col-md-8">
									{!!Form::text('mobile_number',$user->mobile_number,['readonly', 'class'=>'form-control text_box','minlength'=>7,'maxlength'=>13,'required'])!!}
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									<label  class="label-name">{{trans('common.user.email')}}</label>
								</div>
								<div class="col-md-8">
									{!!Form::text('email',$user->email,['readonly', 'class'=>'form-control email text_box', 'required'])!!}
								</div>
							</div>
										<!-- @if($user->user_type!=1)
										<div class="form-group">
											<div class="col-md-4">
												<label for="access"  class="label-name">Access Level</label>
											</div>
											<div class="col-md-8">
												{!!Form::select('user_type',$user_type,$user->user_type,['class'=>'form-control text_box', (auth()->user()->user_type ==2)? 'disabled':'' ])!!}
											</div>
										</div>
										@else
											{!!Form::hidden('user_type',$user->user_type)!!}
										@endif -->
							 
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

										{!!Form::radio('is_active',1,$active,['class'=>'minimal', 'required'])!!}
										{{trans('common.user.active')}} </label> 
										<label>{!!Form::radio('is_active',0,$inactive,['class'=>'minimal' ,'required'])!!}
										{{trans('common.user.in_active')}} </label>
								</div>
							</div>
							  @else
							     {!!Form::hidden('is_active',$user->is_active)!!}
							  @endif							  
						
				        <div class="form-group">
							<div class="col-md-4">
								<label  class="label-name">Role</label>
							</div>
							<div class="col-md-8">
								{!! Form::select('roles[]', $roles,$userRole, array('readonly', 'class' => 'form-control','multiple')) !!}

							</div>
						</div>
						<!-- , 'required' -->
						
						</div>
						<div class="col-md-8">
							<div class="col-md-6">&nbsp;</div>
							<div class="col-md-6">
								@if(auth()->user()->user_type != $user->user_type)
									<button type="submit" class="btn bg-red btn-flat mar-right">{{trans('common.user.update')}}</button>
								@endif
								<!-- <a class="btn btn-default btn-flat btn-rad-sm btn-org mar-top" href="{{url('/sadmin')}}">{{trans('common.user.back')}}</a>								     -->
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
