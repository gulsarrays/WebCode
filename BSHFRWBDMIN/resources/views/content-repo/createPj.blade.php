@extends('layouts.default') @section('title') Create Pj @stop @section('content')
<style>
.listlabel label {
    margin-right: 5px;
    font-size: 13px;
    display: inline-block;
}
#mobile{
    margin-left: 40px;
}
</style>
<div id="addaccount" class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section id="fullreports" class="content-header">

    </section>

    <section class="content  tab-content">
        <div id="addadmin" class="tab-pane fade in active">
            <div class="box box-info">
                <div class="box-header with-border">
                    @include('includes.messages')
                    <h4>Create PJ</h4>
                </div>
                <div class="box-body">
                    <form method="post" action="{{ url('pj') }}" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Role</label>
                            </div>
                            <div class="col-md-4">
                                {!! Form::select('roles[]', $roles,[], array('required', 'class' => 'form-control','multiple','id'=>'role')) !!}
                            </div>
                        </div>

                        <div class="form-group" id="listpermissions">
                            <div class="col-md-2">
                                <label class="label-name">Permissions</label>
                            </div>
                            <div class="col-md-4 listlabel">
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="Caption">Profile Image</label>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control text_box" name="image" type="file" required accept="image/*">
                            </div>                                          
                        </div>

                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Name</label>
                            </div>
                            <div class="col-md-4">
                            	<input class="form-control text_box" required="" minlength="3" maxlength="75" placeholder="Name" name="name" type="text" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Mobile Number</label>
                            </div>
                            <div class="col-md-4">
                                {!!Form::text('country_code',old('country_code'),['required', 'class'=>'text_box col-md-3 mobile', 'id'=>'ccode', 'placeholder'=>'91'])!!}
                                {!!Form::text('mobile_number1',old('mobile_number1'),['required', 'class'=>'text_box col-md-6 mobile', 'id'=>'mobile', 'placeholder'=>'Mobile number'])!!}
                            	<!-- <input class="form-control text_box" required="" minlength="7" maxlength="13" placeholder="Mobile Number" name="mobile_number" type="tel" value=""> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Email</label>
                            </div>
                            <div class="col-md-4">
                            	<input class="form-control email text_box" required="" name="email" type="email" placeholder="Email" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Access to Bushfire News</label>
                            </div>
                            <div class="col-md-4">
								<label class="mar-right label-name"> 
									<input class="minimal" required="" checked="checked" name="access['bushfire_news']" type="radio" value="1">Yes 
								</label> 
<!--								<label class="label-name">
									<input class="minimal" required="" name="access['bushfire_news']" type="radio" value="0">No 
								</label>-->
                            </div>
                        </div>
                         <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Access to All User My Channel</label>
                            </div>
                            <div class="col-md-4">
								<label class="mar-right label-name"> 
									<input class="minimal" required="" checked="checked" name="access['user_my_channels']" type="radio" value="1">Yes 
								</label> 
<!--								<label class="label-name">
									<input class="minimal" required="" name="access['user_my_channels']" type="radio" value="0">No 
								</label>-->
                            </div>
                        </div>
                         <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Access to Sponsered Channel</label>
                            </div>
                            <div class="col-md-4">
								<label class="mar-right label-name"> 
									<input class="minimal" required="" checked="checked" name="access['sponsored_channels']" type="radio" value="1">Yes 
								</label> 
								<label class="label-name">
									<input class="minimal" required="" name="access['sponsored_channels']" type="radio" value="0">No 
								</label>
                            </div>
                        </div>
                         <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Access to Newsfeed</label>
                            </div>
                            <div class="col-md-4">
								<label class="mar-right label-name"> 
									<input class="minimal" required="" checked="checked" name="access['news_feed']" type="radio" value="1">Yes 
								</label> 
								<label class="label-name">
									<input class="minimal" required="" name="access['news_feed']" type="radio" value="0">No 
								</label>
                            </div>
                        </div>
  
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn bg-red btn-flat mar-right">Submit</button>
                            <a class="btn btn-default" href="{{ url('content-repo#viewpjList') }}">Cancel</a>
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

<script>
$("#role").change(function(){
    var roleid = $(this).val();
    $.ajax({ 
            url: '{{url("/getrole")}}'+'/'+roleid,
            type: 'get',
            success: function(result)
            {
                if(result){
                    $("#listpermissions .listlabel").html("");
                    $.each(result, function( key, value ) {                     
                        var labels = '<label class="label label-success">'+ value.display_name +' </label> ';
                        $("#listpermissions .listlabel").append(labels);
                    });
                }else{
                    var msg = 'Data not available';
                    $("#listpermissions .listlabel").append(msg);
                }
            }
        });
});

$('.mobile').keypress(function (e) {
    var regex = new RegExp("^[0-9]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }
    e.preventDefault();
    return false;
});

</script>
@stop