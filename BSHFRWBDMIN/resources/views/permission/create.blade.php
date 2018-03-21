@extends('layouts.default')

@section('content')
    <div class="content-wrapper" style="min-height: 678px;">
        <section class="content">
        	<div class="row">
        	    <div class="col-lg-12 margin-tb">
        	        <div class="pull-left">
        	            <h2>Create New Permission</h2>
        	        </div>
        	        <div class="pull-right">
        	            <a class="btn btn-primary" href="{{ route('permission.index') }}"> Back</a>
        	        </div>
        	    </div>
        	</div>
        	@if (count($errors) > 0)
        		<div class="alert alert-danger">
        			<strong>Whoops!</strong> There were some problems with your input.<br><br>
        			<ul>
        				@foreach ($errors->all() as $error)
        					<li>{{ $error }}</li>
        				@endforeach
        			</ul>
        		</div>
        	@endif
        	{!! Form::open(array('route' => 'permission.store','method'=>'POST')) !!}
        	<div class="row">
        		<div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
                </div>
        		<div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Display Name:</strong>
                        {!! Form::text('display_name', null, array('placeholder' => 'Display Name','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Description:</strong>
                        {!! Form::textarea('description', null, array('placeholder' => 'Description','class' => 'form-control','style'=>'height:100px')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        				<button type="submit" class="btn btn-primary">Submit</button>
                </div>
        	</div>
        	{!! Form::close() !!}
        </section>
    </div>
@endsection