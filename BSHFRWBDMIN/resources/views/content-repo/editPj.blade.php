@extends('layouts.default') @section('title') Edit Pj @stop @section('content')

<div id="addaccount" class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section id="fullreports" class="content-header">

    </section>

    <section class="content  tab-content">
        <div id="addadmin" class="tab-pane fade in active">
            <div class="box box-info">
                <div class="box-header with-border">
                    @include('includes.messages')
                    <h4>Edit PJ</h4>
                </div>
                <div class="box-body">
                    <form method="post" action="{{ url('pj/'.$pjData->id) }}" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Name</label>
                            </div>
                            <div class="col-md-4">
                            	<input class="form-control text_box" required="" minlength="3" maxlength="75" placeholder="Name" name="name" type="text" 
                                value="{{ $pjData->username }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="Caption">Profile Image</label>
                            </div>
                            <div class="col-md-4">
                                @if(!empty($pjData['image']))
                                    <img src="{{ URL::asset('assets/img/profiles/'.$pjData->image)}}" style="width: 150px;height:150px"></td>
                                    <input class="form-control text_box" name="image" type="file" accept="image/*">
                                @else  
                                    <input class="form-control text_box" required="" name="image" type="file" accept="image/*">
                                @endif
                            </div>                                          
                        </div>

                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Mobile Number</label>
                            </div>
                            <div class="col-md-4">                                
                                {!!Form::text('mobile_number',$pjData->mobile_number,['required','readonly', 'class'=>'text_box col-md-12 mobile', 'id'=>'mobile', 'placeholder'=>'Mobile number'])!!}                            	
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Email</label>
                            </div>
                            <div class="col-md-4">
                            	<input class="form-control email text_box" required="" name="email" type="email" placeholder="Email" 
                                value="{{ $pjData->email }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Status</label>
                            </div>
                            <div class="col-md-4">
                                <label class="mar-right"> <input type="radio" value="1" name="is_active" class="minimal" {{ ($pjData->is_active == 1)?'checked':'' }}> Active
                                </label><label> <input type="radio" value="0" name="is_active" class="minimal" {{ ($pjData->is_active == 0)?'checked':'' }}> Inactive
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Access to Bushfire News</label>
                            </div>
                            <div class="col-md-4">
								<label class="mar-right label-name"> 
									<input class="minimal" required="" {{ ($access[0]->value == 1)?'checked':'' }} name="access['bushfire_news']" type="radio" value="1">Yes 
								</label> 
<!--								<label class="label-name">
									<input class="minimal" required="" {{ ($access[0]->value == 0)?'checked':'' }} name="access['bushfire_news']" type="radio" value="0">No 
								</label>-->
                            </div>
                        </div>
                         <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Access to All User My Channel</label>
                            </div>
                            <div class="col-md-4">
								<label class="mar-right label-name"> 
									<input class="minimal" required="" {{ ($access[1]->value == 1)?'checked':'' }} checked="checked" name="access['user_my_channels']" type="radio" value="1">Yes 
								</label> 
<!--								<label class="label-name">
									<input class="minimal" required="" {{ ($access[1]->value == 0)?'checked':'' }} name="access['user_my_channels']" type="radio" value="0">No 
								</label>-->
                            </div>
                        </div>
                         <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Access to Sponsered Channel</label>
                            </div>
                            <div class="col-md-4">
								<label class="mar-right label-name"> 
									<input class="minimal" required="" name="access['sponsored_channels']" type="radio" value="1" {{ ($access[2]->value == 1)?'checked':'' }}>Yes 
								</label> 
								<label class="label-name">
									<input class="minimal" required="" {{ ($access[2]->value == 0)?'checked':'' }} 
                                    name="access['sponsored_channels']" type="radio" value="0">No 
								</label>
                            </div>
                        </div>
                         <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Access to Newsfeed</label>
                            </div>
                            <div class="col-md-4">
								<label class="mar-right label-name"> 
									<input class="minimal" required="" name="access['news_feed']" type="radio" value="1" {{ ($access[3]->value == 1)?'checked':'' }}>Yes 
								</label> 
								<label class="label-name">
									<input class="minimal" required="" {{ ($access[3]->value == 0)?'checked':'' }} name="access['news_feed']" type="radio" value="0">No 
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