@extends('layouts.default')
@section('title')
Channels
@stop
@section('content')
<script>
$(document).ready(function() {
    $('#myCarousel').carousel({
        interval: 10000
    })
});
</script>
<div class="content-wrapper" style="min-height: 440px;">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Trending Channels</h1>
		<ol class="breadcrumb">
			<li><a href="http://bushfirewebadmin.app/staff"><i class="fa fa-dashboard"></i>
					Home</a></li>
			<li class="active"><a href="http://bushfirewebadmin.app/trending">Trending Channels</a></li>
		</ol>
	</section>
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
			<div class="message-block">
				<h3 class="box-title">Trending Channels List</h3>
         <!-- check for flash notification message -->
        
     <!-- check for flash notification message -->
    </div>				<!-- <h3 class="box-title">Business Admins</h3> -->
				<a href="{{ url('trending/createtrending') }}" id="clonetrending" class="btn btn-sm btn-info btn-flat pull-right "><i class="fa fa-plus"></i>Add Trending Channels</a>
			</div>
			<div class="box-body">
				

  <input id="total_data_count" name="totalcount" type="hidden" value="3">

<div>
    <div class="">
        <div class="span12">
            <div class="well"> 
                <div id="myCarousel" class="carousel slide">
                 
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>
                 
                <!-- Carousel items -->
                <div class="carousel-inner">
                    
                <div class="item active">
                    <div class="row-fluid">
                      <div class="span2 selectedtrendingchannels"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;" /></a></div>
                      <div class="span2 selectedtrendingchannels"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;" /></a></div>
                        <div class="span2 selectedtrendingchannels"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;" /></a></div>
                       
                    </div><!--/row-fluid-->
                </div><!--/item-->
                 
                <div class="item">
                    <div class="row-fluid">
                        <div class="span2 selectedtrendingchannels"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;" /></a></div>
                        <div class="span2 selectedtrendingchannels"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;" /></a></div>
                        <div class="span2 selectedtrendingchannels"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;" /></a></div>
                    </div><!--/row-fluid-->
                </div><!--/item-->
                 
                <div class="item">
                    <div class="row-fluid">
                        <div class="span2 selectedtrendingchannels"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;" /></a></div>
                        <div class="span2 selectedtrendingchannels"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;" /></a></div>
                        <div class="span2 selectedtrendingchannels"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;" /></a></div>
                    </div><!--/row-fluid-->

                </div><!--/item-->
                 
                </div><!--/carousel-inner-->
                 
                <a class="left carousel-control" href="#myCarousel" data-slide="prev"><i class="fa fa-arrow-left left-arrow" aria-hidden="true"></i></a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next"><i class="fa fa-arrow-right right-arrow" aria-hidden="true"></i></a>
                </div><!--/myCarousel-->
                 
            </div><!--/well-->  
        </div>
   </div> 
</div>



<form id="search" class="right search_right ">
<a class="fa fa-refresh text-green pull-right close_here" data-toggle="tooltip" title="Reset" href="http://bushfiresuperadmin.app/staff"></a>
        <div class=" col-md-4 padding-left has-feedback no-padding pull-right">
                <input id="query" placeholder="Search" class="form-control src_width text_box" name="q" type="text">
                <button type="submit" class="glyphicon glyphicon-search form-control-feedback"></button>
        </div>
     
        <input onclick="resetFormValues();" style="display:none;" type="submit" value="Submit">
      
</form>










				<table id="example1" class="table table-bordered table-hover stuff_table">
					 <thead>
                            <tr>
                                <th>Channel Title</th>
                                <th>Category</th>
                                <th>Age Group</th>
                                <th>Channel Type</th>
                                <th>Total Subcriber Count</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="">Living What You Love</a></td>
                                <td>Nature</td>
                                <td>15-20 Yrs</td>
                                <td>Business</td>
                                <td>1234567</td>
                                <td class="text-center">
							 <span class="label label-success">Active</span>
							 </td>
							 <td class="text-center">
							<a class="btn btn-box-tool fa fa-pencil text-aqua" data-toggle="tooltip" title="" href="http://bushfiresuperadmin.app/staff/edit/23" data-original-title="Edit"></a> <a class="btn btn-box-tool fa fa-trash text-yellow" data-toggle="modal" data-target="#confirm-delete" title="Delete" data-href="http://bushfiresuperadmin.app/staff/delete/23">
								</a></td>
                            </tr>
                            <tr>
                                <td><a href="">Stand Tall Through Everything</a></td>
                                <td>Sports</td>
                                <td>15-40 Yrs</td>
                                <td>Private</td>
                                <td>1234567</td>
                                <td class="text-center">
							 <span class="label label-success">Active</span>
							 </td>
							 <td class="text-center">
							<a class="btn btn-box-tool fa fa-pencil text-aqua" data-toggle="tooltip" title="" href="http://bushfiresuperadmin.app/staff/edit/23" data-original-title="Edit"></a> <a class="btn btn-box-tool fa fa-trash text-yellow" data-toggle="modal" data-target="#confirm-delete" title="Delete" data-href="http://bushfiresuperadmin.app/staff/delete/23">
								</a></td>
                            </tr>
                            <tr>
                                <td><a href="">Thoughts about Nothing</a></td>
                                <td>Blog</td>
                                <td>05-60 Yrs</td>
                                <td>Business</td>
                                <td>1234567</td>
                                <td class="text-center">
							 <span class="label label-success">Active</span>
							 </td>
							 <td class="text-center">
							<a class="btn btn-box-tool fa fa-pencil text-aqua" data-toggle="tooltip" title="" href="http://bushfiresuperadmin.app/staff/edit/23" data-original-title="Edit"></a> <a class="btn btn-box-tool fa fa-trash text-yellow" data-toggle="modal" data-target="#confirm-delete" title="Delete" data-href="http://bushfiresuperadmin.app/staff/delete/23">
								</a></td>
                            </tr>
                            <tr>
                                <td><a href="">Living What You Love</a></td>
                                <td>Nature</td>
                                <td>15-20 Yrs</td>
                                <td>Private</td>
                                <td>1234567</td>
                                <td class="text-center">
							 <span class="label label-success">Active</span>
							 </td>
							 <td class="text-center">
							<a class="btn btn-box-tool fa fa-pencil text-aqua" data-toggle="tooltip" title="" href="http://bushfiresuperadmin.app/staff/edit/23" data-original-title="Edit"></a> <a class="btn btn-box-tool fa fa-trash text-yellow" data-toggle="modal" data-target="#confirm-delete" title="Delete" data-href="http://bushfiresuperadmin.app/staff/delete/23">
								</a></td>
                            </tr>
                            <tr>
                                <td><a href="">Thoughts about Nothing</a></td>
                                <td>Sports</td>
                                <td>15-40 Yrs</td>
                                <td>Private</td>
                                <td>1234567</td>
                                <td class="text-center">
							 <span class="label label-success">Active</span>
							 </td>
							 <td class="text-center">
							<a class="btn btn-box-tool fa fa-pencil text-aqua" data-toggle="tooltip" title="" href="http://bushfiresuperadmin.app/staff/edit/23" data-original-title="Edit"></a> 
							<a class="btn btn-box-tool fa fa-trash text-yellow" data-toggle="modal" data-target="#confirm-delete" title="Delete" data-href="http://bushfiresuperadmin.app/staff/delete/23">
								</a></td>
                            </tr>
                            <tr>
                                <td><a href="">Stand Tall Through Everything</a></td>
                                <td>Blog</td>
                                <td>15-60 Yrs</td>
                                <td>Business</td>
                                <td>1234567</td>
                                <td class="text-center">

							 <span class="label label-success">Active</span>
							 </td>
							 <td class="text-center">
							<a class="btn btn-box-tool fa fa-pencil text-aqua" data-toggle="tooltip" title="" href="http://bushfiresuperadmin.app/staff/edit/23" data-original-title="Edit"></a> <a class="btn btn-box-tool fa fa-trash text-yellow" data-toggle="modal" data-target="#confirm-delete" title="Delete" data-href="http://bushfiresuperadmin.app/staff/delete/23">
								</a></td>
                            </tr>
                            <tr>
                                <td><a href="">Living What You Love</a></td>
                                <td>Nature</td>
                                <td>15-20 Yrs</td>
                                <td>Business</td>
                                <td>1234567</td>
                                <td class="text-center">
							 <span class="label label-success">Active</span>
							 </td>
							 <td class="text-center">
							<a class="btn btn-box-tool fa fa-pencil text-aqua" data-toggle="tooltip" title="" href="http://bushfiresuperadmin.app/staff/edit/23" data-original-title="Edit"></a> <a class="btn btn-box-tool fa fa-trash text-yellow" data-toggle="modal" data-target="#confirm-delete" title="Delete" data-href="http://bushfiresuperadmin.app/staff/delete/23">
								</a></td>
                            </tr>
                        </tbody>
				</table>
				<!-- app/views/includes/pagination.blade.php -->
<div class="pagination clearfix">
   
       		<input type="hidden" name="page" id="page" value="">
</div>

 			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
	<!-- /.content -->
</div>
@stop