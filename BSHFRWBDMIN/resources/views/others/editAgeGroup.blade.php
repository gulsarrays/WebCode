<!-- editAgeGroup -->
@extends('layouts.default')
@section('title')
Edit Age group
@stop
@section('content')
<div class="content-wrapper" style="min-height: 678px;">
	<section class="content-header">
				<h1>Edit Age Group</h1>
				<!-- <ol class="breadcrumb">
					<li><a href="{{url('admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="{{url('/others')}}">Others</a></li>
				    <li class="active">Edit Age Group</li>
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
						<form method="POST" action="{{url('/others/ageGroup/update')}}" accept-charset="UTF-8" role="form" class="col-md-12
						box-body" enctype="multipart/form-data"><input name="_token" type="hidden" value="Uf6TzZoZLnVzUiB4NZlLsydDPJ2BSGrKgu4gBlwi">
									<div class="col-md-8">
										<div class="form-group">
											<div class="col-md-4">
												<label for="Caption">Age Group From </label>
											</div>
											<div class="col-md-8">
												<input required="" readonly class="form-control text_box" placeholder="20" name="from" 
												value="{{$agegroup['ageGroupMin']}}" min="0" max="100" id="from"
												type="number" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;">
											</div>
											
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<label for="Caption">Age Group to </label>
											</div>
											<div class="col-md-8">
												<input required="" readonly onblur="generateDesc()" class="form-control text_box" placeholder="25" name="to"
												value="{{$agegroup['ageGroupMax']}}" min="0" max="100" id="to" 
												type="number" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;">
											</div>											
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<label for="Caption">Age Group Description</label>
											</div>
											<div class="col-md-8">
												<input required="" readonly id="agedesc" class="form-control text_box" placeholder="20-25" 
												value="{{$agegroup['ageGroupDescription']}}"
												name="desc" type="text" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;">												
											</div>											
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<label for="status">Status</label>
											</div>
											<input type="hidden" name="ageGroupId" value="{{$agegroup['ageGroupId']}}">
											<?php $active=false;
											$inactive=false;
											($agegroup['isactive'] == 1) ?$active=true:$inactive=true;
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
											<a href="#" onclick="history.go(-1);" class="btn btn-default btn-flat">Cancel</a>
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
<script>
function generateDesc(){
	var from = $("#from").val();
	var to = $("#to").val();
	if(from >= 0 && ( parseInt(to) > parseInt(from) ) ){
		$('#agedesc').val(from +'-'+to);
	}else{
		$('#agedesc').val('');
	}
}
$("#from").on("change", function(e){
	$("#to").attr({
       "min" : parseInt(this.value) + 1,
    });
});
</script>
@stop