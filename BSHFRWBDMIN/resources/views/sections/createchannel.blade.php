@extends('layouts.default') 
@section('title')
	Create Channel
@stop
@section('content')

<style>
select.dropdown{
	/*border: none !important;*/
	border-left: 0;
    border-right: 0;
    border-top: 0;
    border-bottom: 1px solid #acaba8;
    height: auto;
    padding-bottom: 6px;
}
</style>

<div class="content-wrapper">
	<section class="content-header">
		<h1>Create Channel</h1>
		<ol class="breadcrumb">
			<li><a href="{{ URL::route('get:channels') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">View chats</li>
		</ol>
	</section>

	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
			 @include('includes.messages')
			 <div class="clearfix"></div>
              <!-- /.box-tools -->
            </div>
        

	        <div class="box-body">
	        	<div id="channels" class="col-md-12">
	        		<div class="text-center">
		        		<h4>Create Channel</h4>

		        		<div id="addchannel">
		        			{!! Form::open(['url'=>'channel/create','method'=>'POST','role'=>'form','class'=>'col-md-12
							box-body','files'=>'true']) !!}

								<div class="form-group">
									<div class="col-md-offset-1 col-md-3" style="height:80px;">
							          	{!! Form::file('files') !!}
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-4">
										<label for="Caption">Channel Title</label>
									</div>
									<div class="col-md-8">
										{!!Form::text('channelTitle',old('channelTitle'),['class'=>'form-control text_box','placeholder'=>'Channel Title'])!!}
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-4">
										<label for="Caption">About Channel</label>
									</div>
									<div class="col-md-8">
										{!!Form::text('channelDescription',old('channelDescription'),['class'=>'form-control text_box','placeholder'=>'About Channel'])!!}
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-4">
										<label for="Caption">Age Group</label>
									</div>
									<div class="col-md-8">
										
										<select name="ageGroupId" class="dropdown form-control">
											<option>Age Group</option>
											@foreach($ageGroups as $ageGroup)
												<option value="{{ $ageGroup['ageGroupId'] }}">{{ $ageGroup['ageGroupDescription'] }}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-4">
										<label for="Caption">Category</label>
									</div>
									<div class="col-md-8">									
										<select name="categoryId" class="dropdown form-control">
											<option>Category</option>
											@foreach($categories as $category)
												<option value="{{ $category['categoryId'] }}">{{ $category['categoryName'] }}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="col-md-12">												
									<div class="col-md-4">&nbsp;</div>
									<div class="col-md-8">
										<button type="submit" class="btn btn-primary bg-red btn-flat mar-right">Create</button>
										<button type="button" onclick="window.location='{{ url('channels') }}'" class="btn btn-default btn-flat">Cancel</button>
									</div>
								</div>

							{!! Form::close() !!}
		        		</div>
	        		</div>

	        	</div>
	        </div>

        </div>
        
    </section>

</div>
@stop