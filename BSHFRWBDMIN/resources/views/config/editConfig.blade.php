<!-- editCategory.blade.php -->
@extends('layouts.default')
@section('title')
Edit Category
@stop
@section('content')

	<div class="content-wrapper" style="min-height: 678px;">
	<section class="content-header">
				<h1>Edit</h1>
				<!-- <ol class="breadcrumb">
					<li><a href="{{url('/other/users')}}"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="{{url('/settings')}}">Settings</a></li>
				    <li class="active">Edit Settings</li>
				</ol> -->
	</section>
	<section class="content">
				<div class="box box-info">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="message-block">
         <!-- check for flash notification message -->
        
     <!-- check for flash notification message -->
    </div>						<!-- Custom Tabs -->
    <!-- url('settings/0') -->
						<!-- <form method="PATCH" action="" accept-charset="UTF-8" role="form" class="col-md-12
						box-body" enctype="multipart/form-data"> -->
						 {!! Form::open( ['method' => 'PATCH', 'action' => ['ConfigController@update',0]]) 
						 !!}

						<input name="_token" type="hidden" value="Uf6TzZoZLnVzUiB4NZlLsydDPJ2BSGrKgu4gBlwi">
									
							@if(!empty($settings))
								
								<div class="col-md-8">
									<div class="form-group">
										<div class="col-md-4">
											<label for="Caption">{{ $settings['name']}}</label>
										</div>
										<div class="col-md-8">
											<input type="hidden" name="settingId" value="{{ $settings['settingId']}}">
											<input type="hidden" name="settingName" value="{{ $settings['name']}}">
											<input required="" class="form-control text_box" placeholder="Name" name="settingValue" type="number" 
											value="{{ $settings['value']}}" min="1" max=""
											style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;">											
										</div>
									</div>										
								</div>
								
				    			@endif
								<div class="col-md-12">												
									<div class="col-md-4">&nbsp;</div>
									<div class="col-md-8">
										<button type="submit" class="btn btn-primary bg-red btn-flat mar-right">Submit</button>
										<button onclick="history.go(-1);" type="button"  onclick="javascript:history.back(-1);" class="btn btn-default btn-flat">Cancel</button>
									</div>
								</div>
							{{ Form::close() }}
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