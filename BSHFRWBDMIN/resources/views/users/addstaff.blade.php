@extends('layouts.default') 

@section('title')
	Add Business Admin
@stop

@section('content')
<style>
.listlabel label{
	margin-right: 5px;
	font-size: 13px;
	display: inline-block;
}
.modal-content{
	width: 40% !important;
	margin-top: 0 !important;
}
.modal-dialog{
	position: relative !important;
    width: auto !important;
    top: 30%;
}
.modal-header{
	border-bottom: 1px solid #eceeef !important;
}
#mobile{
	margin-left: 40px;
}
</style>
<div class="content-wrapper">
	<section class="content-header">
				<h1>Create New Account</h1>
				<!-- <ol class="breadcrumb">
					<li><a href="{{url('other/users')}}"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Create New Account</li>
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
						Form::open(['url'=>'admin/add','method'=>'POST','role'=>'form','class'=>'col-md-12
						box-body','files'=>'true'])!!}
									<div class="col-md-8">
										<div class="form-group">
											<div class="col-md-4">
												<label for="access">Role</label>
											</div>
											<div class="col-md-8">
												{!! Form::select('roles[]', $roles,[], array('required', 'class' => 'form-control','multiple','id'=>'role')) !!}
											</div>
										</div>
										<div class="form-group" id="listpermissions">
											<div class="col-md-4">
												<label for="access">Permissions</label>
											</div>
											<div class="col-md-8 listlabel">
												
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
												{!!Form::text('country_code',old('country_code'),['required', 'class'=>'text_box col-md-3 mobile', 'id'=>'ccode', 'placeholder'=>'91'])!!}
                                                                                                
                                                                                                
												{!!Form::text('mobile_number1',old('mobile_number1'),['required', 'class'=>'text_box col-md-8 mobile', 'id'=>'mobile', 'placeholder'=>'Mobile number'])!!}
												<!-- <span style="clear:both">Mobilenumber with countrycode (ex: 919787562356) </span> -->
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<label for="Email">Email</label>
											</div>
											<div class="col-md-8">
												{!!Form::email('email',old('email'),['required', 'class'=>'form-control text_box','placeholder'=>'Email'])!!}
											</div>
										</div>
										<!-- <div class="form-group" id="privateChannelBox" style="display:none;">
											<div class="col-md-4">
												<label for="status">Do you have Private Channel?</label>
											</div>
											<div class="col-md-8">
												<label class="mar-right"> <input type="radio" value="1" name="is_channel" class="minimal"> Yes
												</label> <label> <input type="radio" value="0" name="is_channel" class="minimal"> No
												</label>
											</div>
										</div> -->
										<!-- <div class="form-group" id="channels" style="display:none">
											<div class="col-md-4">
												<label for="access">Channel Name</label>
											</div>
											<div class="col-md-8">
												<select name="channel_id" class="form-control text_box">
													<option value="">Select Channel</option>
												</select>
											</div>
										</div> -->
										<!-- <div class="form-group" style="display:none">
											<div class="col-md-4">
												<label for="access">Access Level</label>
											</div>
											<div class="col-md-8">
												{!!Form::select('user_type',$user_type,'',['class'=>'form-control text_box'])!!}  
											</div>
										</div> -->
										<!-- 'required',  -->
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
									</div>
									<div class="col-md-12">												
										<div class="col-md-4">&nbsp;</div>
										<div class="col-md-8">
											<button type="submit"
												class="btn btn-primary bg-red btn-flat mar-right">Submit</button>

											@if(Request::is('other/users/create'))
												<button type="button" onclick="window.location='{{ route("users.index") }}'" class="btn btn-default btn-flat">Cancel</button>
											@elseif(Request::is('admin/add'))
												<button type="button"  onclick="window.location='{{ url("sadmin") }}'" class="btn btn-default btn-flat">Cancel</button>
											@else
												<button type="button"  onclick="window.location='{{ url("adUser") }}'" class="btn btn-default btn-flat">Cancel</button>
											@endif
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

<div class="modal fade" id="alertPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Please note it!
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span> </button></h5>
			</div>
			<div class="modal-body"><p  id="putmsg"></p></div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Cancel</a>
			</div>
		</div>
	</div>
</div>

<script>
$("#role").change(function(){
	var roleid = $(this).val();
	$.ajax({ 
	        url: '{{url("/getrole")}}'+'/'+roleid,
	        type: 'get',
	        success: function(result)
	        {
	        	if(result){
	        		$("#listpermissions .listlabel").html("");
	        		$.each(result, function( key, value ) {	        			
	        			var labels = '<label class="label label-success">'+ value.display_name +' </label> ';
	        			$("#listpermissions .listlabel").append(labels);
	        		});

	        		// if(roleid == 3){
	        		// 	$("input[name='is_channel']").attr("required","required");
	        		// 	$("#privateChannelBox").show();
	        		// }else{
	        		// 	$("input[name='is_channel']").removeAttr("required");
	        		// 	$("#privateChannelBox").hide();
	        		// }
	        	}else{
	        		var msg = 'Data not available';
	        		$("#listpermissions .listlabel").append(msg);
	        	}
	        }
	    });
});

$('.mobile').keypress(function (e) {
    var regex = new RegExp("^[0-9]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }
    e.preventDefault();
    return false;
});

/*
$("input[name='is_channel']").change(function(){    
    var mobile = $("#mobile").val();
    if(mobile == ''){
    	// alert('Please give the valid mobile number with countrycode');
    	$("#putmsg").html("Please give the valid mobile number with countrycode");
    	$("#alertPopup").modal('show');
    	return false;
    }

    if ($(this).val() === '1' && mobile != '') {

      	$.ajax
	    ({ 
	        url: '{{url("/channelByUser")}}',
	        data: {"mobile_number": mobile},
	        type: 'post',
	        success: function(result)
	        {
	        	if(result === '1'){
	        		// alert('User not found in Bushfire App');
	        		$("#putmsg").html("User not found in Bushfire App");
    				$("#alertPopup").modal('show');

	        		$("input[name='channel_id']").removeAttr("required");
	        		$("#channels").hide();
	        	}else if(result === '2'){
	        		// alert('User doesnot have any channel currently');
	        		$("#putmsg").html("User doesnot have any channel currently");
    				$("#alertPopup").modal('show');

	        		$("input[name='channel_id']").removeAttr("required");
	        		$("#channels").hide();
	        	}else{
	        		console.log(result);
	        		$("#channels select").html(result);
	        		$("input[name='channel_id']").attr("required","required");
	        		$("#channels").show();
	        	}
	            
	        }
	    });
      

    } else if ($(this).val() === '0') {
      $("#channels").hide();
      // alert('User should have channel to proceed further');
      $("#putmsg").html("User should have channel to proceed further");
      $("#alertPopup").modal('show');
    } 
    
});
*/
</script>
@stop