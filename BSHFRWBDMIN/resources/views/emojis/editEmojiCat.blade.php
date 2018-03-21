@extends('layouts.default') @section('title') Edit {{ ucfirst($emojiCat['type']) }} Category @stop @section('content')

<div id="addaccount" class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section id="fullreports" class="content-header">

    </section>

    <section class="content  tab-content">
        <div id="addadmin" class="tab-pane fade in active">
            <div class="box box-info">
                <div class="box-header with-border">
                    @include('includes.messages')
                    <h4>Edit {{ ucfirst($emojiCat['type']) }} Category</h4>
                </div>
                <div class="box-body">
                    <form method="post" action="{{ url('emojis/cats/'.$emojiCat['categoryId']) }}">

                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Category Name</label>
                            </div>
                            <div class="col-md-4">
                                <input type="hidden" name="categoryId" value="{{ $emojiCat['categoryId'] }}">
                                <input type="hidden" name="type" value="{{ $emojiCat['type'] }}">
                                <input class="form-control text_box" required="" value="{{ $emojiCat['categoryName'] }}" 
                                placeholder="Name" name="categoryName" type="text">
                            </div>
                        </div>
                        
                        <?php 
                            $tabname = ($emojiCat['type'] == 'emoji')? '#emojicategory':'#stickercategory';
                        ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn bg-red btn-flat mar-right">Submit</button>
                            @if($emojiCat['type'] === 'emoji')
                                <a class="btn btn-default" href="{{ url('emojis#emojicategory') }}">Cancel</a>
                            @else
                                <a class="btn btn-default" href="{{ url('emojis#stickercategory') }}">Cancel</a>
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

@stop