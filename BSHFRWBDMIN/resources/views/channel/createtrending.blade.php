@extends('layouts.default')
@section('title')
Channels
@stop
@section('content')
<script>
   $(document).ready(function(){
   	var trendchannelid = 0;	
   	var trendchannelcount = 0;
    $("#cloneaddtrendingchannels").click(function(){
      if( trendchannelcount < 8 )
        $("#clone").clone().prop({ id: "newId"+ trendchannelid++, name: "newName"}).appendTo('#cloned_one');
        trendchannelcount++;
    });
});
</script>

<div class="content-wrapper" style="min-height: 678px;">
<div class=" ">
	<section class="content-header">
		<h1>Add Trending Channel</h1>
		<ol class="breadcrumb">
			<li><a href="http://bushfirewebadmin.app/staff"><i class="fa fa-dashboard"></i>
					Home</a></li>
			<li class="active"><a href="http://bushfirewebadmin.app/trending">Trending Channels</a></li>
			<li class="active">Add Trending Channels</li>
		</ol>
	</section>
  <div class=" addingtrendingchannels col-md-12" id="cloned_one" >
  <div class="row col-md-12" id="clone">
  <div class="col-md-6 multitrendingtchannelselection">
  	<select class="postionofchannel col-md-2" id="selectionarrangementvalue">
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
	</select>
	<select class="channelname col-md-10">
			<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
	</select>
  </div>
  </div>
  </div>
  <div class="btn-aligncenter trendingchannelbuttongroup">
  	<button class="btn btn-sm btn-info" id="cloneaddtrendingchannels"><i class="fa fa-plus"></i> Add Trending Change</button>
  	<button class="btn btn-sm btn-info">Submit</button>
  </div>
	
	</div>
	
</div>

@stop
