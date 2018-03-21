@extends('layouts.default') @section('title') Edit {{ ucfirst($emojiStrickerData['type']) }} @stop @section('content')

<div id="addaccount" class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section id="fullreports" class="content-header">

    </section>

    <section class="content  tab-content">
        <div id="addadmin" class="tab-pane fade in active">
            <div class="box box-info">
                <div class="box-header with-border">
                    @include('includes.messages')
                    <h4>Edit {{ ucfirst($emojiStrickerData['type']) }}</h4>
                </div>
                <div class="box-body">
                    <form method="post" action="{{ url('emojis/'.$emojiStrickerData['emojiStickerId']) }}">

                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Title</label>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control text_box" required="" minlength="3" maxlength="75" placeholder="Title" name="title" type="text" value="{{ $emojiStrickerData['title'] }}">
                                <input class="form-control text_box" name="type" type="hidden" value="{{ $emojiStrickerData['type'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Current Image</label>
                            </div>
                            <div class="col-md-4">
                                <img src="{{ $emojiStrickerData['url'] }}" class="img-responsive" width="100px" height="100px">
                            </div>
                        </div>
                        <!--                        <div class="form-group">
                                                    <div class="col-md-2">
                                                        <label class="label-name">Edit Image</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="file" name="file" id="emoji" value="" class="form-control text_box"/>
                                                    </div>
                                                </div>-->
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="label-name">Category</label>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control text_box" name="categoryId">
                                    <option selected="" disabled="" hidden="">Select category</option>
                                    @if($emojiStrickerData['type'] === 'emoji') 
                                        @foreach($emojiCategories as $emojiCategory)  
                                        <option value="{{ $emojiCategory['categoryId'] }}" @if ($emojiStrickerData['categoryId'] == $emojiCategory['categoryId']) selected @endif  > {{ $emojiCategory['categoryName'] }}</option>

                                        @endforeach
                                    @else 
                                        @foreach($stickerCategories as $strickerCategory)  
                                        <option value="{{ $strickerCategory['categoryId'] }}" @if ($emojiStrickerData['categoryId'] == $strickerCategory['categoryId']) selected @endif  > {{ $strickerCategory['categoryName'] }}</option>

                                        @endforeach
                                    @endif

                                </select>
                                <span class="caret emjselect"></span>

                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn bg-red btn-flat mar-right">Submit</button>
                            @if($emojiStrickerData['type'] === 'emoji')
                                <a class="btn btn-default" href="{{ url('emojis') }}#emoji">Cancel</a>
                            @else
                                <a class="btn btn-default" href="{{ url('emojis') }}#sticker">Cancel</a>
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