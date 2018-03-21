@extends('layouts.default') 
@section('title')
	Chat
@stop
@section('content')

<link href="{{ URL::asset('assets/css/chat.css') }}" rel="stylesheet" type="text/css" />
<style>
	.box-cont{
		background-color: #eee;
	    min-height: 250px;
	    padding: 15px 0 15px 0;
	}
	.box-cont p{
		padding: 8px;
		cursor: pointer;
	}
	.box-cont p.sel{
		background-color: #dad4d4;		
	}
</style>

<div class="content-wrapper">
	<section class="content-header">
		<h1>View chats</h1>
		<ol class="breadcrumb">
			<li><a href="{{ URL::route('get:channels') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">View chats</li>
		</ol>
	</section>

	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
			 @include('includes.messages')
			 <div class="clearfix"></div>
              <!-- /.box-tools -->
            </div>        

	        <div class="box-body">
	        	<div id="channels" class="col-md-3">
	        		<h3>Channels</h3>
	        		<div class="box-cont">
	        		<?php
	        			if(is_array($allchannels)){
							foreach ($allchannels as $channel) {
								echo '<p id="'.$channel['channelId'].'">'.$channel['channelTitle'].'</p>';										
							}
						}
	        		?>
	        		</div>
	        	</div>
	        	<div id="channel-users" class="col-md-3">
	        		<h3>Available users</h3>
	        		<div class="box-cont">

	        		</div>
	        	</div>

	        	<div id="chatwindow" class="col-md-4" style="display:none;">
	        		<div class="col-sm-12 col-sm-offset-1 frame">
				            <ul id="chatul"></ul>
				            <div>
				                <div class="msj-rta macro" style="margin:auto">                        
				                    <div class="text text-r" style="background:whitesmoke !important">
				                        <input class="mytext" placeholder="Type a message"/>
				                    	<input type="hidden" name="" id="curentuser" value="">
				                    	<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
				                    </div> 
				                </div>
				            </div>
				        </div>   
	        	</div>
	        </div>

        </div>
        
    </section>

</div>

   
<script src="{{ URL::asset('assets/js/chat.js') }}"></script>
<script>
$("#channels p").click(function(ele){
	var channelid = this.id;
	$("#channels p").removeClass('sel');
	$(this).addClass("sel");

	 $.get("getchannelusers/" + channelid, function (data) {
	 	
	 	if(data === 0){
	 		$("#channel-users .box-cont").html('<p>No Users yet!</p>');
	 	}else{
	 		$("#channel-users .box-cont").html(data);
	 	}

    }).fail(function (data) {
    	if(data === 0){
        	$("#channel-users .box-cont").html('<p>No Users yet!</p>');
        }        
    });

});

function openpopup(ele)
{	resetChat();
	insertChat("you", "Hi! Any channel update?", 1500);
	$("#channel-users p").removeClass('sel');
	$(ele).addClass("sel");
	var userid = ele.id;
	$("#curentuser").val(userid);
	$("#chatwindow").show();
}

</script>

@stop