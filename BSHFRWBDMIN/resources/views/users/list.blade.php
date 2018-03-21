@extends('layouts.default') 
@section('title') Business Admin @stop 
@section('content')

<div id="businessadminprochannel" class="content-wrapper">
	<!-- Content Header (Page header) -->
	

	<div class="box-header with-border">
	   @include('includes.messages')
	</div>
	<section id="fullreports"  class="content-header">
			  <ul class="nav nav-pills" id="reportstabs">
			    <li class="active"><a data-toggle="pill" href="#buisinessadmin">Business Admins</a></li>
			    @permission('list-paid-channels')
			    	<li><a data-toggle="pill" href="#prochannel">Paid Channel</a></li>
			    @endpermission
			    @permission('list-sponsored-channels')
			    <li><a data-toggle="pill" href="#sponsoredchannel">Sponsored Channel</a></li>
			    <li><a data-toggle="pill" href="#emailsetting">Email Settings</a></li>
			  	@endpermission
			  </ul>
	</section>


	<section class="content tab-content">
	<div id="buisinessadmin" class="tab-pane fade in active">	
		<div class="box box-info">
			<div class="box-header with-border">
			
				<h3 class="box-title">Total Business Users: {{count($allBusinessUsers)}}</h3>			

				@permission('create-business-user')
					<h3><a class="btn btn-success" href="{{ url('admin/add') }}"> Create New Account</a></h3>
				@endpermission
				<!-- <a href="{{url('admin/add')}}" class="btn btn-sm btn-info btn-flat pull-right "><i class="fa fa-plus"></i> Add Admin</a> -->
			</div>
			<div class="box-body">
				<!--@include('includes.search',['resetUrl' => '/sadmin'])-->
    			
				@if(!empty($data) && count($data)>0)
				{!!Form::hidden('totalcount',count($data),['id'=>'total_data_count'])!!}
				<table id="example1" class="table table-bordered table-hover stuff_table">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Email</th>
							<th>Mobile number</th>
							<th>No.of Channels</th>
							<th class="text-center">Channels</th>							
							<th class="text-center">Status</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=0; ?>
						@foreach($data as $user)
						<tr>
							<td>{{++$i}}</td>
							<td>{{ucfirst($user->username)}}</td>
							<td>{{$user->email}}</td>
							<td>{{$user->mobile_number}}</td>
							<td>{{ $user->totalNOOfBusinessChannels }}</td>
		                	<td class="text-center">
		                		<span class="label label-success" style="cursor:pointer" data-toggle="modal" data-target="#modal{{$i}}"> View channels </span>
		                	@permission('create-channel')
		                		<span class="createChannelModel label label-primary" style="cursor:pointer; margin: auto 10px; background-color: #3c8dbc !important;" 
		                		data-toggle="modal" data-target="#createmodal" data-mobile="{{$user->mobile_number}}"> Create </span>
		                	@endpermission
		                	</td>
							@if($user->is_active == 1)
							<td class="text-center">
							 <span class="label label-success">Active</span>
							 </td>
							 @else
							 <td class="text-center">
							 <span class="label label-error">Inactive</span>
							</td>
							 @endif
							<td class="text-center">
								@permission('edit-business-user')
								<a class="btn btn-primary" href="{{url('admin/edit/'.$user->id.'')}}">Edit</a>
								@endpermission
								<!-- @permission('delete-business-user')
								<a class="btn btn-danger" data-href="{{url('admin/delete/'.$user->id)}}" data-toggle="modal" data-target="#confirm-delete">Delete</a>
								@endpermission -->
								<!-- <a class="btn btn-box-tool fa fa-pencil text-aqua" data-toggle="tooltip" title="Edit"
									href="{{url('admin/edit/'.$user->id.'')}}"></a>
								<a class="btn btn-box-tool fa fa-trash text-yellow" data-toggle="modal" data-target="#confirm-delete" title="Delete"
									data-href="{{url('admin/delete/'.$user->id)}}"> -->
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				 @else
				<table id="example2" class="table table-hover">
				  <tr>
				     <td>{{trans('admin.no_records')}}</td>
				  </tr>
				</table>
				@endif
			</div>
			<!-- /.box-body -->
		</div>
	</div>
	<div id="prochannel" class="tab-pane fade">
		<div class="box box-info">
			<div class="box-header with-border">
			
				<h3 class="box-title">Total Paid Channel: {{count($paidChannels)}}</h3>			

			</div>
			<div class="box-body">
				 <!--@include('includes.search',['resetUrl' => '/sadmin'])--> 
    			
				@if(!empty($paidChannels) && count($paidChannels)>0)
				<!-- {!!Form::hidden('totalcount',count($sponsoredChannels),['id'=>'total_data_count'])!!} -->
				<table id="example3" class="table table-bordered table-hover stuff_table">
					<thead>
						<tr>
							<th>No</th>
							<th>Business Name</th>
							<th>Channel Type</th>
							<th>Channel Name</th>
							<th class="text-center table100">Total Subscribed User Count</th>
							<th class="text-center table100">Total No. of Content</th>	
							<!-- <th class="text-center table100">Total Content View</th> -->
							<!-- <th class="text-center">Status</th> -->
						</tr>
					</thead>
					<tbody>
						<?php $s = 1; ?>
						@foreach($paidChannels as $schannel)
						<tr>
							<td>{{ $s++ }}</td>
							<td>{{ $schannel['userName'] }}</td>
							<td>Paid Channel</td>
							<td><a href="{{ url('channels').'/'.$schannel['channelId'] }}" target="_blank">{{ $schannel['channelName'] }}</a> 
								@if($schannel['contractFilePath'] != null)
								<a href="{{ API_BASE_URL .'content/getContent/'.$schannel['contractFilePath'] }}" class="pull-right">
									<i class="fa fa-arrow-circle-down fa-lg" title="Download contract doc"></i></a>
								@endif
							</td>
							<td class="text-center">{{ $schannel['subscribersCount'] }}</td>
		                	<td class="text-center">{{ $schannel['totalContentCount'] }} </td>
							<!-- <td class="text-center">665</td> -->
							<!-- <td class="text-center">
							    <div class="switch-field-paid">
							      <input type="radio" id="switch_left" name="switch_2" value="yes" checked/>
							      <label for="switch_left">Active</label>
							      <input type="radio" id="switch_right" name="switch_2" value="no" />
							      <label for="switch_right">Inactive</label>
							    </div>
							</td> -->
						</tr>
						@endforeach
					</tbody>
				</table>
				<!-- ppagination -->
				@else
				<table id="example4" class="table table-hover">
				  <tr>
				     <td>{{trans('admin.no_records')}}</td>
				  </tr>
				</table>
				@endif
			</div>
			<!-- /.box-body -->
		</div>
	</div>
	<div id="sponsoredchannel" class="tab-pane fade">
		<div class="box box-info">
			<div class="box-header with-border">
			
				<h3 class="box-title">Total Sponsored Channel: {{count($sponsoredChannels)}}</h3>			

			</div>
			<div class="box-body">
				 <!--@include('includes.search',['resetUrl' => '/sadmin'])--> 
    			
				@if(!empty($sponsoredChannels) && count($sponsoredChannels)>0)
				<!-- {!!Form::hidden('totalcount',count($data),['id'=>'total_data_count'])!!} -->
				<table id="example5" class="table table-bordered table-hover stuff_table">
					<thead>
						<tr>
							<th>No</th>
							<th>Business Name</th>
							<th>Channel Type</th>
							<th>Channel Name</th>
							<th class="text-center table100">Total Subscribed User Count</th>
							<th class="text-center table100">Total No. of Content</th>	
							<!-- <th class="text-center table100">Total Content View</th> -->
							<!-- <th class="text-center">Status</th> -->
						</tr>
					</thead>
					<tbody>
						<?php $p = 1; ?>
						@foreach($sponsoredChannels as $pchannel)
						<tr>
							<td>{{ $p++ }}</td>
							<td>{{ $pchannel['userName'] }}</td>
							<td> Sponsored channel</td>
							<td><a href="{{ url('channels').'/'.$pchannel['channelId'] }}" target="_blank">{{ $pchannel['channelName'] }}</a>
								@if($pchannel['contractFilePath'] != null)
								<a href="{{ API_BASE_URL .'content/getContent/'.$pchannel['contractFilePath'] }}" class="pull-right">
									<i class="fa fa-arrow-circle-down fa-lg" title="Download contract doc"></i></a>
								@endif
							</td>
							<td class="text-center">{{ $pchannel['subscribersCount'] }}</td>
		                	<td class="text-center">{{ $pchannel['totalContentCount'] }} </td>
							
						</tr>
						@endforeach
					</tbody>
				</table>
				
				@else
				<table id="example6" class="table table-hover">
				  <tr>
				     <td>{{trans('admin.no_records')}}</td>
				  </tr>
				</table>
				@endif
			</div>
			<!-- /.box-body -->
		</div>
	</div>

	<div id="emailsetting" class="tab-pane fade">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">Email Setting</h3>			
			</div>
			<div class="box-body row">
				
					<form id="mail-id" action="{{ url('channels/updateSettings') }}" method="post">
						<div class="col-md-12">
							<input type="hidden" name="settingId" value="{{ $settings['settingId'] }}" />

							<label>1. Send auto reminder to User before end date
								<select name="daycount">
									<?php 
									for($k=1; $k <= 10; $k++){
										$select = ($k == $settings['value'])?'selected':'';
										echo '<option value="'.$k.'" '.$select.'>'.$k.' Day(s)</option>';
									}
									?>
								</select>
							</label>
						</div>
						<!-- <div class="col-md-12">
							<label style="vertical-align: top">2. Content of email </label>
								<textarea rows="6" cols="50"></textarea>							
						</div> -->
						<div class="col-md-5">
							<div class="pull-right">
								<!-- <button class="btn-primary btn-lg">Edit</button> -->
								<button class="btn-primary btn-lg">Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- /.box-body -->
		</div>

	</div>
		<!-- /.box -->
		<?php $j=0; ?>
		@foreach($data as $myuser)
		<?php $s=1; ?>
		<div class="modal fade bd-example-modal-lg" id="modal{{++$j}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content channelContent" style="overflow-x: hidden; overflow-y: scroll; width: 98% !important;">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Channel list of {{ $myuser->username }}</h4>
		      </div>
		      <div class="modal-body channelbody chnlist">

		      	<div class="" role="alert" id="reminderMsg" style="display:none">
		            <p></p>
		        </div>

		      	<table class="table table-bordered" id="modal_table_{{$j}}">
                            <thead>
						
		      		<tr class="thead">
		      			<th class="text-center width10" style="width: 10px;">No</th>
		      			<th class="text-center">Channel type</th>
		      			<th class="text-center">Name</th>
		      			<th class="text-center width10">Subscribers count</th>
		      			<th class="text-center width10">Total view count</th>
		      			<th class="text-center width10">Total Like</th>
		      			<!-- <th class="text-center width10">Total Dislike</th> -->
		      			<th class="text-center width10">Total Comment</th>
		      			<th class="text-center width10">Start Date</th>
		      			<th class="text-center width10">End Date</th>
		      			<th class="text-center width10">Status</th>
		      			<th class="text-center width150">Reminder Status</th>
		      			<th class="text-center">Action</th>
		      		</tr>
                            </thead>
						
		      		@if($myuser->businesschannels)
			      	@foreach($myuser->businesschannels as $channel)
			      		<tr>
			      			<td class="text-center">{{ $s++ }}</td>
			        		<td class="text-center">{{ ($channel['channelType'] == 'PP')?'Paid channel':'Sponsored Channel' }}</td>
			        		<td class="text-center"><a href="{{ url('channels').'/'.$channel['channelId'] }}" target="_blank">{{ $channel['channelName'] }}</a></td>
		      				<td class="text-center">{{ $channel['subscribedUsersCount'] }}</td>
		      				<td class="text-center">{{ $channel['totalViews'] }}</td>
		      				<td class="text-center">{{ $channel['totalLikes'] }}</td>
		      				<!-- <td class="text-center"></td> -->
		      				<td class="text-center">{{ $channel['totalComments'] }}</td>

		      				@if($channel['startDate'] != null && $channel['endDate'] != null)
			      			<td class="text-center">
			      				{{Carbon\Carbon::parse($channel['startDate'])->format('d M Y') }}
			      			</td>
			      			<td class="text-center">
			      				{{Carbon\Carbon::parse($channel['endDate'])->format('d M Y') }}
			      			</td>
			      			@else
			      				<td class="text-center">-</td>
			      				<td class="text-center">-</td>
			      			@endif

			      			<td class="text-center">
			      				@if($channel['status'] == 'Active')
			      					<span class="green"> {{ $channel['status'] }} </span>
			      				@else
			      					<span class="red"> {{ $channel['status'] }} </span>
			      				@endif
			      			</td>
			      			<td class="text-center" style="padding: 0px;">	
			      				<p class="checklabel">Auto Reminder
			      					@if($channel['autoReminder'] == 1)
			      						<span class="glyphicon glyphicon-ok"></span>
			      					@else
			      						<span class="glyphicon glyphicon-ok grey"></span>
				      				@endif
				      			</p>
			      				<p class="checklabel checklabela">
			      					<?php 
			      					 	$totalReminderCount=5;
			      					 	$activeReminder = $totalReminderCount - $channel['mailReminderStatus'];
			      					 
				      					for($r = 0; $r < $channel['mailReminderStatus']; $r++){
				      						echo '<span class="glyphicon glyphicon-ok"></span>';
				      					}
				      					for($a = 0; $a < $activeReminder; $a++){
				      						echo '<span class="glyphicon glyphicon-ok grey"></span>';
				      					}
			      					?>
				      			</p>
			      				
			      			</td>

			      			<td class="text-center">
			      				<?php
			      				$validDate = 0;
			      				$endDate = date("Y-m-d", strtotime($channel['endDate']));
			      				$endDate = strtotime($endDate );
			      				$todayDate = strtotime(date("Y-m-d"));
			      				if($endDate >= $todayDate){ $validDate = 1;}
			      				?>
			      				@if($channel['autoReminder'] == 1 && $activeReminder > 0 && $validDate == 1)
				      				<button class="btn btn-primary" onclick="triggerReminder('{{ $channel['channelId'] }}')">Reminder</button>
				      			@else
				      				<button class="btn btn-primary" disabled>Reminder</button>
				      				<!-- <button class="btn btn-primary" onclick="triggerReminder('{{ $channel['channelId'] }}')">Reminder</button> -->
				      			@endif
			      			</td>
			      		
			      		</tr>

			      	@endforeach
			      	@else
			      		<tr><td colspan="8" class="text-center">Could not fetch channels</td></tr>
			      	@endif

		      	</table>
		      </div>
		      <div class="modal-footer">
		       
		      </div>
		    </div>
		  </div>
		</div>
		@endforeach

		<!-- Create modal -->
		<div class="modal fade bd-example-modal-lg" id="createmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content channelContent">
		      <div class="modal-header">
					<button type="button" class="close createChannelCancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title pull-left" id="myModalLabel">Create channel</h4>
		      </div>
		      <div class="modal-body channelbody">		      	
		      	<div class="row">

		      	<form name="form" id="channelform1" method="post" action="{{ url('channels/create/') }}" enctype="multipart/form-data" validate>

		      		<div class="col-md-3">
			      		<div id="fileup">

			      			<div>

							<span class="browse btn btn-warning input-lg layout1" type="button">Choose File</span>
							    <input type="file" name="image" class="file" required accept="image/*">

							    <input type="text" class="form-control input-lg layout1 layout2" disabled placeholder="Uploaded file">
							</div>
							<div class="layout1">
								<input type="hidden" name="userId" value="" id="userId">
								<select class="channelselect" name="ageGroup" required>
								   <option value="" disabled selected>Age Group</option>
								   @foreach($ageGroups as $ageGroup)
								   	<option value="{{ $ageGroup['ageGroupId'] }}">{{ $ageGroup['ageGroupDescription'] }}</option>
								   @endforeach
								</select>
							</div>
							<div class="layout1">
								<select class="channelselect" name="category" required>
								   <option value="" disabled selected>Category</option>
								   @foreach($categories as $category)
								   	<option value="{{ $category['categoryId'] }}">{{ $category['categoryName'] }}</option>
								   @endforeach
								</select>
							</div>
						</div>
		      		</div>
		      		<div class="col-md-9">
		      			<div class="" role="alert" id="msg" style="display:none">
				            <p></p>
				        </div>
		      			<h4 class="text-left">Channel type</h4>
						<div class="form-group text-left">
							<label class="mar-right"> <input type="radio" value="PP" name="channel_type" class="minimal" checked="" required> Paid channel
							</label> <label> <input type="radio" value="PS" name="channel_type" class="minimal" required>Sponsored channel
												</label>
						</div>

						<div class="form-group">
							<div class="col-md-6 channeldatetimepicker">
				                <div class='input-group date' id='datetimepicker1'>
				                    <input style=" pointer-events: none;" type='text' id="start_date" name="start_date" class="form-control" placeholder="Start Date DD-MM-YYYY" required/>
				                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
				                    </span>
				                </div>
							</div>
							<div class="col-md-6 channeldatetimepicker">
				                <div class='input-group date pull-right' id='datetimepicker1'>
				                    <input style=" pointer-events: none;" type='text' id="end_date" name="end_date" class="form-control" placeholder="End Date DD-MM-YYYY" required />
				                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
				                    </span>
				                </div>
							</div>
						</div>

						<div class="form-group">

							<input maxlength="50" id="textarea" name="title" required="" class="form-control text_box" placeholder="Channel name" name="name" type="text" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;">

							<span id="textarea_feedback" class="pull-right charectersleft">
						</div>
						<div class="form-group">
							<textarea maxlength="500" id="textarea1" name="description" required="" class="form-control text_box" placeholder="Channel description" name="name" type="text" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;"></textarea>
							<span id="textarea_feedback1" class="pull-right charectersleft">
						</div>
						<div class="form-group text-right">												
							<button type="submit" class="btn btn-warning chnasubmit">Create</button>
							<button type="button" class="btn btn-default chnasubmit createChannelCancel" data-dismiss="modal" aria-label="Close">Cancel</button>
						</div>	

		      		</div>
		      	</form>
		      	</div>
		      </div>
		    </div>
		  </div>
		</div>

	</section>
	<!-- /.content -->
	<!-- /.content -->
</div>
<script>
function triggerReminder(channelId)
{
	$.ajax({
	        url: '{{url("/channels/reminder")}}'+'/'+channelId,
	        type: 'get',
	        success: function(response)
	        {
	        	if(response == 1)
	        	{
	        		$("#reminderMsg").addClass('alert alert-success');
		        	$("#reminderMsg p").html('Reminder sent successfully!');
		        	$("#reminderMsg").show();
		        	location.reload();

	        	}else
	        	{	        		
	        		$("#reminderMsg").addClass('alert alert-danger');
		        	$("#reminderMsg p").html('Could not send reminder!');
		        	$("#reminderMsg").show();
	        	}
	        }
	    });
}

$(".createChannelCancel").click( function(){
	$("#channelform1")[0].reset();
});

$(document).on("click", ".createChannelModel", function () {
     var mobile_number = $(this).data('mobile');
     $("#channelform1 #userId").val( mobile_number );
     $("#msg").hide();
});

$("#textarea").blur(function() {
	var title = $("#textarea").val();
	if( $.trim(title) != '' && title.length >=4 )
	{		
		$("#msg").hide();

	}else{
		$("#msg").addClass('alert alert-danger');
		$("#msg p").html('Channel title should be more than 4 characters');
		$("#msg").show();
	} 
});

$("#channelform1").submit( function(event) {
	event.preventDefault();
	var startDate = ($('#start_date').val() ).replace('-','/');
	var endDate = ($('#end_date').val() ).replace('-','/');

	var d = new Date();
	var month = d.getMonth()+1;
	var day = d.getDate();
	var todayDate = d.getFullYear() + '/' +
	    (month<10 ? '0' : '') + month + '-' +
	    (day<10 ? '0' : '') + day;

	if( (startDate >= endDate) || (endDate <= todayDate) ){
	   $("#msg").addClass('alert alert-danger');
		$("#msg p").html("End date should be greater than start date and today's date");
		$("#msg").show();
		return false;
	}	
		
	$("#msg").hide();

	var formData = new FormData(this);
	$.ajax({ 
        url: '{{url("/channels/create")}}',
        type: 'post',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(response)
        {
        	console.log(response);
        	// return false;
        	if(response == 1){
        		$("#channelform1")[0].reset();
        		$("#msg").addClass('alert alert-success');
	        	$("#msg p").html('Channel has Created successfully!');
	        	$("#msg").show();
				// $('#createmodal').modal('show');
				location.reload();

			}else{
				$("#msg").addClass('alert alert-danger');
				$("#msg p").html(response);
				$("#msg").show();
				return false;
				
			}
        }
    });
	return false;
});

$(document).on('click', '.browse', function(){
  var file = $(this).parent().parent().parent().find('.file');
  file.trigger('click');
});
$(document).on('change', '.file', function(){
  $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
});

$(document).ready(function() {
    var text_max = 50;
    $('#textarea_feedback').html(text_max + ' characters left');

    $('#textarea').keyup(function() {
        var text_length = $('#textarea').val().length;
        var text_remaining = text_max - text_length;

        $('#textarea_feedback').html(text_remaining + ' characters left');
    });

        var text_max1 = 500;
    $('#textarea_feedback1').html(text_max1 + ' characters left');

    $('#textarea1').keyup(function() {
        var text_length1 = $('#textarea1').val().length;
        var text_remaining1 = text_max1 - text_length1;

        $('#textarea_feedback1').html(text_remaining1 + ' characters left');
    });
});

 $(function () {
   var bindDatePicker = function() {
		$(".date").datetimepicker({
        format:'YYYY-MM-DD',
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			}
		}).find('input:first').on("blur",function () {
			// check if the date is correct. We can accept dd-mm-yyyy and yyyy-mm-dd.
			// update the format if it's yyyy-mm-dd
			var date = parseDate($(this).val());

			if (! isValidDate(date)) {
				//create date based on momentjs (we have that)
				date = moment().format('YYYY-MM-DD');
			}

			$(this).val(date);
		});
	}
   
   var isValidDate = function(value, format) {
		format = format || false;
		// lets parse the date to the best of our knowledge
		if (format) {
			value = parseDate(value);
		}

		var timestamp = Date.parse(value);

		return isNaN(timestamp) == false;
   }
   
   var parseDate = function(value) {
		var m = value.match(/^(\d{1,2})(\/|-)?(\d{1,2})(\/|-)?(\d{4})$/);
		if (m)
			value = m[5] + '-' + ("00" + m[3]).slice(-2) + '-' + ("00" + m[1]).slice(-2);

		return value;
   }
   
   bindDatePicker();
 });

$(function() {
        var hash = window.location.hash;
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');

        $('.nav-pills a').click(function(e) {
            $(this).tab('show');
            var scrollmem = $('body').scrollTop();
            window.location.hash = this.hash;
            $('html,body').scrollTop(scrollmem);
        });
    });
    
    
    $(document).ready(function() {
        $('#example1').DataTable( {
            "bFilter": true,
            "lengthMenu": lengthMenu,
            "responsive": true,
            "order": [[0, 'asc']],
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [5,7]},
    //            {'visible': false, 'aTargets': [7]},
                {"bSearchable": false, "aTargets": [5,7]}
            ],
            "dom": 'lfrtipB',
            "oLanguage": {
                "sSearch": "Filter"
             },
            "buttons": [
                {"extend": 'csv', "exportOptions": {"columns": [ 0, 1, 2, 3, 4, 6]} },
                {"extend": 'excel', "exportOptions": {"columns": [ 0, 1, 2, 3, 4, 6]} },
            ],
            "iDisplayLength": DefaultDisplayLength,        
        } );
        $('#example3').DataTable( {
            "bFilter": true,
            "lengthMenu": lengthMenu,
            "responsive": true,
            "order": [[0, 'asc']],
    //        "aoColumnDefs": [
    //            {'bSortable': false, 'aTargets': [4,5]},
    //            {"bSearchable": false, "aTargets": [4,5]}
    //        ],
            "dom": 'lfrtipB',
            "oLanguage": {
                "sSearch": "Filter"
             },
            "buttons": [
                {"extend": 'csv', "exportOptions": {"columns": [ 0, 1, 2, 3,4,5]} },
                {"extend": 'excel', "exportOptions": {"columns": [ 0, 1, 2, 3,4,5]} },
            ],
            "iDisplayLength": DefaultDisplayLength,        
        } );
        $('#example5').DataTable( {
            "bFilter": true,
            "lengthMenu": lengthMenu,
            "responsive": true,
            "order": [[0, 'asc']],
    //        "aoColumnDefs": [
    //            {'bSortable': false, 'aTargets': [4]},
    //            {"bSearchable": false, "aTargets": [4]}
    //        ],
            "dom": 'lfrtipB',
            "oLanguage": {
                "sSearch": "Filter"
            },
            "buttons": [
                {"extend": 'csv', "exportOptions": {"columns": [ 0, 1, 2, 3,4,5]} },
                {"extend": 'excel', "exportOptions": {"columns": [ 0, 1, 2, 3,4,5]} },
            ],
            "iDisplayLength": DefaultDisplayLength,        
        } );   
    

    var kounter;
    var tmp_element;
        for(kounter = 1; kounter <= <?php echo $j; ?>; kounter++) { 

            var tmp_element = '#modal_table_'+kounter;
            var tbody = $(tmp_element+" tbody");
            if (tbody.children().length > 1) {
                $(tmp_element).DataTable( {
                    "bFilter": true,
                    "lengthMenu": lengthMenu_modal,
                    "responsive": true,
                    "order": [[0, 'asc']],
                    "aoColumnDefs": [
                        {'bSortable': false, 'aTargets': [10,11]},
                        {"bSearchable": false, "aTargets": [10,11]}
                    ],
                    "dom": 'frtipB',
                    "oLanguage": {
                        "sSearch": "Filter"
                     },
                    "buttons": [
                        {"extend": 'csv', "exportOptions": {"columns": [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9]} },
                        {"extend": 'excel', "exportOptions": {"columns": [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9]} },
                    ],
                    "iDisplayLength": DefaultDisplayLength_modal        
                } );
            }
        }

    } );
</script>
@stop

