@extends('layouts.default') 
@section('title') Roles @stop 
@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Access Level</h1>
		<ol class="breadcrumb">
			<li><a href="{{url('/admin')}}"><i class="fa fa-dashboard"></i>
					{{trans('common.menu.home')}}</a></li>
			<li class="active">Access Level</li>
		</ol>
	</section>
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
			@include('includes.messages')
				<h3 class="box-title">Access Level</h3>
					<button class='btn btn-sm bg-yellow cancel_btn pull-right'>{{trans('common.user.back')}}</button>
				
			</div>
			<div class="box-body">
			<p class="error choose-delete" style="display: none;">Sorry! your selection required to perfom the delete</p>
				
			
				@if(!empty($data) && count($data)>0)
				{!!Form::hidden('totalcount',count($data),['id'=>'total_data_count'])!!}
				
				<table id="example1" class="table table-hover">
					<thead>
						<tr>
							
							<th>Role Name</th>
							<th>Permissions</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $role)
						<tr>
							
							<td>{{ucwords($role->name)}}</td>
							<td>
								<?php $perms = explode(',', $role->permission); ?>
								@foreach($modules as $key=>$value)
									<?php if(in_array($key, $perms)){
										echo $value;
										if($key != end($perms)){echo ', ';}
									}
									 ?>
								@endforeach
							</td>
							
							<td class="text-center">
							  <a class="btn btn-box-tool fa fa-pencil text-green"
								data-toggle="tooltip" title="Edit"
								href="{{url('access/'.$role->id.'/edit')}}"></a> 
								</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@include('includes.pagination') @else
				<table id="example2" class="table table-hover">
				  <tr>
				     <td>{{trans('admin.no_records')}}</td>
				  </tr>
				</table>
				@endif
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
	<!-- /.content -->
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Send Notification</h4>
			</div>
			 {!!Form::open(['class'=>'form-notify'])!!}
			<div class="modal-body">
			 
			      <p class="text-error error" style="display: none"></p>
                  <textarea name="message" class="input-xlarge message form-control" maxlength="255" rows="2" 
                  columns="10" placeholder="Enter notification message"></textarea>
                   
			  
			</div>
			{!!Form::close()!!}
			<div class="modal-footer">
				 <input class="btn btn-warning" type="submit" value="Send" id="submit">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
			 
		</div>
	</div>
</div>
@yield('scripts')
<script>
$(document).ready(function () {
	$('.message').on('blur', function() {
		$(this).val($.trim($(this).val()));
    })
	$('#myModal').on('show.bs.modal', function(e) {
		$(this).find('.form-notify').attr('action', $(e.relatedTarget).data('href'));
		$(".form-notify").trigger('reset');
		if($(".text-error").length){
  			$(".text-error").css('display','none')
  		}
	})
	$("input#submit").click(function(){ 
	var error=false;
	if($('.message').val()=='' && $('.message').val().length<=0){
		    $('.text-error').css('display','block');
		    $('.text-error').text("The message field is required");
		    return false;
		    
	}
	if(($('.message').val()).length<3){
		 $('.text-error').css('display','block');
		    $('.text-error').text("The message field should contain atleast three characters");
		    return false;
	}
	if(error==false){
		$.ajax({
            type: "POST",
            dataType:"json",
            url:$('.form-notify').attr('action'), 
            data: $('.form-notify').serialize(),
            success: function(response){
            	if(response.error==0){
            		$(".form-notify").trigger('reset');
            		$('.notify-success').css('display','block');
	                $("#myModal").modal('hide'); //hide popup
	            }
            	else{
            		$('.notify-error').css('display','block');
            		 $("#myModal").modal('hide');
	                  setTimeout(function(){
	              		if($(".notify-error").length){
	              			$(".notify-error").css('display','none')
	              		}
	                  }, 3000);
	            }
            	 
            },
            error: function(){
            	 $("#myModal").modal('hide');
                  $('.notify-error').css('display','block');
                  setTimeout(function(){
              		if($(".notify-error").length){
              			$(".notify-error").css('display','none')
              		}
                  }, 3000);
            }
        });
	}
		
	});
	return false;
});
</script>
@stop
