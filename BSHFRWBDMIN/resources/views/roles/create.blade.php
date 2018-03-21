@extends('layouts.default')
@section('title') Add Roles @stop

@section('content')
    <div class="content-wrapper" style="min-height: 678px;">
        <section class="content-header">
            <h1>Create New Role</h1>
            <!-- <ol class="breadcrumb">
                <li><a href="{{url('other/users')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Create Role</li>
            </ol> -->
        </section>

        <section class="content">
        	<div class="box box-info">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('includes.messages')

                    	{!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                    	<div class="col-md-8">
                    		
                            <div class="form-group ">
                                <div class="col-md-4">
                                    <label class="label-name">Name:</label></div><div class="col-md-8">
                                    {!! Form::text('name', old('name'), array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                            </div>
                    		<div class="form-group ">
                                <div class="col-md-4">
                                    <label class="label-name">Display Name:</label></div><div class="col-md-8">
                                    {!! Form::text('display_name', old('display_name'), array('placeholder' => 'Display Name','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-md-4">
                                    <label class="label-name">Description:</label></div><div class="col-md-8">
                                    {!! Form::textarea('description', old('description'), array('placeholder' => 'Description','class' => 'form-control','style'=>'height:100px')) !!}
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-md-4">
                                    <label class="label-name">Permissions:</label></div><div class="col-md-8">
                                    <br/>
                                    @foreach($permission as $value)
                                    	<div class="col-md-6"><label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    	{{ $value->display_name }}</label></div>
                                    	
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group  text-center">
                    			<button type="submit" class="btn btn-primary bg-red btn-flat">Submit</button>
                                <a class="btn btn-default btn-flat btn-rad-sm btn-org mar-top" href="{{url('/roles')}}">Cancel</a>
                            </div>
                    	</div>
                    	{!! Form::close() !!}
        </section>
    </div>
@endsection