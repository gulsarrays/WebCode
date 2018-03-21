@extends('layouts.default') @section('title') Home | PJ @stop @section('content')
<style>
.img-responsive{
    margin: 0 auto;
}
</style>
<div id="addaccount" class="" style="min-height:678px">
    <!-- Content Header (Page header) -->
    <div class="box-header with-border"> 
        @include('includes.messages')
    </div>
 
    <!--@include('includes.search',['resetUrl' => '/pj','fromUrl'=>'/pj'])--> 
                
    <section id="fullreports" class="content-header">
        <ul class="nav nav-pills" id="reportstabs">
            <li class="active"><a data-toggle="pill" href="#allcontent" onclick="updateSearchTextBoxName('allcontent');">All Content</a></li>
            <li><a data-toggle="pill" href="#liststringer" onclick="updateSearchTextBoxName('liststringer');">List Stringer</a></li>
            <li><a data-toggle="pill" href="#myupload" onclick="updateSearchTextBoxName('myupload');">My uploads</a></li> 
            <!-- Stringer Content Upload by Me -->
            <li><a data-toggle="pill" href="#usermy" onclick="updateSearchTextBoxName('usermy');">User my Channel Content</a></li>

        </ul>
    </section>

    <section class="content  tab-content">

        <div id="allcontent" class="tab-pane fade in active">
            <div class="box box-info">
<!--                <div class="box-header with-border">
                    <a class="btn btn-primary pull-right" href="#" data-toggle="modal" data-target="#contentuploadmodal">Upload Content</a>
                </div>-->  
                <div class="box-body">
                    @if(count($stringerContents) > 0)
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="width30 text-center">SL.No</th>
                                <th class="width500 text-center">Title</th>
                                <th class="width50 text-center">Type of Content</th>
                                <th class="width100 text-center">Stringer Name</th>
                                <th class="width50 text-center">Date of Upload</th>
                                <th class="width50 text-center">Published By</th>
                                 <th class="width100 text-center">Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php $s=1; ?>
                            @foreach($stringerContents as $content)                         
                            <tr>
                                <td class="width30 text-center">{{ $s++ }}</td>
                                <td class="width500 text-center">{{ $content['contentTitle'] }}</td>
                                <td class="width50 text-center" >
                                    <span class="label label-primary" style="cursor:pointer; margin: auto 10px; background-color: #3c8dbc !important;" 
                                    data-toggle="modal" data-target="#showContentmodal"
                                    onclick="getContent('{{ $content['contentId'] }}');">
                                        {{ $content['contentType'] }}
                                    </span>

                                    </td>
                                <!-- <a data-toggle="modal" data-target="#imagemodal">Image</a> -->
                                <td class="width100 text-center">{{ $content['userDetails']['userName'] }}</td>
                                <td class="width50 text-center">{{ $content['createdDate'] }}</td>
                                <td class="width100 text-center">PJ</td>
                                <td class="width100 text-center">
                                    <select class="form-control selectrole" id="is_published_{{ $s }}" onchange="togglePublishStatus('{{ $s }}','{{ $content['contentId'] }}');">
                                        <option value="1" @if($content['isPublished'] == '1') selected @endif >Published</option>
                                        <option value="0" @if($content['isPublished'] == '0') selected @endif >Unpublished</option>
                                    </select>
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

        <div id="liststringer" class="tab-pane fade in">        
            <div class="box box-info">
                <div class="box-header with-border"> 
                    <h3><a class="btn btn-success" href="{{ url('stringer/create') }}"> Create Stringer</a></h3>
                </div>
                <div class="box-body">
                    @if(count($stringerLists) > 0)
                    <table id="example3" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="width30 text-center">SL.No</th>
                                <th class="width500 text-center">Name</th>
                                <th class="width50 text-center">Email ID</th>
                                <th class="width100 text-center">Mobile Number</th>
                                <th class="width50 text-center">Status</th>
<!--                                <th class="width100 text-center">PJ'S Name</th>-->
                                <th class="width100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach($stringerLists as $stringer)
                                <tr>
                                    <td class="width30 text-center">{{ $i++ }}</td>
                                    <td class="width300 text-center">{{ $stringer->username }}</td>
                                    <td class="width300 text-center">{{ $stringer->email }}</td>
                                    <td class="width300 text-center">{{ $stringer->mobile_number }}</td>
                                    <td class="red width50 text-center">
                                        @if($stringer->is_active == 1)
                                            <span class="label label-success">Active</span>
                                        @else
                                            <span class="label label-error">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="width200 text-center">
                                        <a class="btn btn-primary" href="{{ url('stringer/'.$stringer->id.'/edit') }}">Edit</a>
                                        <a class="btn btn-danger" data-href="{{ url('stringer/delete/'.$stringer->id) }}" data-toggle="modal" data-target="#confirm-delete">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                         </tbody>
                     </table>
                    @else
                        <table id="example4" class="table table-hover">
                          <tr>
                             <td>{{trans('admin.no_records')}}</td>
                          </tr>
                        </table>
                    @endif
                </div>
                <!-- /.box-body -->
            </div>
        </div>

        <div id="myupload" class="tab-pane fade in">
            <div class="box box-info">           
                <div class="box-header with-border"> 
                     <a class="btn btn-primary pull-right" href="#" data-toggle="modal" data-target="#contentuploadmodal">Upload Content</a>
                </div>
                <div class="box-body">
                    @if(count($pjContents)>0)
                    <table id="example5" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="width30 text-center">SL.No</th>
                                <th class="width500 text-center">Title</th>
                                <th class="width50 text-center">Type of Content</th>
                                <!-- <th class="width100 text-center">Stringer Name</th> -->
                                <th class="width50 text-center">Date of Upload</th>
                                 <th class="width100 text-center">Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php $j=1;?>
                        @foreach($pjContents as $pjContent)                           
                            <tr>
                                <td class="width30 text-center">{{ $j++}}</td>
                                <td class="width500 text-center">{{ $pjContent['contentTitle'] }}</td>
                                <td class="width50 text-center">                                    
                                    <span class="label label-primary" style="cursor:pointer; margin: auto 10px; background-color: #3c8dbc !important;" 
                                        data-toggle="modal" data-target="#showContentmodal"
                                        onclick="getContent('{{ $pjContent['contentId'] }}');">
                                        {{ $pjContent['contentType'] }}
                                    </span>
                                </td>
                                <!-- <a data-toggle="modal" data-target="#imagemodal">Image</a> -->
                                <!-- <td class="width100 text-center">Mohan</td> -->
                                <td class="width50 text-center">{{ $pjContent['createdDate'] }}</td>
                                 <td class="width100 text-center">
                                    <select class="form-control selectrole" id="pj_content_is_published_{{ $j }}" onchange="togglePjContentPublishStatus('{{ $j }}','{{ $pjContent['contentId'] }}');">
                                        <option value="1" @if($pjContent['isPublished'] == '1') selected @endif >Published</option>
                                        <option value="0" @if($pjContent['isPublished'] == '0') selected @endif >Unpublished</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                        <table id="example6" class="table table-hover">
                            <tr>
                                <td>{{trans('admin.no_records')}}</td>
                            </tr>
                        </table>
                    @endif
                </div>
                <!-- /.box-body -->
            </div>
        </div>

        <div id="usermy" class="tab-pane fade in">
            <div class="box box-info">            
                <div class="box-header with-border"> 
                </div>
                <div class="box-body">
                    @if(count($allUserContents) > 0)
                    <table id="example7" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="width30 text-center">SL.No</th>
                                <th class="width500 text-center">Username</th>
                                <th class="width50 text-center">Phone Number</th>
                                <th class="width100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $u=1; ?>
                            @foreach($allUserContents as $userChannels)
                            <tr>
                                <td class="width30 text-center">{{ $u++ }}</td>
                                <td class="width500 text-center">{{ $userChannels['userName'] }}</td>
                                <td class="width50 text-center">{{ $userChannels['userId'] }}</td>
                                <td class="width100 text-center">
                                    <a href="{{ url('/channels/'.$userChannels['channelId']) }}">View content</a>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                    @else
                        <table id="example8" class="table table-hover">
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


  <!-- Image Modal -->
  <div class="modal fade" id="showContentmodal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="title"></h4>
          <hr style="margin-bottom: 0px;">
        </div>
        <div class="modal-body" style="padding: 0px 15px;">
            <img style="display:none" id="img" src="" class="img-responsive">
            
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

  <!-- Upload content Modal -->
  <div class="modal fade" id="contentuploadmodal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload Content</h4>
        </div>
        <hr style="margin: 0px;">
        <div class="modal-body" style="padding-bottom: 0px;">
            <div class="" role="alert" id="msg" style="display:none">
                <p></p>
            </div>
            <form name="myForm" id="uploadContentForm" class="text-left" >
                <div class="col-md-12 form-group">
                    <label class="popupsub">Content Type</label><br>
                    <div class="col-md-3"><div class="row"><label for="filetext" class="radio"><input type="radio" name="fileupload" id="filetext" value="text" checked />Text</label></div></div>
                    <div class="col-md-3"><label for="fileimage" class="radio"><input type="radio" name="fileupload" id="fileimage" value="image" />Image</label></div>
                    <div class="col-md-3"><label for="fileaudio" class="radio"><input type="radio" name="fileupload" id="fileaudio" value="audio" />Audio</label></div>
                    <div class="col-md-3"><label for="fileavideo" class="radio"><input type="radio" name="fileupload" id="fileavideo" value="video" />Video</label></div>
                </div>

                <div id="fileupload" class="col-md-12 form-group">
                    <label for="uploadfile" class="popupsub">Upload file</label>
                    <input type="file" name="file" id="mediacontent" value="" />
                </div>

                <div class="col-md-12 form-group">
                  <label for="title" class="popupsub">Title</label>
                  <input type="text" name="title" class="form-control" id="inputChars" required="" maxlength="50">
                  <label class="pull-right"><span id="chars">50</span> characters remaining</label>
                </div>

                <div class="col-md-12 form-group">
                      <label for="Desc" class="popupsub">Description</label>
                      <textarea name="description" required="" class="form-control"></textarea>
                </div>                

                <div class="col-md-12 form-group text-right">
                      <button type="submit" class="btn btn-primary savebtn">Save</button>
                      <button type="button" data-dismiss="modal" class="btn btn-default cancelbtn">Cancel</button>
                </div>

                <div class="modal-footer">
                </div>

            </form>

        </div>

      </div>
    </div>
  </div>

<div id="loading">
        <div>
        <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>
        <span>Message</span>
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

$("#uploadContentForm").submit( function(event) {
    event.preventDefault();
    var formData = new FormData(this);
    var ldg = $('#loading');
    $.ajax({ 
        url: '{{url("/uploadContent")}}',
        type: 'post',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        beforeSend: function() { 
            $(".savebtn").prop('disabled', true); // disable save buttons on modal     
            $(".cancelbtn").prop('disabled', true); // disable cancel buttons on modal        
            ldg.find('> div > span').text('Please wait as your file is uploading').end().show();
        },
        success: function(response)
        {
            console.log(response);
            // return false;
            if(response == 1){
                ldg.hide();
                $("#uploadContentForm")[0].reset();
                $("#msg").addClass('alert alert-success');
                $("#msg p").html('Content has uploaded successfully!');
                $("#msg").show();
                location.reload();

            }else{
                ldg.hide();
                $(".savebtn").prop('disabled', false); // enable save buttons on modal    
                $(".cancelbtn").prop('disabled', false); // enable cancel buttons on modal 
                $("#msg").addClass('alert alert-danger');
                $("#msg p").html(response);
                $("#msg").show();
                return false;                
            }
        }
    });
    return false;
});

var maxLength = 50;
$('#inputChars').keyup(function() {
  var length = $(this).val().length;
  var length = maxLength-length;
  $('#chars').text(length);
});


function switchVar() {
    if($("#fileimage").prop("checked")){
        $("#mediacontent").attr('required','required');
        $("#mediacontent").attr('accept','image/*');
        $("#fileupload").show();
    }
    else if($("#fileaudio").prop("checked")){
        $("#mediacontent").attr('required','required');
        $("#mediacontent").attr('accept','audio/*');
        $("#fileupload").show();
    }
    else if($("#fileavideo").prop("checked")){
        $("#mediacontent").attr('required','required');
        $("#mediacontent").attr('accept','video/*');
        $("#fileupload").show();
    }
     else{
        $("#mediacontent").removeAttr('required');
        $("#mediacontent").removeAttr('accept');
        $("#fileupload").hide();
    }
    $("#chars").attr('required','required');
    $("#description").attr('required','required');
}

$(document).ready(function() {
    switchVar();
    $("input[name=fileupload]").change(switchVar);
    $('#query').attr("name", 'search_in_allcontent');
    $('#query').val('{{ $search_text }}');
    
    var hash = window.location.hash;
    if(hash) {
        var url = '{{ url("/pj:contentId") }}';
        var search_text_box_name = 'search_in_' + hash;

        search_text_box_name = search_text_box_name.replace('#','');

        url = url.replace(':contentId', hash);
        $('#search').attr("action", url);
        $('#query').attr("name", search_text_box_name);
    }
});

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




function togglePublishStatus($element_id, contentId) {
    var url;
    var is_published = $('#is_published_'+$element_id+' option:selected').val(); // get selected value
    var is_published_str = $('#is_published_'+$element_id+' option:selected').text(); // get selected value

    if (is_published == 1) { // require a URL
        url = '{{ url("publishContent/:contentId") }}';
    } else {
       url = '{{ url("unpublishContent/:contentId") }}';
    }
    url = url.replace(':contentId', contentId);
      
    $.ajax({
        url: url,
        type: 'post',
        cache:false,
        contentType: false,
        processData: false,
        success: function(response)
        {
            if(response == 1){
                alert(is_published_str + ' the content successfully');
            }else{
                alert('Error!! Unable to serve the request');
            }
        }
    });
    return false;
}

function togglePjContentPublishStatus($element_id, contentId) {
    var url;
    var is_published = $('#pj_content_is_published_'+$element_id+' option:selected').val(); // get selected value
    var is_published_str = $('#pj_content_is_published_'+$element_id+' option:selected').text(); // get selected value

    if (is_published == 1) { // require a URL
        url = '{{ url("publishContent/:contentId") }}';
    } else {
       url = '{{ url("unpublishContent/:contentId") }}';
    }
    url = url.replace(':contentId', contentId);
      
    $.ajax({
        url: url,
        type: 'post',
        cache:false,
        contentType: false,
        processData: false,
        success: function(response)
        {
            if(response == 1){
                alert(is_published_str + ' the content successfully');
            }else{
                alert('Error!! Unable to serve the request');
            }
        }
    });
    return false;
}

function updateSearchTextBoxName(searchTextboxElementName) {
    var search_text_tab = '';
    var url = '{{ url("/pj#:contentId") }}';
    url = url.replace(':contentId', searchTextboxElementName);
    
    if(searchTextboxElementName === 'allcontent') {
        search_text_tab = '{{ $search_text_arr["search_in_allcontent"] }}';
    } else if(searchTextboxElementName === 'liststringer') {
        search_text_tab = '{{ $search_text_arr["search_in_liststringer"] }}';
    } else if(searchTextboxElementName === 'myupload') {
        search_text_tab = '{{ $search_text_arr["search_in_myupload"] }}';
    } else if(searchTextboxElementName === 'usermy') {
        search_text_tab = '{{ $search_text_arr["search_in_usermy"] }}';
    }
    $('#query').attr("name", 'search_in_'+searchTextboxElementName);
//    $('#search').attr("action", $("form").attr('action')+"#"+searchTextboxElementName);
    $('#search').attr("action", url);
    $('#query').val(search_text_tab);
}

    $(document).ready(function() {
        $('#example1').DataTable( {
            "bFilter": true,
            "lengthMenu": lengthMenu,
            "responsive": true,
            "order": [[0, 'asc']],
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [6]},
                {"bSearchable": false, "aTargets": [6]}
            ],
            "dom": 'lfrtipB',
            "oLanguage": {
                "sSearch": "Filter"
             },
            "buttons": [
                {"extend": 'csv', "exportOptions": {"columns": [ 0, 1, 2, 3, 4, 5]} },
                {"extend": 'excel', "exportOptions": {"columns": [ 0, 1, 2, 3, 4, 5]} },
            ],
            "iDisplayLength": DefaultDisplayLength,        
        } );
        $('#example3').DataTable( {
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
        $('#example5').DataTable( {
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
        $('#example7').DataTable( {
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
                {"extend": 'excel', "exportOptions": {"columns": [ 0, 1, 2]} },
            ],
            "iDisplayLength": DefaultDisplayLength,        
        } );
    } );
</script>
@stop