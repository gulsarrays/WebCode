@extends('layouts.default') 
@section('title')
	Channels
@stop
@section('content')

<div class="content-wrapper">
	<section class="content-header">
		<h1>View channels</h1>
		<ol class="breadcrumb">
			<li><a href="{{ URL::route('get:channels') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">View channels</li>
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
        	<div id="channels" class="col-md-12">
        		<div class="text-center">
	        		<h4>Welcome!</h4>
	        		<a href="{{ url('channel/create') }}"><button type="button" class="btn btn-info">Create Channel</button></a>
        		</div>

        		<div id="listchannels">
        			<h3>CHANNEL LIST</h3>
        			<table class="table">
					  <thead class="thead-default">
					    <tr>
					      <th>Channel Title</th>
					      <th>Category</th>
					      <th>Age Group</th>
					      <th>Total Subscriber Count</th>
					    </tr>
					  </thead>
					  <tbody>
				      <?php
		        			if(is_array($allchannels)){
								foreach ($allchannels as $channel) { ?>
									<tr>
									<td>{{ $channel['channelTitle'] }}</td>
									<td>{{ $channel['category']['categoryName'] }}</td>
									<td>{{ $channel['ageGroup']['ageGroupMin'].'-'.$channel['ageGroup']['ageGroupMax'] }} Yrs</td>
									<td>{{ $channel['noOfUsersSubscribed'] }}</td>	
							    	</tr>		
								<?php }
							}
		        		?>
					  </tbody>
					</table>
        		</div>
        	</div>
        </div>

        </div>
        
    </section>

</div>
@stop