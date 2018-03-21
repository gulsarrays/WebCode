@extends('layouts.default')
@section('title') Edit Roles @stop 
@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Access Level</h1>
		<ol class="breadcrumb">
			<li><a href="{{url('/admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Access Level</li>
		</ol>
	</section>
	<section class="content">
		<div class="box box-info">
			<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						@include('includes.messages')
						<!-- Custom Tabs -->
						{!!
						Form::open(['url'=>'access/'.$role->id,'method'=>'POST','role'=>'form','class'=>'col-md-12
						box-body post-edit','files'=>'true'])!!}
						{!!Form::hidden('_method','PUT',['id'=>'_method'])!!}
						
						<div class="col-md-8">
							<div class="form-group">
											<div class="col-md-4">
												<label for="Caption">Role</label>
											</div>
											<div class="col-md-8">
												{!!Form::text('name',$role->name,['class'=>'form-control text_box'])!!}
												
											</div>
										</div>
							<div class="form-group">
											<div class="col-md-4">
												<label for="access">Allowed Pages</label>
											</div>
											<div class="col-md-8">												
												@foreach($modules as $key=>$value)																	
												
												<div class="col-md-6">
												<input type="checkbox" name="module[]" value="{{$key}}" <?php if(substr_count($role->permission, $key)>0) echo "checked";?>> <label for="admin">{{ucwords($value)}}</label>
												</div>
												<!-- <input type="hidden" name="module[]" value="user" > -->
												@endforeach
											</div>
										</div>
							</div>
							
						<div class="col-md-12">
							<div class="col-md-4">&nbsp;</div>
							<div class="col-md-8">
								<button type="submit"
									class="btn bg-green btn-flat mar-right">{{trans('common.post.update')}}</button>
								<button type="submit" class="btn btn-default btn-flat cancel_btn">
								{{trans('common.post.cancel')}}</button>
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
