@extends('layouts.default') @section('title') Settings @stop @section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Settings</h1>
    </section>

    <section class="content" id="fullreports">
        <section class="content-header hashboxheader">
            <ul class="nav nav-pills" id="reportstabs">
                <li class="active"><a data-toggle="pill" href="#addmodule">Ad Module</a></li>
                <li><a data-toggle="pill" href="#hashtag">Hash tag</a></li>
            </ul>
        </section>
        <div class="box-header with-border">
           @include('includes.messages')
        </div>

        <div class="tab-content">
            <div id="addmodule" class="tab-pane fade in active">
                <div class="box box-info">
                    <section class="content-header">
                        <ul class="nav nav-pills" id="reportstabs">
                            <li class="active"><a data-toggle="pill" href="#waittime">General Ad</a></li>
                            <li><a data-toggle="pill" href="#ratecard">Rate Card</a></li>
                        </ul>
                    </section>
                    
                    <div class="tab-content">
                        <div id="waittime" class="tab-pane fade in active">
                            <div class="box-body">
                                <table id="example1" class="table table-hover table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name </th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $j = 0;?>
                                        @if(count($settings))
                                            @foreach ($settings as $setting)
                                                <tr>
                                                    <td>{{ ++$j}}</td>
                                                    <td>{{ $setting['name'].' : '.$setting['value']}}</td>
                                                    <td class="text-center"> 
                                                        <a class="btn btn-box-tool fa fa-pencil text-aqua"
                                                            data-toggle="tooltip" title="Edit"
                                                            href="{{url('settings'.'/'.$setting['name'].'/edit')}}"></a>
                                                    </td>
                                                    <!-- settingId -->
                                                </tr>
                                            @endforeach
                                            
                                        @else
                                            <tr><td colspan="10">No Records Found.</td></tr>
                                        @endif
                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <div id="ratecard" class="tab-pane fade">
                            <div class="box-body">
                                <table id="example2" class="table table-hover table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th class="text-center">Currency</th>
                                            <th class="text-center">No.of view</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $k=0; ?>
                                        @if($rateCardSettings)
                                        @foreach($rateCardSettings as $rateCard)
                                            <tr>
                                                <td>{{ ++$k }}</td>
                                                <td>{{ $rateCard['contentType'] }}</td>
                                                <td class="text-center">{{ $rateCard['amtPerNoOfView'] }}</td>
                                                <td class="text-center">{{ $rateCard['noOfViews'] }}</td>
                                                <td class="text-center">Active</td>
                                                <td class="text-center">
                                                    <a class="btn btn-box-tool fa fa-pencil text-aqua"
                                                        data-toggle="tooltip" title="Edit"
                                                        href="{{ url('settings/ratecard/'.$rateCard['rateCardId'].'/edit') }}"></a>
                                                </td>
                                            </tr>   
                                        @endforeach
                                        @else
                                            <tr><td colspan="10">No Records Found.</td></tr>
                                        @endif                      

                                        
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        

            <div id="hashtag" class="tab-pane fade">
                <div class="box box-info">
                    <section class="content-header hashtaghead">
                        <div class="col-md-6">
                            <h4>Total count of Hashtag: {{ $trendings['totalRecords'] }} </h4>
                        </div>
                        <div class="col-md-6 pull-right hashtagclass">
                            <h4>Trending #Hashtags</h4>
                            <div class="tagtrend">
                            	@if(isset($trendings['data']['item']))
                                	@foreach($trendings['data']['item'] as $tag)
                                    <div class="hashcount">
                                        <p><span class="tagname">{{ $tag['hashtag'] }}</span><span class="tagcount">{{ $tag['count'] }}</span></p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{$tag['count']}}%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                	<div>No Trending listed!</div>
                                @endif
                            </div>
                        </div>                      
                    </section>
                    <div class="tab-content">
                            <div class="box-body">
                                <!--@include('includes.search',['resetUrl' => '/settings#hashtag'])-->
                
                                <table id="example3" class="table table-hover table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="text-center">Hashtag</th>
                                            <th class="text-center">Created by</th>
                                            <th class="text-center">Date of Creation</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	@if($hashtags)
                                        <?php $i=1;?>
                                    	@foreach($hashtags as $tag)                                    	
	                                        <tr>
	                                            <td>{{$i}}</td>
	                                            <td class="text-center">
	                                            	<a class="showtag" onclick="openHashtagModal('<?php echo $tag["hashtag"]; ?>')" >#{{$tag['hashtag']}} ({{$tag['occuranceCount']}})</a></td>
	                                            <td class="text-center">{{$tag['userName']}}</td>
	                                            <td class="text-center">{{ Carbon\Carbon::parse($tag['createdDate'])->format('d-m-Y') }}
	                                            </td>
	                                            <td class="text-center"><a class="btn btn-danger" data-toggle="tooltip" title="Delete" href="{{ url('hashtag'.'/delete/'.$tag['hashtag']) }}">Delete</a></td>
	                                        </tr>
                                            <?php $i++; ?>
                                        @endforeach
  										@else
                                        <tr><td colspan="10">No Records Found.</td></tr>
                                        @endif
                                    </tbody>
                                </table>

                            </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
    <!-- /.content -->
</div>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modalhash">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <ul id="hashResults">

          <li>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's</p>
            <p class="tagonhash">Hand Crafted Channel</p>
          </li>
 
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>



<script>
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

    function openHashtagModal(name)
    {
    	// $("#myModal").modal('show');

    	$.ajax({
	        url: '{{url("/hashtag")}}'+'/'+name,
	        type: 'get',
	        success: function(response)
	        {
	        	console.log(response);
	        	if (response != 0) {
		        	$("#hashResults").html(response);
		        	
	        	}else{
		        	$("#hashResults").html("<li>No results found!</li>");
	        	}
                $(".modal-title").html("#"+name);
	        	$("#myModal").modal('show');
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
                {'bSortable': false, 'aTargets': [2]},
                {"bSearchable": false, "aTargets": [2]}
            ],
            "dom": 'lfrtipB',
            "oLanguage": {
                "sSearch": "Filter"
             },
            "buttons": [
                {"extend": 'csv', "exportOptions": {"columns": [ 0,1]} },
                {"extend": 'excel', "exportOptions": {"columns": [ 0,1]} },
            ],
            "iDisplayLength": DefaultDisplayLength,        
        } );
        $('#example2').DataTable( {
            "bFilter": true,
            "lengthMenu": lengthMenu,
            "responsive": true,
            "order": [[0, 'asc']],
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [5]},
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
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [4]},
                {"bSearchable": false, "aTargets": [4]}
            ],
            "dom": 'lfrtipB',
            "oLanguage": {
                "sSearch": "Filter"
             },
            "buttons": [
                {"extend": 'csv', "exportOptions": {"columns": [ 0, 1, 2, 3]} },
                {"extend": 'excel', "exportOptions": {"columns": [ 0, 1, 2, 3]} },
            ],
            "iDisplayLength": DefaultDisplayLength,        
        } );
    } );
</script>
@stop