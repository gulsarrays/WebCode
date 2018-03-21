@extends('layouts.default') @section('title') Add {{ ucfirst($v_type) }} @stop @section('content')

<div id="addaccount" class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section id="fullreports" class="content-header">

    </section>

    <section class="content  tab-content">
        <div class="" role="alert" id="msg" style="display:none">
                <p></p>
            </div>
        <div id="addadmin" class="tab-pane fade in active">
            <div class="box box-info">
                <div class="box-header with-border">
                    @include('includes.messages')
                    <h4>Add {{ ucfirst($v_type) }}</h4>
                </div>
                <div class="box-body">
                    {{ Form::open(array('url' => 'emojis','files'=>'true', 'name' => 'myForm', 'id' => 'myForm')) }}

                    <div class="form-group">
                        <div class="col-md-2">
                            <label class="label-name">Title</label>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control text_box" required="" minlength="3" maxlength="75" placeholder="Title" name="title" type="text" value="" oninvalid="setCustomValidity('Please enter Title.Minimum length is 6 characters, Maximun length is 75 characters')" oninput="setCustomValidity('')">
                            <input class="form-control text_box" name="type" type="hidden" value="{{ $v_type }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2">
                            <label class="label-name">Add Image</label>
                        </div>
                        <div class="col-md-4">
                            <input type="file" name="file" id="emoji" value="" class="form-control text_box"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2">
                            <label class="label-name">Category</label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control text_box" name="categoryId" required oninvalid="setCustomValidity('Please select the category from the available options')" oninput="setCustomValidity('')">
                                <option selected="" disabled="" value = '' hidden="">Select category</option>
                                @if($v_type === 'emoji') 
                                    @foreach($emojiCategories as $emojiCategory)  
                                    <option value="{{ $emojiCategory['categoryId'] }}" > {{ $emojiCategory['categoryName'] }}</option>               
                                    @endforeach
                                @else 
                                    @foreach($stickerCategories as $strickerCategory)  
                                    <option value="{{ $strickerCategory['categoryId'] }}" > {{ $strickerCategory['categoryName'] }}</option>                                        
                                    @endforeach
                                @endif
                            </select>
                            <span class="caret emjselect"></span>

                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button id ="submit_btn" type="submit" class="btn bg-red btn-flat mar-right">Submit</button>
                        @if($v_type === 'emoji') 
                        <a class="btn btn-default" href="{{ url('emojis#emoji') }}">Cancel</a>
                        @else 
                        <a class="btn btn-default" href="{{ url('emojis#sticker') }}">Cancel</a>
                        @endif
                    </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
    <!-- /.content -->
</div>


<script type="text/javascript"> 

//binds to onchange event of your input field
$('#emoji').bind('change', function() {
     $("#msg").hide(); 

    var file = document.getElementById('emoji').files[0];
    
    var ext = file.name.split('.').pop().toLowerCase();
    if ($.inArray(ext, ['png']) == -1){
        $("#msg").addClass('alert alert-danger');
        $("#msg p").html('upload file extension must be .png');
        $("#msg").show();
        $('#submit_btn').prop('disabled', true);
        return false;
    } 
    /*else {

        var reader = new FileReader();
        //Read the contents of Image File.
        reader.readAsDataURL(file);
        reader.onload = function (e) {
            //Initiate the JavaScript Image object.
            var image = new Image();

            //Set the Base64 string return from FileReader as source.
            image.src = e.target.result;

            //Validate the File Height and Width.
            image.onload = function () {
                var height = this.height;
                var width = this.width;
                if (height > 60 || width > 60) {
                    $("#msg").addClass('alert alert-danger');
                    $("#msg p").html('Height and Width must not exceed 60px.');
                    $("#msg").show(); 
                    $('#submit_btn').prop('disabled', true);
                }
                return false;
            };
            return false;
        }
    }*/
     $('#submit_btn').prop('disabled', false);
});

document.forms['myForm'].addEventListener('submit', function( evt ) { 
    if(file && file.size > <?php echo UPLOAD_FILE_DATA_RESTRICTION;?>) { // 50 MB (this size is in bytes)
        //Prevent default and display error
        evt.preventDefault();
        $("#msg").addClass('alert alert-danger');
        $("#msg p").html('upload file size must be less than <?php echo UPLOAD_FILE_DATA_RESTRICTION;?>');
        $("#msg").show();
        return false;
    }
    return false;
}, false);

</script>
@stop
