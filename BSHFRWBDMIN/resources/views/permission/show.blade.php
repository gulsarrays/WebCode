@extends('layouts.default')
 
@section('content')
	<div class="content-wrapper" style="min-height: 678px;">
		<section class="content">
			<div class="row">
			    <div class="col-lg-12 margin-tb">
			        <div class="pull-left">
			            <h2> Show Permission</h2>
			        </div>
			        <div class="pull-right">
			            <a class="btn btn-primary" href="{{ route('permission.index') }}"> Back</a>
			        </div>
			    </div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
		            <div class="form-group">
		                <strong>Name:</strong>
		                {{ $permission->display_name }}
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-12 col-md-12">
		            <div class="form-group">
		                <strong>Description:</strong>
		                {{ $permission->description }}
		            </div>
		        </div>
			</div>
		</section>
	</div>
@endsection