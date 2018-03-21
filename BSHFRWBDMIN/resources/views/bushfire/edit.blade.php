@extends('layouts.default')
@section('title') Edit Admin @stop
 
@section('content')
    <div class="content-wrapper" style="min-height: 678px;">
        <section class="content-header">
            <h1>{{trans('common.user.edit_title')}}</h1>
            
        </section>

        <section class="content">
        	<!-- <div class="row">
        	    <div class="col-lg-12 margin-tb">
        	        <div class="pull-left">
        	            <h2>Edit User</h2>
        	        </div>
        	        <div class="pull-right">
        	            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        	        </div>
        	    </div>
        	</div> -->
        	<div class="box box-info">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            @include('includes.messages')
	       
            {!! Form::model($user, ['method' => 'POST','route' => ['users.update', $user->id], 'class'=>'col-md-12
                        box-body user-edit']) !!}
            	<div class="col-md-8">
                    <div class="form-group">
                        <div class="col-md-4"><label class="label-name">Name:</label></div>
                        <div class="col-md-8">
                            {!! Form::text('username', $user->username, array('placeholder' => 'Name','class' => 'form-control')) !!}
                        </div>                    
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"><label class="label-name">Email:</label></div>
                        <div class="col-md-8">{!! Form::text('email', $user->email, array('readonly','placeholder' => 'Email','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"><label class="label-name">Mobile Number:</label></div>
                        <div class="col-md-8">{!! Form::text('mobile_number', $user->mobile_number, array('readonly','placeholder' => 'Mobile number','class' => 'form-control','minlength'=>7,'maxlength'=>13)) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4"><label class="label-name">User Status: </label></div>
                        <?php $active=false;
                            $inactive=false;
                            ($user->is_active=='1') ?$active=true:$inactive=true;
                        ?>
                        <div class="col-md-8">
                            {!! Form::radio('is_active',1,$active,['class'=>'minimal'])!!}
                            <label class="mar-right">{{trans('common.user.active')}} </label> 
                            {!!Form::radio('is_active',0,$inactive,['class'=>'minimal'])!!}
                            <label>{{trans('common.user.in_active')}} </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"><label class="label-name">Role:</label></div>
                            <div class="col-md-8">
                                {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            			<button type="submit" class="btn bg-red btn-flat mar-right">Submit</button>
                        <a class="btn btn-default" href="{{ route('users.index') }}"> Back</a>
                    </div>
            	</div>
            {!! Form::close() !!}
                        
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection