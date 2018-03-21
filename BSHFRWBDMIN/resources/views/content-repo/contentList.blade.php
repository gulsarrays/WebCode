@extends('layouts.default') @section('title') Content | PJ @stop @section('content')

<div id="addaccount" class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="box-header with-border"> 
        @include('includes.messages')
    </div>

            
    <!-- @include('includes.search',['resetUrl' => '/content-repo','fromUrl'=>'/content-repo']) -->
  
   
    <section id="fullreports" class="content-header">
        <ul class="nav nav-pills" id="reportstabs">
            <li class="active"><a data-toggle="pill" href="#allcontentList" onclick="updateSearchTextBoxName('allcontentList');">All Content</a></li>
            <li><a data-toggle="pill" href="#viewpjList" onclick="updateSearchTextBoxName('viewpjList');">PJ List</a></li>
        </ul>
    </section>

    <section class="content  tab-content">
        <div id="allcontentList" class="tab-pane fade in active">
            <div class="box box-info">
                <div class="box-header with-border"> 
                </div>
                <div class="box-body">
                    <table id="listAllcontent" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="width30 text-center">No</th>
                                <th class="width300">Title</th>
                                <th class="width50">Type of Content</th>
                                <th class="width100">Stringer Name</th>
                                <th class="width50">Status</th>
                                <th class="width100">PJ'S Name</th>
                            </tr>
                        </thead>
                        <tbody id='allcontentListTable'>
                            
                            <?php $s=1; ?>
                            @foreach($pjstringerContents as $content)  
                                <?php
                                    $published_stats_arr = array('1',1,true,'true','Published','published');

                                    if(in_array($content['status'],$published_stats_arr, true)) {
                                        $published_status_str = "Published";
                                    }else {
                                        $published_status_str = "Not published";
                                        $published_status_str = "Unpublished";
                                    }


                                    $stringerName_arr = array("0",0,false,'false','null','Null', NULL);
                                    if(in_array($content['stringerName'],$stringerName_arr, true)) {
                                        $stringerName = '-';
                                    } else {
                                        $stringerName = $content['stringerName'];
                                    }

                                    $pjName_arr = array('0',0,false,'false','null','Null', NULL);
                                    if(in_array($content['pjName'],$pjName_arr, true)) {
                                        $pjName = '-';
                                    } else {
                                        $pjName = $content['pjName'];
                                    }
                                ?>
                                <tr>
                                    <td class="width30 text-center">{{ $s++ }}</td>
                                    <td class="width300">
                                        <a data-toggle="modal" data-target="#showContentmodal"
                                            onclick="getContent('{{ $content['contentId'] }}');"> 
                                            {{ $content['contentTitle'] }}
                                        </a>
                                    </td>
                                    <td class="width50">{{ $content['contentType'] }}</td>
                                    <td class="width100">{{ $stringerName }}</td>
                                    <td class="green width50"><?php echo $published_status_str;?></td>
                                    <td class="width100">{{ $pjName }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
                <!-- /.box-body -->
            </div>
        </div>

        <div id="viewpjList" class="tab-pane fade">
            <div class="box box-info">
                <div class="box-header with-border">
                    <div class="" role="alert" id="msg" style="display:none">
                        <p></p>
                    </div>
                    <h3><a class="btn btn-success" href="{{ url('pj/create') }}"> Create PJ</a></h3>
                </div>
                <div class="box-body">
                @if(count($pjLists) > 0)
                    <table id="listPj" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="width30 text-center">No</th>
                                <th class="width300">Name</th>
                                <th class="width300">Email ID</th>
                                <th class="width300">Phone Number</th>
                                <th class="text-center width50">Status</th>
                                <th class="text-center width200">Action</th>
                            </tr>
                        </thead>
                        <tbody id="viewpjListTable">                             
                            <?php $i=1; ?>
                            @foreach($pjLists as $pj)
                                <tr>
                                    <td class="width30 text-center">{{ $i++ }}</td>
                                    <td class="width300">{{ $pj->username }}</td>
                                    <td class="width300">{{ $pj->email }}</td>
                                    <td class="width300">{{ $pj->mobile_number }}</td>
                                    <td class="red width50 text-center">
                                        @if($pj->is_active == 1)
                                            <span class="label label-success">Active</span>
                                        @else
                                            <span class="label label-error">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="width200 text-center">
                                        <a class="btn btn-primary" href="{{ url('pj/'.$pj->id.'/edit') }}">Edit</a>
                                        <a class="btn btn-danger" data-href="{{url('pj/delete/'.$pj->id)}}" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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
        <!-- /.box -->
    </section>
    <!-- /.content -->
    <!-- /.content -->
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

<script type="text/javascript">



function getContent(contentId)
        {
            $.ajax({ 
                url: '{{url("/getContent")}}'+'/'+contentId,
                type: 'get',
                success: function(response)
                {
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

    
    $(document).ready(function() {
        $('#listAllcontent').DataTable( {
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
                {"extend": 'csv', "exportOptions": {"columns": [ 0, 1, 2, 3, 4, 5]} },
                {"extend": 'excel', "exportOptions": {"columns": [  0, 1, 2, 3, 4, 5]} },
            ],
            "iDisplayLength": DefaultDisplayLength,
        } );
        $('#listPj').DataTable( {
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
                {"extend": 'excel', "exportOptions": {"columns": [  0, 1, 2, 3, 4]} },
            ],
            "iDisplayLength": DefaultDisplayLength,
        } );
    } );
</script>
@stop