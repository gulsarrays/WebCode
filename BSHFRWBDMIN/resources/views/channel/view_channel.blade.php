@extends('layouts.default') 
@section('title') Channel uploads @stop 
@section('content')

<div id="channelDetail" class="content-wrapper">

<section class="content tab-content">
	<div id="buisinessadmin" class="tab-pane fade in active">	
			<div class="box box-info">
					<div class="box-header with-border">
					@include('includes.messages')
						<h3 class="box-title">Total no.of content: {{count($channelData)}}</h3>				
					</div>
					<div class="box-body" style="min-height: 200px;">
				<!-- Gallery added -->

				<div class="container" id="channel-gallery">
					<div class="row">
						<?php $i=0; ?>
						@if($channelData)
						@foreach($channelData as $channel)
						<?php $i++; ?>
						<div class="col-md-4 gallery-box">
						<a data-toggle="modal" data-target="#viewmodal{{$i}}" onclick="getComments('{{ $channel['contentId'] }}','ulid{{$i}}');">
							<?php 
							if($channel['contentType'] == 'video/mp4' || 
								$channel['contentType'] == 'video/quicktime'){
							?>
								<img class="icon preview-icon" src="../assets/img/video_icon_small.png">
								<img src="../assets/img/channel-video-icon.png" width="250" height="160">
							
							<?php }
							else if($channel['contentType'] == 'audio/mpeg' || 
								$channel['contentType'] == 'audio/mp3' || 
								$channel['contentType'] == 'audio/x-wav'){
							?>
								<img class="icon preview-icon" src="../assets/img/audio_icon.png">
								<img src="../assets/img/audio.png"
							width="250" height="160">
							
							<?php }
							else if($channel['contentType'] == 'image/jpeg' ||
              						$channel['contentType'] == 'image/jpg' || 
              						$channel['contentType'] == 'image/png'){
							?>							
								<img class="icon preview-icon" src="../assets/img/img_icon.png">
								<img src="{{API_BASE_URL.'content/getContent/'.$channel['contentPath'] }}"
							width="250" height="160">
							
							<?php }
							else{
							?>
								<img class="icon preview-icon" src="../assets/img/text_icon.png">
								<img src="../assets/img/text.png"
							width="250" height="160">
							
							<?php } ?>
							
							<div class="gallery-caption">{{ $channel['contentTitle'] }}</div>
						</a>
						</div>

						<!-- Gallery Modal -->
	  <div class="modal fade detailmodal" id="viewmodal{{$i}}" role="dialog">
	    <div class="modal-dialog channel-gallery-modal">
	    
	      <!-- Gallery Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" onclick="mediacontrol('content{{$i}}')">&times;</button>
	          <h4 class="modal-title">{{ $channel['contentTitle'] }}</h4>
	        </div>
	        <hr>
	        <div class="modal-body">
	         <div class="msg" role="alert" id="" style="">
                <p></p>
            </div>

	          <?php 
					if($channel['contentType'] == 'video/mp4' || 
						$channel['contentType'] == 'video/quicktime'){
					?>
						<video class="modal-img" id="content{{$i}}" width="550" height="400" preload="auto" poster="" src="{{ API_BASE_URL.'content/getContent/'.$channel['contentPath'] }}" controls="true" 
						style="background: url(../assets/img/video_icon.png) no-repeat center;">
				        Your browser does not support the video tag.
				        </video>
				        <!--  loop="true" -->
					
					<?php }
					else if($channel['contentType'] == 'audio/mpeg' || 
						$channel['contentType'] == 'audio/mp3' || 
						$channel['contentType'] == 'audio/x-wav'){
					?>
						<audio class="modal-img" id="content{{$i}}" controls="true" src="{{API_BASE_URL.'content/getContent/'.$channel['contentPath'] }}">
        				</audio>
					
					<?php }
					else if($channel['contentType'] == 'image/jpeg' ||
      						$channel['contentType'] == 'image/jpg' || 
      						$channel['contentType'] == 'image/png'){
					?>	
						<img class="modal-img" src="{{API_BASE_URL.'content/getContent/'.$channel['contentPath'] }}"
					>
					<!-- width="250" height="160" -->
					
					<?php }
					else{
					?>
						<div class="description">
							{{ $channel['contentText'] }}
						</div>
					
				<?php } ?>

				<div class="description">
					{{ $channel['contentDescription'] }}
				</div>

	          <div class="row analytics">
	          <div class="col-md-3"><img class="icon preview-icon1" src="../assets/img/view.png"><span class="listit">{{ $channel['totalNoOfViews'] }}</span></div>
	          <div class="col-md-3"><img class="icon preview-icon2" src="../assets/img/like.png"><span class="listit">{{ $channel['totalNoOfLikes'] }}</span></div>
	          <!-- <div class="col-md-3"><img class="icon preview-icon3" src="../assets/img/dislike.png"><span class="listit"></span></div> -->
	          <div class="col-md-3"><img class="icon preview-icon4" src="../assets/img/comment.png"><span class="listit">{{ $channel['totalNoOfComments'] }}</span></div>
	          </div>
	        </div>
	        <hr>
	        <div class="modal-footer">
	        <ul id="ulid{{$i}}">
	        	
	        </ul>
	        
	        @if(auth ()->user ()->hasRole('pj'))
	        <div class="buttons">
	        	@if($channel['isPublished'] == 0)
	        	<button onclick="moveContent('{{ $channel['contentId'] }}')" id="publish_btn" type="button" class="btn btn-primary savebtn">Publish content</button>
	        	@endif
                <button type="button" data-dismiss="modal" class="btn btn-default cancelbtn">Close</button>
	        </div>
	        @endif        

	        </div>
	      </div>
	      
	    </div>
	  </div>
						@endforeach
						@else
							<h4>Contents not uploaded yet!</h4>
						@endif
					</div>

				</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
</section>

	  
</div>

<script>
function mediacontrol(modalid) {
    $('#'+modalid).attr("src", $('#'+modalid).attr("src"));
}

function moveContent(content_id){

	$.ajax({
        url: '{{ url("publishContent") }}'+'/'+content_id,
        type: 'post',
        cache:false,
        contentType: false,
        processData: false,
        success: function(response)
        {
            if(response == 1){
            	$(".msg").attr('class','msg alert alert-success');
                $(".msg p").html('Content published successfully');
                $("#publish_btn").hide();
            }else{
            	$(".msg").attr('class','msg alert alert-dander');
                $(".msg p").html('Could not able to Publish content');
            }
            $(".msg").show();
        }
    });
}
function getComments(content_id, ulId){
	$(".msg").hide();
	$.ajax({
        url: '{{url("channel/comments")}}'+'/'+content_id,
        type: 'get',
        success: function(response)
        {
        	console.log(response);
        	if (response.status == 1) {
        		var data = response.data.item;

        		$("#"+ulId).html('');
        		var list = '';

        		if(data.length <1){
        			$("#"+ulId).html("<li>No comments yet</li>");
        		}

        		$.each(data, function(i, order){
        			console.log(data[i].commentDesc );
        			console.log(data[i].modifiedDate );

        			list += '<li><div class="col-md-1"><img class="cmt-icon" src="../assets/img/default.png"></div><div class="col-md-11">';
	           		list +=	'<p>'+data[i].commentDesc+'</p>';
	           		list +=	'<p class="cmt-date">'+data[i].modifiedDate+'</p></div></li>';
	           		
	           		
        		});  
        		$("#"+ulId).append(list);
	        	
        	}else{
        		$("#"+ulId).html("<li>No comments yet</li>");
        	}
        	// $("#"+ulId).show();        	
        }
    });
}
</script>
@stop