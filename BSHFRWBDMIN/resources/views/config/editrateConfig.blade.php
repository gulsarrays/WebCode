@extends('layouts.default') 

@section('title')
	Settings
@stop

@section('content')
<div class="content-wrapper" style="min-height: 678px;">
	<section class="content-header">
				<h1>Edit Rate</h1>
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
							    </div>
							    <!-- Custom Tabs -->
    							<!-- url('settings/0') -->

						
						{!! Form::open( ['method' => 'PATCH', 'action' => ['RateCardConfigController@update',0]]) 
						 !!}

							<input name="_token" type="hidden" value="Uf6TzZoZLnVzUiB4NZlLsydDPJ2BSGrKgu4gBlwi">

							<div class="col-md-8">
									
									<div class="form-group">
										<div class="col-md-4">
											<label for="Caption">Name</label>
										</div>
										<div class="col-md-8">
											<input value="{{ $settings['rateCardId'] }}" name="rateCardId" type="hidden" >
											<input readonly  name="contentType" value="{{ $settings['contentType'] }}" class="form-control text_box" placeholder="Content type" type="text" 
											style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;">
											
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4">
											<label for="Caption">Currency</label>
										</div>
										<div class="col-md-8">
											<input required="" min="1" value="{{ $settings['amtPerNoOfView'] }}" class="form-control text_box" placeholder="Amount" name="amtPerNoOfView" type="number"
											 style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;">
											
										</div>
									</div>

									<div class="form-group">
										<div class="col-md-4">
											<label for="Caption">No. of view</label>
										</div>
										<div class="col-md-8">
											<input required="" min="1" value="{{ $settings['noOfViews'] }}" class="form-control text_box" placeholder="No of views" name="noOfViews" type="number" 
											style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;">
											
										</div>
									</div>

									<div class="form-group">
										<div class="col-md-4">
											<label for="status">Status</label>
										</div>
										<div class="col-md-8">
											<label class="mar-right"> <input disabled type="radio" value="1" name="is_active" class="minimal" checked=""> Active
											</label> <label> <input disabled type="radio" value="0" name="is_active" class="minimal"> Inactive
											</label>
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