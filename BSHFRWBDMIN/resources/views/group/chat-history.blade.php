@extends('layouts.default') 
@section('title')
	Users
@stop
@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>Chat History</h1>
		<ol class="breadcrumb">
			<li><a href="{{ URL::route('get:users','asc') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Chat History</li>
		</ol>
	</section>
	<section class="content">
		<div class="box box-info">
			@include('includes.messages')
			<div class="box-header with-border">
			<div class="col-md-3">
				<div class="col-md-6"><label class="label-name">Sort By Chat Type</label></div>
				<div class="col-md-6">
                    <div class="has-feedback">
                        <select name="sort" class="form-control text_box" id="sort-chat">
                            <option @if($sort == 'chat') selected @endif value="chat">Chat</option>
                            <option @if($sort == 'groupchat') selected @endif value="groupchat">Group Chat</option>
                        </select>
                         <span class="fa fa-angle-down form-control-feedback"></span>
                    </div>
				</div>
			</div>
			<a class="fa fa-refresh text-green pull-right" data-toggle="tooltip" title="Reset" href="{{ URL::route('get:chat-history') }}"></a>
              <div class="col-md-4 pull-right">
                <div class="has-feedback">
                  {!! Form::open(['id' => 'search-chat','method'=>'get']) !!}
                  @if($search=='null')
                  {{--*/ $search = '' /*--}}
                  @endif
                  <input type="text" name="search" class="form-control input-sm text_box" placeholder="Search by From" id="search-from" value="{{ $search }}">
                  <button type="submit" class="glyphicon glyphicon-search form-control-feedback"></button>
                  {!!Form::close()!!}
                  
                </div>
              </div>
              <div class="clearfix"></div>
              <!-- /.box-tools -->
              <div class="col-md-5 pull-right date-picker">
              {!! Form::open(['id' => 'search-chat-date','method'=>'get']) !!}
				<div class="col-md-6 nopadding">
      				<div class="col-md-2 text-right nopadding"><label class="label-name">From</label></div>
      				<div class="col-md-10">
                    <input type="text" class="form-control text_box" data-date-format="yyyy-mm-dd" id="from-date" readonly>
                   </div>
				</div>
				<div class="col-md-6 nopadding">
                    <div class="col-md-2 text-right nopadding"><label class="label-name">To</label></div>
      				<div class="col-md-10">
                          <input type="text" class="form-control text_box" data-date-format="yyyy-mm-dd" id="to-date" value="{{ date('Y-m-d') }}" readonly>
      				</div>
				</div>
				<button type="submit" class="glyphicon glyphicon-search form-control-feedback"></button>
			</div>
			{!!Form::close()!!}
            </div>
            {!! Form::open(['route' => 'post:login', 'id' => 'manage-datas']) !!}
			<div class="box-body">
				<table id="example1" class="table table-hover table-bordered">
					<thead>
						<tr>
							
							<th>From</th>
							<th>To</th>
							<th>Chat Type</th>
							<th>Message Type</th>	
							<th>Date</th>									
						</tr>
					</thead>
					<tbody>
				        @if (count($chat_history))
    						@foreach ($chat_history as $chat)
    						    <tr>
    								<td>{{ $chat['from'] }}</td>
    								<td>{{ $chat['to'] }}</td>
    								<td>{{ $chat['chat_type'] }}</td>
    								<td>{{ $chat['message_type'] }}</td>
    								<td>{{ $chat['datetime'] }}</td>
    							</tr>
    						@endforeach
    				    @else
    				        <tr><td colspan="10">No Records Found.</td></tr>
    				    @endif
					</tbody>
				</table>
			</div>
			{!!Form::close()!!}
			@include('includes.pagination', ['data' => $data])
		</div>
	</section>
</div>
<script type="text/javascript">
	     $(document).ready(function(){
	         $('#from-date').datepicker({ dateFormat: 'yy-mm-dd h:i:s' });
	         $('#to-date').datepicker({ dateFormat: 'yy-mm-dd h:i:s' });
         });
		  
		</script>
@stop