@extends('layouts.default') @section('title') Edit Stringer @stop @section('content')

<div id="addaccount" class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section id="fullreports" class="content-header">

    </section>

    <section class="content  tab-content">
        <div id="addadmin" class="tab-pane fade in active">
            <div class="box box-info">
                <div class="box-header with-border">
                    @include('includes.messages')
                    <h4>Edit Stringer</h4>
                </div>
                <div class="box-body">
                    <form method="post" action="{{ url('stringer/'.$stringerData->id) }}">
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Name</label>
                            </div>
                            <div class="col-md-4">
                            	<input class="form-control text_box" required="" minlength="3" maxlength="75" placeholder="Name" name="name" type="text" 
                                value="{{ $stringerData->username }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Mobile Number</label>
                            </div>
                            <div class="col-md-4">                                
                                {!!Form::text('mobile_number',$stringerData->mobile_number,['required','disbaled', 'class'=>'text_box col-md-12 mobile', 'id'=>'mobile', 'placeholder'=>'Mobile number'])!!}                            	
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Email</label>
                            </div>
                            <div class="col-md-4">
                            	<input class="form-control email text_box" required="" name="email" type="email" placeholder="Email" 
                                value="{{ $stringerData->email }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Status</label>
                            </div>
                            <div class="col-md-4">
                                <label class="mar-right"> <input type="radio" value="1" name="is_active" class="minimal" {{ ($stringerData->is_active == 1)?'checked':'' }}> Active
                                </label><label> <input type="radio" value="0" name="is_active" class="minimal" {{ ($stringerData->is_active == 0)?'checked':'' }}> Inactive
                                </label>
                            </div>
                        </div>
                        
                        
  
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn bg-red btn-flat mar-right">Submit</button>
                            <a class="btn btn-default" href="{{ url('pj#liststringer') }}">Cancel</a>
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