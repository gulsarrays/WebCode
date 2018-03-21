@extends('layouts.default')
 @section('title') edit Reports @stop 

@section('content')
	<div class="content-wrapper" id="addreport" style="min-height: 678px;">
	<section class="content-header">
				<h1>Edit Report</h1>
	</section>
	<section class="content">
				<div class="box box-info">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
		<!-- Custom Tabs -->
						<form method="post" action="{{ url('/reports'). '/'.$reportType['userCommentsCategoryId'] }}" role="form" class="col-md-12
						box-body">
							<input name="_token" type="hidden" value="Uf6TzZoZLnVzUiB4NZlLsydDPJ2BSGrKgu4gBlwi">
									<div class="col-md-8">
										<input type="hidden" name="reportTypeId" value="{{ $reportType['userCommentsCategoryId'] }}">
										<div class="form-group">
											<div class="col-md-4">
												<label for="Caption">Report Name</label>
											</div>
											<div class="col-md-8">
												<input required="" value="{{ $reportType['userCommentsCategoryDesc'] }}" class="form-control text_box" placeholder="Name" name="name" type="text" 
												style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;">
												
											</div>
										</div>

										<div class="form-group">
											<div class="col-md-4">
												<label for="status">Status</label>
											</div>
											<div class="col-md-8">
												<label class="mar-right"> <input type="radio" value="1" name="is_active" class="minimal" {{ ($reportType['isActive']==1)?'checked':'' }}> Active
												</label> <label> <input type="radio" value="0" name="is_active" class="minimal" {{ ($reportType['isActive']==0)?'checked':'' }}> Inactive
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
@endsection