@extends('layouts.default') @section('title') Home | Stringer @stop @section('content')

<div id="addaccount" class="" style="min-height:678px">
    <!-- Content Header (Page header) -->
    <div class="box-header with-border"> 
        @include('includes.messages')
    </div>

    <section class="content-header">
        <h4>View Content</h4>   
    </section>

    <section class="content  tab-content">
        <div id="allcontent" class="tab-pane fade in active">
            <div class="box box-info">
                <div class="box-header with-border">
                    <a class="btn btn-primary pull-right" href="#" data-toggle="modal" data-target="#contentuploadmodal" onclick='func_uploadContent()'>Upload Content</a>
                </div>
                <div class="box-body">
                    
                    <!--@include('includes.search',['resetUrl' => '/stringer'])-->
                    
                    
                    @if(count($stringerContents) > 0)
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="width30 text-center">SL.No</th>
                                <th class="width500 text-center">Title of Content</th>
                                <th class="width50 text-center">Content Type</th>
                                <th class="width50 text-center">Uploaded Date</th>
                                <th class="width100 text-center">PJ Name</th>
                                <th class="width50 text-center">Status</th>
                                <th class="width100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php $s=1; 
                            $count = 0;
                            ?>
                            @foreach($stringerContents as $content)   
                            <?php
                            $published_stats_arr = array('1',1,true,'true','Published','published');
                            
                            if(in_array($content['isPublished'],$published_stats_arr, true)) {
                                $published_status_str = "Published";                                
                            } else {
                                $published_status_str = "Unpublished";
                            }
                            
                            if(empty($content['contentDescription'])) {
                                $content['contentDescription'] = "DESCRIPTION variable IS MISSING IN API RESPONSE";
                            }
                            ?>
                            <tr>
                                <td class="width30 text-center">{{ $s++ }}</td>
                                <td class="width500 text-center"> {{ $content['contentTitle'] }}</td>
                                <td class="width50 text-center"><a data-toggle="modal" data-target="#imagemodal_ttt" onclick="displayContentModel('{{ $content['contentType'] }}','{{ CONTENT_PATH.$content['contentPath'] }}','{{ $content['contentTitle'] }}','{{ $content['contentDescription'] }}');"><span class="label label-primary" style="cursor:pointer; margin: auto 10px; background-color: #3c8dbc !important;" data-toggle="modal" data-target="#showContentmodal">{{ $content['contentType'] }}</span></a></td>
                                <td class="width50 text-center">{{ $content['uploadedDate'] }}</td>
                                <td class="width100 text-center">{{ $content['pjName'] }}</td>
                                <td class="width100 text-center"><span class="text-primary"><?php echo $published_status_str;?></span></td>
                                <td class="width100 text-center">
                                    <a class="btn btn-primary" href="javascript:;" onclick="editContent('{{ $content['contentId'] }}');">Edit</a>
                                    <a class="btn btn-danger" data-href="{{url('stringer/deleteContent/'.$content['contentId'])}}" data-toggle="modal" data-target="#confirm-delete">Delete</a>
                                </td>
                            </tr>
                            <?php
                            $count++;
                            ?>
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

<!-- Image Modal -->
<div class="modal fade " id="imagemodal_ttt" role="dialog">
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
                <input type="hidden" name="contentId" id="contentId">
                <div class="col-md-12 form-group" id="contentUpload_div">
                    <label class="popupsub">Content Type</label><br>
                    <div class="col-md-3">
                        <div class="row">
                            <label for="filetext" class="radio">
                                <input type="radio" name="fileupload" id="filetext" value="text" checked />Text                             </label>
                        </div>
                    </div>
                    <div class="col-md-3"><label for="fileimage" class="radio"><input type="radio" name="fileupload" id="fileimage" value="image" />Image</label></div>
                    <div class="col-md-3"><label for="fileaudio" class="radio"><input type="radio" name="fileupload" id="fileaudio" value="audio" />Audio</label></div>
                    <div class="col-md-3"><label for="fileavideo" class="radio"><input type="radio" name="fileupload" id="fileavideo" value="video" />Video</label></div>
                </div>
                <div class="col-md-12 form-group" id='contentEdit_div'>
                    
                    <label class="popupsub">Content Type</label><br>
                    <div class="col-md-3"><div class="row" ><label for="filetext" class="radio content_type_div"><input type="radio" name="edit_fileupload" id="filetext" value="text" checked /><span>Text</span></label></div></div>
                    
                     <div class="col-md-6 uplimage" id='uplimage'>
                    <label for="current_uploadfile" class="popupsub">Current Content</label><br>
                    <img id='content_image' style="width: 100%; max-width: 160px; height: auto;">
                  </div>
                </div>
                
                

                <div id="fileupload" class="col-md-12 form-group">
                  <div class="col-md-6" id="fileupload_div">
                    <label for="uploadfile" class="popupsub">Upload file</label>
                    <input type="file" name="file" id="mediacontent" value="" />
                  </div>
                </div>


                <div class="col-md-12 form-group">
                  <label for="title" class="popupsub">Title</label>
                  <input type="text" name="title" class="form-control" id="inputChars" required="" maxlength="50">
                  <label class="pull-right"><span id="chars">50</span> characters remaining</label>
                </div>

                <div class="col-md-12 form-group">
                      <label for="Desc" class="popupsub">Description</label>
                      <textarea name="description" class="form-control" id="description"></textarea>
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

document.forms['myForm'].addEventListener('submit', function( evt ) {
    var file = document.getElementById('mediacontent').files[0];

    if(file && file.size > <?php echo UPLOAD_FILE_DATA_RESTRICTION;?>) { // 50 MB (this size is in bytes)
        //Prevent default and display error
        evt.preventDefault();
        $("#msg").addClass('alert alert-danger');
        $("#msg p").html('upload file size must be less than 50MB');
        $("#msg").show();
        return false;
    }
    return false;
}, false);

$("#uploadContentForm").submit( function(event) {
    var url_endpoint;       
    url_endpoint = '{{url("/uploadContent")}}';
    var msg_str;
    msg_str = 'Content has been uploaded successfully!';
    
    var ldg = $('#loading');
     
    if($("#contentId").val().length > 0) {
        url_endpoint = '{{url("/updateContent")}}';
        msg_str = 'Content has been updated successfully!';
        $("#contentUpload_div").hide();
        $("#contentEdit_div").show();
    }
    
    event.preventDefault();
    var formData = new FormData(this);
    $.ajax({ 
        url: url_endpoint,
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
            if(response == 1){
                
                ldg.hide();
                $("#uploadContentForm")[0].reset();
                $("#msg").addClass('alert alert-success');
                $("#msg p").html(msg_str);
                $("#msg").show();
                location.reload();
//                window.location="{{URL::to('stringer')}}";

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
        $("#fileupload").show();
    }
    else if($("#fileaudio").prop("checked")){
        $("#mediacontent").attr('required','required');
        $("#fileupload").show();
    }
    else if($("#fileavideo").prop("checked")){
        $("#mediacontent").attr('required','required');
        $("#fileupload").show();
    }
     else{
        $("#mediacontent").removeAttr('required');
        $("#fileupload").hide();
    }
    $("#chars").attr('required','required');
    $("#description").attr('required','required');
}

$(document).ready(function() {
    switchVar();
    $("input[name=fileupload]").change(switchVar);
        $('.uplimage').hide();
        $("#contentUpload_div").show();
        $("#contentEdit_div").hide()
});
function editContent(contentId) {
     
    var url = '{{ url("getContent/:contentId") }}';
    url = url.replace(':contentId', contentId);
    
    var content_id;
    var content_type;
    var content_title;    
    var content_desc;
    var content_path;
    var content_thumbnail_path;

    $.ajax({ 
        url: url,
        type: 'get',
        cache:false,
        contentType: false,
        processData: false,
        success: function(response)
        {
            content_id = response.data.item.contentId;
            content_type = response.data.item.contentType;
            content_title = response.data.item.contentTitle;
            content_desc = response.data.item.contentDescription;
            content_path = '<?php echo CONTENT_PATH;?>'+response.data.item.contentPath;
            content_thumbnail_path = '<?php echo CONTENT_PATH;?>'+response.data.item.contentThumbnailPath;

            if(response.status == 1){
                $("#contentUpload_div").hide();
                $("#contentEdit_div").show();
                switch(content_type) {       
                    case 'image/jpeg':
                        $('.content_type_div span').text('Image');                        
                          $('.uplimage').show();
                        break;
                    case 'audio/mpeg':
                        $('.content_type_div span').text('Audio');
                          $('.uplimage').hide();
                        break;
                    case 'video/mp4':
                        $('.content_type_div span').text('Video');
                          $('.uplimage').hide();
                        break;
                    default:
                        $('.content_type_div span').text('Text');
                        $('.uplimage').hide();
                } 
             
                $("#contentId").val(content_id);
                $("#inputChars").val(content_title);
                $("#description").val(content_desc);  
                $('#content_image').prop('src', content_path)
                $('#contentuploadmodal').modal('show');

                $("#mediacontent").removeAttr('required');
                

                $('#fileupload_div').hide();
                
               

            }else{
                $("#msg").addClass('alert alert-danger');
                $("#msg p").html(response);
                $("#msg").show();
                return false;                
            }
        }
    });
    return false;
    
}

function func_uploadContent() {
    $("#contentUpload_div").show();
    $("#contentEdit_div").hide()
    $('#fileupload_div').show();
    $("#contentId").val('');
    $("#inputChars").val('');
    $("#description").val(''); 
    $("#filetext").prop("checked", true);
}

function displayContentModel(contentType,contentPath,contentTitle,contentDescription) {
    var str_model;
    if(contentType === 'text') {
        $('#imagemodal_ttt').addClass(' imagemodalc');
        $('#imagemodal_ttt').removeClass(' videomodalc');
        str_model = '<div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">'+contentTitle+'</h4><hr style="margin-bottom: 0px;"></div><div class="modal-footer"><p class="modalcontent">'+contentDescription+'</p></div></div></div>';
    } else if(contentType === 'video/mp4' || contentType === 'audio/mpeg') {
        $('#imagemodal_ttt').addClass(' videomodalc');
        $('#imagemodal_ttt').removeClass(' imagemodalc');
        str_model = '<div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">'+contentTitle+'</h4><hr style="margin-bottom: 0px;"></div><div class="modal-body" style="padding: 0px 15px;"><video src="'+contentPath+'" controls class="img-responsive" width="100%"></video><hr style="margin-bottom: 0px;"></div><div class="modal-footer"><p class="modalcontent">'+contentDescription+'</p></div></div></div>';
    } else if(contentType === 'image/jpeg') {        
        $('#imagemodal_ttt').addClass(' imagemodalc');
        $('#imagemodal_ttt').removeClass(' videomodalc');
        str_model = '<div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">'+contentTitle+'</h4><hr style="margin-bottom: 0px;"></div><div class="modal-body" style="padding: 0px 15px;"><img src="'+contentPath+'" class="img-responsive"><hr style="margin-bottom: 0px;"></div><div class="modal-footer"><p class="modalcontent">'+contentDescription+'</p></div></div></div>';
    }
    
    
    $('#imagemodal_ttt').html(str_model);
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
                {"extend": 'excel', "exportOptions": {"columns": [  0, 1, 2, 3, 4, 5]} },
            ],
            "iDisplayLength": DefaultDisplayLength,
        } );
    } );
</script>
@stop