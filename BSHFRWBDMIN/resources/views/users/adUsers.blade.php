@extends('layouts.default') 
@section('title') Ad Users @stop
@section('content')
		<style type="text/css">
			.modal-body.channelbody{
				height: 400px;
				overflow: auto;
			}
			.modal-content.channelContent{
				width: 60% !important;
				margin-top: 0 !important;
			}
			.modal-dialog{
				position: relative !important;
				width: auto !important;
			}
			.thead{
				background-color: #d2d6de;
			}
		</style>
<div id="addaccount" class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section id="fullreports"  class="content-header">
			  <ul class="nav nav-pills" id="reportstabs">
			    <li class="active"><a data-toggle="pill" href="#addadmin">Ad Admins</a></li>
			    @permission('view-ads')
			    <li><a data-toggle="pill" href="#viewad">View Ad</a></li>
			    @endpermission
			  </ul>
	</section>
	<section class="content  tab-content">
	<div id="addadmin" class="tab-pane fade in active">
		<div class="box box-info">
			<div class="box-header with-border">
				@include('includes.messages')
				<!--<h3 class="box-title">Total Ad users : {{count($allAdUsers)}}</h3>-->

				@permission('create-ad-user')
					<h3><a class="btn btn-success" href="{{ url('adUser/add') }}"> Create New Account</a></h3>
				@endpermission
				
			</div>
			<div class="box-body">
				<!--@include('includes.search',['resetUrl' => '/adUser'])-->
    			
				@if(!empty($data) && count($data)>0)
				{!!Form::hidden('totalcount',count($data),['id'=>'total_data_count'])!!}
				<table id="example1" class="table table-bordered table-hover stuff_table">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Email</th>
							<th>Mobile number</th>
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
								@permission('edit-ad-user')
								<a class="btn btn-primary" href="{{url('adUser/edit/'.$user->id.'')}}">Edit</a>
								@endpermission
								<!-- @permission('delete-ad-user')
								<a class="btn btn-danger" data-href="{{url('adUser/delete/'.$user->id)}}" data-toggle="modal" data-target="#confirm-delete">Delete</a>
								@endpermission -->
															
								<!-- <a class="btn btn-box-tool fa fa-pencil text-aqua" data-toggle="tooltip" title="Edit"
									href="{{url('adUser/edit/'.$user->id.'')}}"></a>
								<a class="btn btn-box-tool fa fa-trash text-yellow" data-toggle="modal" data-target="#confirm-delete" title="Delete"
									data-href="{{url('adUser/delete/'.$user->id)}}"> -->
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
	<div id="viewad" class="tab-pane fade">
		<div class="box box-info">
			<div class="box-header with-border">

				<div class="" role="alert" id="msg" style="display:none">
		            <p></p>
		        </div>

				<!--<h3 class="box-title">Total Ad Request : {{ count($adsList) }}</h3>-->

			</div>
			<div class="box-body">
				 <!--@include('includes.search',['resetUrl' => '/adUser'])--> 
    			
				@if(!empty($adsList) && count($adsList)>0)
				
				<table id="example3" class="table table-bordered table-hover stuff_table">
					<thead>
						<tr>
							<th class="table70">No</th>
							<th class="table70">Start Date / End Date</th>
							<th class="table160">Title</th>
							<th class="table200">Category</th>
							<th class="table160">Age group</th>
							<th class="table60">Files</th>
							<th class="table60 text-center">Amount Paid</th>
							<!-- <th>Status</th> -->
							<th class="text-center table160">Action</th>
						</tr>
					</thead>
					<tbody>
                                            <?php $j= 0;?>
						@foreach($adsList as $list)
						<tr>
							<td class="table70">{{ ++$j }}</td>
							<td class="table70">{{ $list['adStartDate'] }} - {{ $list['adEndDate'] }}</td>
							<td class="table160">{{ $list['contentTitle'] }}</td>
							<td class="table200">
								<?php
									$category = array_column($list['categories'], 'categoryName');
									$categories = implode(', ', $category);
									echo $categories;
								?>
							</td>
							<td class="table160">
								<?php
									$ageGroups = array_column($list['ageGroups'], 'ageGroupDesc');
									$groups = implode(', ', $ageGroups);
									echo $groups;
								?>
							</td>
							<td class="table60">{{ $list['contentType'] }}</td>
							<td class="table60 text-center">{{ $list['amount'] }}</td>
							<!-- <td>{{ ($list['isActive'] == 1)?'Active':'Inactive' }}</td> -->
							<td class="text-center table160">
							<?php $today = Carbon\Carbon::now()->format('d-m-Y');
								if($list['status'] == 'APPROVED' || $list['status'] == 'REJECTED'){
									echo '<span class="label label-success">'.$list['status'].'</span>';
								}
								elseif(strtotime($list['adEndDate']) >= strtotime($today) ){
							?>
								<a class="btn btn-success" href="javascript:void(0);" id="ap_{{ $list['adId'] }}" onclick="approveAd('{{ $list['adId'] }}');">Approve</a>
								<a class="btn btn-danger" data-href="" data-toggle="modal" onclick="rejectAd('{{ $list['adId'] }}');" href="javascript:void(0)">Reject</a>
							<?php }else{
								echo "Expired";
							} ?>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
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
		<!-- /.box -->
	</section>
	<!-- /.content -->
	<!-- /.content -->
</div>

<script>
$(function(){
		  var hash = window.location.hash;
		  hash && $('ul.nav a[href="' + hash + '"]').tab('show');

		  $('.nav-pills a').click(function (e) {
		    $(this).tab('show');
		    var scrollmem = $('body').scrollTop();
		    window.location.hash = this.hash;
		    $('html,body').scrollTop(scrollmem);
		  });
		});
		
function approveAd(adID){
	$("#ap_"+adID).attr('disabled','disabled');

	$.ajax({ 
        url: '{{url("ad/approve")}}'+'/'+adID,
        type: 'get',        
        success: function(response)
        {
        	console.log(response);
        	if (response == 1) {
        		$("#msg").addClass('alert alert-success');
	        	$("#msg p").html('Ad Approved successfully!');
	        	
        	}else{
        		$("#msg").addClass('alert alert-danger');
	        	$("#msg p").html('Please try later');
        	}
        	$("#msg").show();
        	location.reload();
        }
    });
}

function rejectAd(adID){
	$("#rej_"+adID).attr('disabled','disabled');

	$.ajax({
        url: '{{url("ad/reject")}}'+'/'+adID,
        type: 'get',
        success: function(response)
        {
        	console.log(response);
        	if (response == 1) {
        		$("#msg").addClass('alert alert-success');
	        	$("#msg p").html('Ad Rejected successfully!');
	        	
        	}else{
        		$("#msg").addClass('alert alert-danger');
	        	$("#msg p").html('Please try later');
        	}
        	$("#msg").show();
        	location.reload();
        }
    });
}

    $(document).ready(function() {
        $('#example1').DataTable( {
            "bFilter": true,
            "lengthMenu": lengthMenu,
            "responsive": true,
            "order": [[0, 'asc']],
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [5]},
    //            {'visible': false, 'aTargets': [7]},
                {"bSearchable": false, "aTargets": [5]}
            ],
            "dom": 'lfrtipB',
            "oLanguage": {
                "sSearch": "Filter"
             },
            "buttons": [
                {"extend": 'csv', "exportOptions": {"columns": [ 0, 1, 2, 3, 4]} },
                {"extend": 'excel', "exportOptions": {"columns": [ 0, 1, 2, 3, 4]} },
            ],
            "iDisplayLength": DefaultDisplayLength,        
        } );
        $('#example3').DataTable( {
            "bFilter": true,
            "lengthMenu": lengthMenu,
            "responsive": true,
            "order": [[0, 'asc']],
//            "aoColumnDefs": [
//                {'bSortable': false, 'aTargets': [6]},
//                {"bSearchable": false, "aTargets": [6]}
//            ],
            "dom": 'lfrtipB',
            "oLanguage": {
                "sSearch": "Filter"
             },
            "buttons": [
                {"extend": 'csv', "exportOptions": {"columns": [ 0, 1, 2, 3,4,5,6]} },
                {"extend": 'excel', "exportOptions": {"columns": [ 0, 1, 2, 3,4,5,6]} },
            ],
            "iDisplayLength": DefaultDisplayLength,        
        } );
    } );
</script>
@stop

