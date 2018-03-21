@extends('layouts.default') 
<style>
<!--
.chat_list{
	border: 1px solid;
	width: 30%;
	border-radius: 10px;
	padding-left: 10px;
	list-style: none;
	margin:10px;
}
.receiver{
    margin-left:150px;
}
.chat_image{
    width: 300px;
    height: 300px;
}
-->
</style>
@section('title')
	Users
@stop

@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>Conversation</h1>
		<ol class="breadcrumb">
			<li><a href="{{ URL::route('get:users','asc') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Conversation</li>
		</ol>
	</section>
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<div class="col-md-12">
					<h2 class="conversation">Conversations</h2>
				</div>
				<div class="message_part col-md-10 col-md-offset-1">
					<div class="message_slim" id="message_slim">
						@if (count($conversations))
						<?php $i = 0; ?>
			    		@foreach ($conversations as $conversation)
			    		
			    		 <?php 
			    		 
			    		 $messageContent = $conversation->payload;
			    		 
			    		 
			    	     $xmlparser = xml_parser_create();

                         xml_parse_into_struct($xmlparser,$messageContent,$values);

                         xml_parser_free($xmlparser);
                         $array = array();
                         
                         $key256 = $values[0]['attributes']['MESSAGE_ID'];
                         
                         $message_from = explode("@",$values[0]['attributes']['SENT_FROM']);
                         $username = $message_from[0];
                         $hash = hash('sha256', $key256); 
                         $key = mb_substr($hash, 0, 32);
			    		 $iv        = "ddc0f15cc2c90fca";			    		 
			    		 $deciphertext = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($values[0]['value']), MCRYPT_MODE_CBC, $iv);			    		 
			    		 $message = trim(urldecode(utf8_decode($deciphertext)));
			    		 $messages = explode('"}',$message);
			    		 
			    		 $json = '';
			    		 for($j = 0 ; $j < count($messages)-1; $j++)  
			    		 {
							 $json .= $messages[$j].'"}';
						 }    
						 
			    		  $array = array();
			    		 $jsonData = CustomHelper::convertJson($json);
			    		 
                          $time = $conversation->creation;
                          if($jsonData != null)
                         $array = get_object_vars($jsonData);
                        
                       if(!empty($array)){
						  
			    		 ?>
			    		 
				    		    @if($array['message_type']=='text')
				    		    <div class="single_message">
									<div class="user_details"><span>
									@if(isset($srcuser[$username]))
									{{$srcuser[$username]}}	
									@else
									{{$username}}
									@endif
									</span></div>
									<div class="message_box">
										<div>{{ $array['message']}}</div>
										<div class="timestamp"><i class="fa fa-clock-o"></i> {{date($time)}}</div>
									</div>				
								</div>
								
				    		    @elseif($array['message_type']=='image')
				    		    <div class="single_message">
									
										<div class="user_details">
	    								@if(isset($srcuser[$username]))
									{{$srcuser[$username]}}	
									@else
									{{$username}}
									@endif
									    </div>
										<div class="message_box">
											<div><img class="chat_image" src="{{ $array['media']->file_url }}"/></div>
											<div class="timestamp"><i class="fa fa-clock-o"></i> {{date($time)}}</div>			
										</div>
									</div>
				    		    @elseif($array['message_type']=='video')
				    		    	<div class="single_message">
										
											<div class="user_details"> 
	    									@if(isset($srcuser[$username]))
									{{$srcuser[$username]}}	
									@else
									{{$username}}
									@endif	
											</div>
											<div class="message_box">
												<div>
													<video src="{{ $array['media']->file_url}}" controls></video>
												</div>
												<div class="timestamp"><i class="fa fa-clock-o"></i>{{date($time)}}</div>
											</div>				
										</div>
				    		        			    		   
				    		    @elseif($array['message_type']=='audio')
								<div class="single_message">
									
									<div class="user_details">
									@if(isset($srcuser[$username]))
									{{$srcuser[$username]}}	
									@else
									{{$username}}
									@endif    
									</div>
										<div class="message_box">
											<div>
												<audio src="{{ $array['media']->file_url }}" controls>
													Your browser does not support the audio element.
												</audio>
											</div>
											<div class="timestamp"><i class="fa fa-clock-o"></i>{{date($time)}}</div>
										</div>				
									</div>
				    		    
				    		    @elseif($array['message_type']=='location')
				    		    <div class="single_message">
									
										<div class="user_details">
										@if(isset($srcuser[$username]))
									{{$srcuser[$username]}}	
									@else
									{{$username}}
									@endif
										</div>
										<div class="message_box">
											<div><h2>Location</h2>
												<p><!-- {{ object_get($jsonData, 'location' ) }} -->
													<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3887.3149263568775!2d80.1981563143541!3d13.015606217433884!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5260d084dc54cd%3A0xb3e84ab20dc3785e!2scompassites!5e0!3m2!1sen!2sin!4v1464251284416" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
												</p>
											</div>
											<div class="timestamp"><i class="fa fa-clock-o"></i>{{date($time)}}</div>
										</div>				
									</div>
				    		   
				    		    @elseif($array['message_type']=='contact')
				    		    <div class="single_message">
										<div class="user_details">
										@if(isset($srcuser[$username]))
									{{$srcuser[$username]}}	
									@else
									{{$username}}
									@endif
										
										</div>
										<div class="message_box">
											<div><h2>Contact Details</h2>
												<p><i class="fa fa-user"></i><?php echo $array['contact']->phone_number[0];?></p>
											</div>
											<div class="timestamp"><i class="fa fa-clock-o"></i>{{date($time)}}</div>
										</div>				
									</div>
									
				    		    @endif
				    		    
				    		   <?php  $i++; } ?>
				    		@endforeach
				        @else
				            <div>No Conversation available.</div>
				    	@endif
			    	</div>
   				</div>
   			</div>
   	 	</div>
		
	</section>
</div>
@stop
