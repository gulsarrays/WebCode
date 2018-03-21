@extends('layouts.default')
 @section('title') Reports @stop 

@section('content')
	<div class="content-wrapper" id="fullreports" style="min-height: 678px;">
		<div class="box-header with-border">
			@include('includes.messages')
		  
			<div id="delete-alert" class="alert alert-danger" role="alert" style="display:none">
			    <button type="button" class="close" data-dismiss="alert" aria-label="Close">    
			        <span aria-hidden="true">&times;</span>
			    </button> 
			    <p></p>			
			</div>
		</div>

		<section class="content-header">
			  <ul class="nav nav-pills" id="reportstabs">
			    <li class="active"><a data-toggle="pill" href="#reports">Reports</a></li>
			    <li><a data-toggle="pill" href="#reportstype">Reports Type</a></li>
			  </ul>
		</section>

		<div class="tab-content">
			<!-- Reports Tab -->
			<div id="reports" class="tab-pane fade in active">
			    <section class="content">
			    	<div class="box box-info">
						
						<div class="box-body">
						
						<div><a href="javascript:void(0)" class="btn btn-danger reportdelete">Delete</a></div>
						
						<table id="listReport" class="table table-bordered table-hover stuff_table">
							<thead>
								<tr>
									<th>No</th>
									<th>Content Title</th>
									<th>Channel Name</th>
									<th>Report Type</th>
									<th>Comment</th>
									<th>Reported By</th>
									<th>Date</th>
								</tr>
							</thead>

							<tbody>
								@if($reports)
								<?php $i=0; ?>
								@foreach($reports as $report)
									<tr>
										<td>
											<input class="selectme" type="checkbox" name="checkbox" value="{{ $report['contentId'] }}" data-cmtid="{{ $report['userCommentId'] }}"/>
											{{++$i}}</td>
										<td>
											<a data-toggle="modal" data-target="#showContentmodal"
                                			onclick="getContent('{{ $report['contentId'] }}');">
												{{ $report['contentTitle'] }}
											</a>
										</td>

										<td>{{ ($report['channelType'] == 'B')?'Business channel':'Private channel' }}
											<br>
											{{ $report['channelTitle'] }}
										</td>
										<td><?php 
											foreach($report['commentCategories'] as $categories){
												echo $categories['userCommentsCategoryDesc'].'<br>';
											}
										?>
										</td>
										<td>{{ $report['commenterComment'] }}</td>
										<td>{{ $report['commenterUserName'] }}</td>
										<td>
											<!-- {{ Carbon\Carbon::parse($report['createdDate'])->format('jS F Y') }} -->
											{{Carbon\Carbon::parse($report['createdDate'])->format('jS M Y') }}
										</td>
									</tr>
								@endforeach
								@else
									<tr><td colspan="7" class="text-center">No Reports till now!</td></tr>
								@endif
							</tbody>
						</table>
							
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</section>
			</div>
			<!-- Reports Tab ends-->

			<!-- Reports Type Tab -->
			<div id="reportstype" class="tab-pane fade">
				<section class="content">
			    	<div class="box box-info">

			    		<div class="box-header with-border">                
							<h4>Total Report Types :{{ count($reportTypes) }}</h4>
							<div><a class="btn btn-success addreports" href="reports/create">+ Add Reports</a></div>			    		
						</div>

						<div class="box-body">

						<table id="listReportType" class="table table-bordered">
							<thead>
								<tr>
									<th>No</th>
									<th>List of Reports</th>
									<th class="text-center">Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $j=1; ?>
								@foreach($reportTypes as $types)
								<tr>
									<td>{{ $j++ }}</td>
									<td>{{ $types['userCommentsCategoryDesc'] }}</td>
									<td class="text-center">
										@if($types['isActive'] == 1)
										<span class="label label-success">Active</span>
										@else
										<span class="label label-error">In Active</span>
										@endif
									</td>
									<td class="text-center">
										<a class="btn btn-box-tool fa fa-pencil text-aqua" href="{{ url('reports').'/'.$types['userCommentsCategoryId'].'/edit' }}"></a>
										<!-- <a class="btn btn-box-tool fa fa-trash-o text-aqua" data-href="{{ url('reports/delete/').'/'.$types['userCommentsCategoryId'] }}" data-toggle="modal" data-target="#confirm-delete"></a> -->
									</td>
								</tr>
								@endforeach	

							</tbody>
						</table>
							
						</div>
					</div>
				</section>
			</div>
			<!-- Reports Type Tab ends -->
		</div>
    </div>

	<div class="modal fade" id="showContentmodal" role="dialog">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content">
		    <div class="modal-header">
		      <button type="button" class="close" data-dismiss="modal">&times;</button>
		      <h4 class="modal-title" id="title"></h4>
		      <hr style="margin-bottom: 0px;">
		    </div>
		    <div class="modal-body" style="padding: 0px 15px;">
		        <img class="modal-img" style="display:none" id="img" src="" class="img-responsive">
		        
		        <video style="display:none;background: url(../assets/img/video_icon.png) no-repeat center;" 
		        width="550" height="400" preload="auto" poster=""
		         id="video" src="" controls="true" class="img-responsive" width="100%"></video>
		        
		        <audio class="modal-img" id="audio" controls="true" src="" style="display:none;">
		        </audio>

		        <p class="modalcontent" id="desc" style="margin-top:15px;"></p>
		        <hr style="margin-bottom: 0px;">
		    </div>
		    <div class="modal-footer">
		      <!-- <p class="modalcontent" id="desc"></p> -->
		    </div>
		  </div>
		</div>
	</div>

    <script>



		$(function(){
			$("#btn-ok1").click( function() {
				$("#confirm-delete").modal('hide');
				var jsonObj = [];
				$(".selectme:checked").each(function() {
					var arr = {};
					arr['contentId'] = $(this).val();
					arr['userCommentId'] = $(this).attr("data-cmtid");
					jsonObj.push(arr);
				});
				deleteContent(jsonObj);
			});

			  var hash = window.location.hash;
			  hash && $('ul.nav a[href="' + hash + '"]').tab('show');

			  $('.nav-pills a').click(function (e) {
			    $(this).tab('show');
			    var scrollmem = $('body').scrollTop();
			    window.location.hash = this.hash;
			    $('html,body').scrollTop(scrollmem);
			  });
		});

		$(".reportdelete").on('click', function(e) {

			var jsonObj = [];
			$(".selectme:checked").each(function() {
				var arr = {};
				arr['contentId'] = $(this).val();
				arr['userCommentId'] = $(this).attr("data-cmtid");
				jsonObj.push(arr);
			});
			console.log(jsonObj);
			console.log(JSON.stringify(jsonObj));

			if(Object.keys(jsonObj).length <1)
			{
				$("#delete-alert").addClass("alert alert-danger");
				$("#delete-alert p").html("Please select some content to delete");
				$("#delete-alert").show();
			}
			else {
				$("#delete-alert").hide();				
				$("#confirm-delete").modal('show');				
			}
		});

		function deleteContent(ids){
			$.ajax({
			  	url : "{{ API_BASE_URL.DELETE_REPORT_CONTENT }}", //+"?contentId="+ids,
			    contentType: "application/json",
			    // dataType : "json",
			    headers: { "Content-Type":"application/json","Accept": "application/json" },
			    type : 'DELETE',
			    data: JSON.stringify(ids),
			    beforeSend : function( xhr ) {
			        xhr.setRequestHeader( "Authorization", "BEARER " + "{{ session('jwt_token') }}" );
			    },
			    success : function (data) {
			     	console.log(data);
			     	$("#delete-alert").addClass("alert alert-success");
					$("#delete-alert p").html("Deleted successfully");
					$("#delete-alert").show();
			     	location.reload();
			     	// return false;
			    },
			    error : function (data, errorThrown) {
			     	$("#delete-alert").addClass("alert alert-danger");
					$("#delete-alert p").html("Couldnot delete the content");
					$("#delete-alert").show();
			     	// return false;
			    }
			});
		}

		function getContent(contentId)
		{
		    $.ajax({ 
		        url: '{{url("/getContent")}}'+'/'+contentId,
		        type: 'get',
		        success: function(response)
		        {
		            //
		            if(response == 0)
		            {
		                console.log('no data');
		            }else{

		                console.log(response);
		                var result = response.data.item;
		                var title = result.contentTitle;
		                var type = result.contentType;                

		                if(result.contentDescription != null && result.contentDescription !=""){
		                    var desc = result.contentDescription;
		                }else{
		                    var desc = result.contentText;
		                }
		                
		                var contentpath = "{{API_BASE_URL.'content/getContent/'}}"+result.contentPath;                
		                
		                if(result.contentType == "text"){
		                    $("#desc").html(result.contentText);

		                    $("#video").hide();
		                    $("#img").hide();
		                    $("#audio").hide();
		                }
		                else if(type.indexOf('video') != -1)
		                {
		                    var contentpath = "{{API_BASE_URL.'content/getContent/'}}"+result.contentPath;
		                    $("#video").attr("src",contentpath);
		                    $("#video").show();
		                    $("#img").hide();
		                    $("#audio").hide();
		                }
		                else if(type.indexOf('audio') != -1) // == 'audio/mpeg' 
		                {
		                    var contentpath = "{{API_BASE_URL.'content/getContent/'}}"+result.contentPath;
		                    $("#audio").attr("src",contentpath);
		                    $("#audio").show();
		                    $("#video").hide();
		                    $("#img").hide();

		                }else
		                {
		                    var contentpath = "{{API_BASE_URL.'content/getContent/'}}"+result.contentThumbnailPath;
		                    $("#img").attr("src",contentpath);                    
		                    $("#img").show();
		                    $("#audio").hide();
		                    $("#video").hide();
		                }

		                $("#title").html(title);
		                $("#desc").html(desc);

		            }
		            
		        }
		    });
		}
    $(document).ready(function() {
        $('#listReport').DataTable( {
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
                {"extend": 'csv', "exportOptions": {"columns": [ 0, 1, 2, 3, 4, 5, 6]} },
                {"extend": 'excel', "exportOptions": {"columns": [  0, 1, 2, 3, 4, 5, 6]} },
            ],
            "iDisplayLength": DefaultDisplayLength,
        } );
        $('#listReportType').DataTable( {
            "bFilter": true,
            "lengthMenu": lengthMenu,
            "responsive": true,
            "order": [[0, 'asc']],
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [3]},
                {"bSearchable": false, "aTargets": [3]}
            ],
            "dom": 'lfrtipB',
            "oLanguage": {
                "sSearch": "Filter"
             },
            "buttons": [
                {"extend": 'csv', "exportOptions": {"columns": [ 0, 1, 2]} },
                {"extend": 'excel', "exportOptions": {"columns": [  0, 1, 2]} },
            ],
            "iDisplayLength": DefaultDisplayLength,
        } );
    } );
    </script>
@endsection