@extends('layouts.default') @section('title') Home | PJ @stop @section('content')

<div id="addaccount" class="content-wrapper">
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
                    <a class="btn btn-primary pull-right" href="#" data-toggle="modal" data-target="#contentuploadmodal">Upload Content</a>
                </div>
                <div class="box-body">
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
                            <tr>
                                <td class="width30 text-center">1</td>
                                <td class="width500 text-center">Cinema</td>
                                <td class="width50 text-center"><a data-toggle="modal" data-target="#imagemodal">Image</a></td>
                                <td class="width50 text-center">23 Nov 2017</td>
                                <td class="width100 text-center">Mohan</td>
                                <td class="width100 text-center"><span class="text-primary">Published</span></td>
                                <td class="width100 text-center">
                                        <a class="btn btn-primary" href="http://bushfireadmin.app/stringer/1/edit">Edit</a>
                                        <a class="btn btn-danger" data-href="" data-toggle="modal" data-target="#confirm-delete">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="width30 text-center">2</td>
                                <td class="width500 text-center">Movie</td>
                                <td class="width50 text-center"><a data-toggle="modal" data-target="#videomodal">Video</a></td>
                                <td class="width50 text-center">23 Nov 2017</td>
                                <td class="width100 text-center">Mohan</td>
                                <td class="width100 text-center"><span class="text-danger">Not published</span></td>
                                <td class="width100 text-center">
                                        <a class="btn btn-primary" href="http://bushfireadmin.app/stringer/1/edit">Edit</a>
                                        <a class="btn btn-danger" data-toggle="modal" data-target="#confirm-delete">Delete</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
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
  <div class="modal fade" id="imagemodal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ICC Cricket</h4>
          <hr style="margin-bottom: 0px;">
        </div>
        <div class="modal-body" style="padding: 0px 15px;">
            <img src="http://52.76.23.165/uploads/blog-images/2017-12-20-17-08-57-0031.jpg" class="img-responsive">
            <hr style="margin-bottom: 0px;">
        </div>
        <div class="modal-footer">
          <p class="modalcontent">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Video Modal -->
  <div class="modal fade" id="videomodal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ICC Cricket</h4>
          <hr style="margin-bottom: 0px;">
        </div>
        <div class="modal-body" style="padding: 0px 15px;">
            <video src="SampleVideo_1280x720_2mb.mp4" controls class="img-responsive" width="100%"></video>
            <hr style="margin-bottom: 0px;">
        </div>
        <div class="modal-footer">
          <p class="modalcontent">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap</p>
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
                      <textarea name="description" class="form-control"></textarea>
                </div>                

                <div class="col-md-12 form-group text-right">
                      <button type="submit" class="btn btn-primary">Save</button>
                      <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                </div>

                <div class="modal-footer">
                </div>

            </form>

        </div>

      </div>
    </div>
  </div>

  <script type="text/javascript"> 

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
}

$(document).ready(function() {
    switchVar();
    $("input[name=fileupload]").change(switchVar);
});


</script>
@stop