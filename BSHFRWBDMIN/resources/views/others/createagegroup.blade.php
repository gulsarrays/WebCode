@extends('layouts.default')
@section('title')
Create Age group
@stop
@section('content')
<div class="content-wrapper" style="min-height: 678px;">
	<section class="content-header">
				<h1>Add Age Group</h1>
				<!-- <ol class="breadcrumb">
					<li><a href="{{url('/other/users')}}"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="{{url('/others')}}">Others</a></li>
				    <li class="active">Add Age Group</li>
				</ol> -->
	</section>
	<section class="content">
				<div class="box box-info">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="message-block">
         							@include('includes.messages')
    							</div>
								<form method="POST" action="{{url('/others/createagegroup')}}" accept-charset="UTF-8" role="form" class="col-md-12
									box-body" enctype="multipart/form-data">
									<input name="_token" type="hidden" value="Uf6TzZoZLnVzUiB4NZlLsydDPJ2BSGrKgu4gBlwi">
									<div class="col-md-8">
										<div class="form-group">
											<div class="col-md-4">
												<label for="Caption">Age Group From </label>
											</div>
											<div class="col-md-8">
												<input required="" class="form-control text_box" id="from" placeholder="ex: 20" name="from" type="number" min="0" max="100"
												style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;">
											</div>											
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<label for="Caption">Age Group to </label>
											</div>
											<div class="col-md-8">
												<input required="" onblur="generateDesc()" id="to" class="form-control text_box" placeholder="ex: 25" name="to" type="number" min="0" max="100" 
												style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;">
												
											</div>											
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<label for="Caption">Age Group Description</label>
											</div>
											<div class="col-md-8">
												<input required="" id="agedesc" class="form-control text_box" readonly placeholder="ex: 20-25" name="desc" type="text" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;">												
											</div>											
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<label for="status">Status</label>
											</div>
											<div class="col-md-8">
												<label class="mar-right"> <input type="radio" value="1" name="is_active" class="minimal" checked=""> Active
												</label> <label> <input type="radio" value="0" name="is_active" class="minimal"> Inactive
												</label>
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