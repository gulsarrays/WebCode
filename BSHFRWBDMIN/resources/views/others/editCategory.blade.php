<!-- editCategory.blade.php -->
@extends('layouts.default')
@section('title')
Edit Category
@stop
@section('content')

	<div class="content-wrapper" style="min-height: 678px;">
	<section class="content-header">
				<h1>Edit Category</h1>
				<!-- <ol class="breadcrumb">
					<li><a href="{{url('admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="{{url('/others')}}">Others</a></li>
				    <li class="active">Edit Category</li>
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
						<form method="POST" action="{{url('/others/category/update')}}" accept-charset="UTF-8" role="form" class="col-md-12
						box-body" enctype="multipart/form-data"><input name="_token" type="hidden" value="Uf6TzZoZLnVzUiB4NZlLsydDPJ2BSGrKgu4gBlwi">
									<div class="col-md-8">
										<div class="form-group">
											<div class="col-md-4">
												<label for="Caption">Category Name</label>
											</div>
											<div class="col-md-8">
												<input required="" class="form-control text_box" placeholder="Name" name="name" type="text" 
												value="{{$category['categoryName']}}"
												style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;">
												<input type="hidden" name="categoryId" value="{{$category['categoryId']}}">
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<label for="Caption">Category Image</label>
											</div>
											<div class="col-md-8">
												@if(!empty($category['categoryImage']))
												<img src="{{ env('CHANNEL_API') }}channels/api/v1/channel/content/getContent/{{$category['categoryImage']}}" style="width: 150px;height:150px"></td>
												@endif	
												<input class="form-control text_box" id="cimage" name="categoryImage" type="file" accept="image/*">
											</div>											
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<label for="status">Status</label>
											</div>
											<?php $active=false;
											$inactive=false;
											($category['isactive'] == 1) ?$active=true:$inactive=true;
											?>
											<div class="col-md-8">
												<label class="mar-right"> {!!Form::radio('is_active',1,$active,['class'=>'minimal'])!!} {{trans('common.user.active')}} </label>												
												<label>{!!Form::radio('is_active',0,$inactive,['class'=>'minimal'])!!} {{trans('common.user.in_active')}} </label>												
											</div>
										</div>
									</div>
									<div class="col-md-12">												
										<div class="col-md-4">&nbsp;</div>
										<div class="col-md-8">
											<button type="submit" class="btn btn-primary bg-red btn-flat mar-right">Submit</button>
											<button onclick="history.go(-1);" type="button"  onclick="javascript:history.back(-1);" class="btn btn-default btn-flat">Cancel</button>
										</div>
									</div>
								</form>
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