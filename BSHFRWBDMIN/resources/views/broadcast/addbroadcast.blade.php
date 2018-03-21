@extends('layouts.default') 

@section('title')
	AR-Triggers
@stop

@section('content')

		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>Add Broadcast</h1>
				<ol class="breadcrumb">
					<li><a href="{{ URL::route('get:users','asc') }}"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Broadcast</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-info">
					<div class="box-header with-border">
						<div class="col-md-12">
							<h3 class="box-title">Broadcast Info</h3>
						</div>					
					</div>
					<div class="box-body">
						<div class="col-md-12">
							<div class="tab-pane active" id="tab_1">
								<!-- form start -->
								 @include('includes.messages')
								{!! Form::open(['route' => ['post:add-broadcast',isset($data)?$data->id:0], 'files' => true, 'class' => 'col-md-12 box-body broadcast','id'=>'broadcast']) !!}
									<div class="col-md-12">	
										
										<div class="form-group">
										    <div class="col-md-2">
										        <label for="title">Title<em style="color:red">*</em></label>
										    </div>
										    <div class="col-md-6">
										        {!! Form::text('title',Input::old('title',isset($data)?$data->title:''),['class' => 'form-control text_box required','placeholder'=>'Title','id'=>'title']) !!}
										    </div>
										</div>
										<div class="form-group">
											<div class="col-md-2">
												<label for="message">Message</label>
											</div>
											<div class="col-md-6">
											        {!! Form::text('message',Input::old('message',isset($data)?$data->message:''),['class' => 'form-control text_box required','placeholder'=>'Message','id'=>'message']) !!}
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-2">
												<label for="image">File</label>
											</div>
											<div class="col-md-6 image-upload">
												{!! Form::file('image', ['id' => 'image', 'class' => '']) !!}
													<label class="file-upload">
										      			<span class="fa fa-picture-o icon-image"></span>
										      			<div class="filename">
										      				<span>no file chosen</span>
										      			</div>
										      			<button>Browse</button>									      			
										      		</label>
											</div>
											<div>
												<img alt="{{ $data['title'] }}" src="@if(isset($data['media_url'])&&($data['media_url']!=''))
    						{{ $image=$data['media_url']}}
    						@else
                            {{$image=URL::asset('assets/img/default_large.png') }}
                            @endif" style="width: 100px; height: 100px;border-radius:50px;">
											</div>
										</div>
										<div  class="form-group">
										    <div class="col-md-2">
										        <label for="is_active">Status</label>
										    </div>
										    <div class="col-md-8">
												<?php
										   		 if((isset($data) && $data->is_active) || !isset($data)){
										                $active = 1;
										                $inactive = 0;
													}
										            else
										               { $active = 0 ;
										                $inactive = 1 ;
										            }
										            ?>
										        <div class="rdio rdio-primary col-md-2">
										            {!! Form::radio('is_active',1,$active, ['id' => 'active', 'class' => 'hidden'])  !!}
										            <label for="active">Active</label>
										        </div>
										        <div class="rdio rdio-primary col-md-2">
										            {!! Form::radio('is_active',0,$inactive, ['id' => 'inactive', 'class' => 'hidden']) !!}
										            <label for="inactive">Inactive</label>
										        </div>
										        
										    </div>
										</div>																							
										<div class="col-md-2">&nbsp;</div>
										<div class="col-md-6">
											<?php if(!isset($data)) { ?>
											<button type="submit" class="btn btn-primary bg-red btn-flat mar-right">Save</button>
											<a href="{{ URL::route('get:broadcast')}}" class="btn btn-default btn-flat">Cancel</a>
											 <!-- {!! Form::button('Add users',['id'=>'js-open-modal','class'=>'js-open-modal','onClick' => 'getListUsers("'.$url.'")','data-modal-id'=>"popup",'data-target'=>'#userlist_Modal','data-toggle'=>'modal'])!!} --> 											
											 {!! Form::button('Add users',['id'=>'js-open-modal','class'=>'js-open-modal add-user-btn','onClick' => 'getListUsers("'.$url.'")'])!!}
											<!-- {!! Form::button('Add users',['id'=>'js-open-modal','class'=>'js-open-modal','data-toggle'=>'modal','data-target'=>'#userlist_Modal'])!!} -->
											<?php } ?>
										</div>
									</div>
									<input type="hidden" name="selected_list_users" id="selected_list_users" value=""/>
									<input type="hidden" name="selected_list_group" id="selected_list_group" value=""/>
									
								{!!Form::close()!!}
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->
					</div>
					
					<div class="col-md-4"><h4 class="box-title">Broadcast Members</h4></div>
					<div>
					
					<table id="selected_list" class="table text-center">
						
						<tbody>
					        @if (count($contact))
					        
					        @foreach($contact as $user)
					        <tr>
					        <td>{{ isset($user['name'])?$user['name']:'---' }}</td>
					        <td><img alt="{{ $user['name'] }}" src="@if(isset($user['image'])&&($user['image']!=''))
    						{{ $image=$user['image']}}
    						@else
                            {{$image=URL::asset('assets/img/default_large.png') }}
                            @endif" style="width: 100px; height: 100px;border-radius:50px;"></td>
					        <td>{{ isset($user['mobile_number'])?$user['mobile_number']:'---' }}</td>
					        <td><a onclick="removeSelectedUser{{ isset($user['username'])?$user['username']:'---' }}" class="btn btn-box-tool fa fa-trash text-yellow" data-toggle="modal" title="Delete" ></a></td>
	    						    	    							
	    					<tr>		
	    					@endforeach
	    					
	    				    @else
	    				        <tr><td colspan="10">No Records Found.</td></tr>
	    				    @endif
						</tbody>
						
					</table>
					</div>
					
					<div>
					
					<table id="selected_group">
						
						
					</table>
					</div>
					
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</section>
			<!-- /.content -->
			<!-- /.content -->
		</div>
         
   <div class="modal fade" id="userlist_Modal" role="dialog">
   
     <div class="modal-content">
      <button type="button" class="close close-btn" onclick="doRefresh();" data-dismiss="modal">&times;</button>
      <div class="modal-header">
      
      <div class="modal-body">
        <div class="tabbable"> <!-- Only required for left/right tabs -->
        <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">Users</a></li>
        <li><a href="#tab2" data-toggle="tab" id="group_list">Groups</a></li>
        </ul>
        <div class="tab-content">
        <div class="tab-pane active" id="tab1">
       
       
        
        <div class="user-tab">
        <table id="mobile_numbers">
        <thead>  
	        <tr>
	        	<th> <input type="text" id="name_filter" onkeyup="getNameFilter()" placeholder="Search for names.."></th>
	        	<th><input type="text" id="Phone_filter" onkeyup="getPhoneFilter()" placeholder="Search for phone no"></th>
	     	</tr>
        </thead>
        </table>
        </div>
        </div>
        <div class="tab-pane" id="tab2">
        	<div class="group-tab">        	
	        	<table id="groups">
	        		<thead>
	        			<tr>
	        				<th><input type="text" id="group_filter" onkeyup="getGroupFilter()" placeholder="Search for groups.."></th>
	        			</tr>
	        		</thead>
	        	</table>
        	</div>
        </div>
        </div>
        </div>
     </div>
      
       
        
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" onclick="doRefresh('<?php echo $url;?>')">close</button>
      </div>
    </div> 
    
   </div>
         
         
 		<script>
         $(document).ready(function(){
        	 $('#date_time').datetimepicker();
        	 if ($("#now_active").is(":checked")) {
        		 $('#date_time').hide();
        		 
             }else{
                 //alert("hai");
            	 $('#date_time').show(); 
             }
        	 $('input[type=radio][name=is_later]').change(function() {
        	        if(this.value==1){
        	        	$('#date_time').show(); 
        	        }else{
        	        	$('#date_time').hide(); 
        	        }
        	            
        	  });
        	 //$('#photo_space').show(); 
         });

         
         </script>
@stop
