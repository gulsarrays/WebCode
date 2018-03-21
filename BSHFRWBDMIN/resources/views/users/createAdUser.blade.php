@extends('layouts.default') 

@section('title')
	Create Ad-Admin
@stop

@section('content')
<div class="content-wrapper">
	<section class="content-header">
				<h1>Create Ad-Admin</h1>
				<!-- <ol class="breadcrumb">
					<li><a href="{{url('other/users')}}"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Create Ad-Admin</li>
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
						Form::open(['url'=>'adUser/add','method'=>'POST','role'=>'form','class'=>'col-md-12
						box-body','files'=>'true'])!!}
									<div class="col-md-8">
										<div class="form-group">
											<div class="col-md-4">
												<label for="access">Role</label>
											</div>
											<div class="col-md-8">
												{!! Form::select('roles[]', $roles,[], array('required', 'class' => 'form-control','multiple')) !!}
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<label for="Caption">Name</label>
											</div>
											<div class="col-md-8">
												{!!Form::text('name',old('name'),['required', 'class'=>'form-control text_box','placeholder'=>'Name'])!!}
												
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<label for="Caption">Mobile number</label>
											</div>
											<div class="col-md-8">
												{!!Form::text('mobile_number',old('mobile_number'),['required', 'class'=>'form-control text_box', 'id'=>'mobile', 'placeholder'=>'Mobile number'])!!}
												<span>Mobilenumber with countrycode (ex: 919787562356) </span>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<label for="Email">Email</label>
											</div>
											<div class="col-md-8">
												{!!Form::text('email',old('email'),['required', 'class'=>'form-control text_box','placeholder'=>'Email'])!!}
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<label for="status">User Status</label>
											</div>
											<div class="col-md-8">
												<label class="mar-right"> <input type="radio" value="1" name="is_active" class="minimal" checked> Active
												</label> <label> <input type="radio" value="0" name="is_active" class="minimal" > Inactive
												</label>
											</div>
										</div>
									
										<div class="form-group" style="display:none">
											<div class="col-md-4">
												<label for="access">Access Level</label>
											</div>
											<div class="col-md-8">
												{!!Form::select('user_type',$user_type,'',['class'=>'form-control text_box'])!!}  
											</div>
										</div>
									</div>
									<div class="col-md-12">												
										<div class="col-md-4">&nbsp;</div>
										<div class="col-md-8">
											<button type="submit"
												class="btn btn-primary bg-red btn-flat mar-right">Submit</button>
											<button onclick="history.go(-1);" type="button"  onclick="javascript:history.back(-1);" class="btn btn-default btn-flat">Cancel</button>
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