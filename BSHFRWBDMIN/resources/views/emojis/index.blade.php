@extends('layouts.default') @section('title') Home | Emojis @stop @section('content')

<div id="addaccount" class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="box-header with-border"> 
        @include('includes.messages')
    </div>

    <!-- @include('includes.search',['resetUrl' => '/emojis','fromUrl'=>'/emojis']) -->

    <section id="fullreports" class="content-header">
        <ul class="nav nav-pills" id="reportstabs">
            <li class="active"><a data-toggle="pill" href="#emoji" onclick="updateSearchTextBoxName('emoji');">Emoji</a></li>
            <li><a data-toggle="pill" href="#sticker" onclick="updateSearchTextBoxName('sticker');">Sticker</a></li>
            <!--<li><a data-toggle="pill" href="#category" onclick="updateSearchTextBoxName('category');">Category</a></li>-->
            <li><a data-toggle="pill" href="#emojicategory" onclick="updateSearchTextBoxName('emojicategory');">Emoji Category</a></li>
            <li><a data-toggle="pill" href="#stickercategory" onclick="updateSearchTextBoxName('stickercategory');">Sticker Category</a></li>
        </ul>
    </section>

    <section class="content  tab-content">
        <div id="emoji" class="tab-pane fade in active">
            <div class="box box-info">
                <div class="box-header with-border">
                    <div class="" role="alert" id="msg" style="display:none">
                        <p></p>
                    </div>
                    <h4>Total Emoji's : {{ count($emojis) }}</h4>
                    <h2><a class="btn btn-success" href="{{ url('emojis/create?type=emoji') }}"> + Add Emoji</a></h2>
                </div>
                <div class="box-body">
                    @if(!empty($emojis))
                    <table id="listEmojis" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="width50 text-center">No</th>
                                <th class="width500 text-center">Title</th>
                                <th class="width500 text-center">Category</th>
                                <th class="width300 text-center">Image</th>
                                <th class="width300 text-center">Created Date</th>
                                <th class="width200 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($emojis as $emoji)                            
                            <tr>
                                <td class="width30 text-center">{{ $i++ }}</td>
                                <td class="width300 text-center">{{ $emoji['title'] }}</td>
                                <td class="width300 text-center">{{ $emoji['categoryName'] }}</td>
                                <td class="width500 text-center"> <img src="{{ $emoji['url']}}" width="60" height='60'>
                                </td>
                                <td class="width300 text-center">
                                    {{Carbon\Carbon::parse($emoji['importDatetime'])->format('jS M Y') }}
                                </td>
                                <td class="width200 text-center">
                                    <a class="btn btn-primary" href="{{ url('emojis/'.$emoji['emojiStickerId'].'/edit') }}">Edit</a>
                                    <a class="btn btn-danger" data-href="{{url('emojis/deleteemojistickers/'.$emoji['type'].'/'.$emoji['emojiStickerId'])}}" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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

        <div id="sticker" class="tab-pane fade">
            <div class="box box-info">
                <div class="box-header with-border">
                    <div class="" role="alert" id="msg" style="display:none">
                        <p></p>
                    </div>
                    <h4>Total Stickers's :{{ count($stickers) }}</h4>
                    <h2><a class="btn btn-success" href="{{ url('emojis/create?type=sticker') }}"> + Add Stickers</a></h2>
                </div>
                <div class="box-body">
                    @if(!empty($stickers))
                    <table id="listStikers" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="width30 text-center">No</th>
                                <th class="width500 text-center">Title</th>
                                <th class="width500 text-center">Category</th>
                                <th class="width300 text-center">Image</th>
                                <th class="width300 text-center">Created Date</th>
                                <th class="width200 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $s = 1; ?>
                            @foreach($stickers as $sticker)
                            <tr>
                                <td class="width30 text-center">{{ $s++ }}</td>
                                <td class="width300 text-center">{{ $sticker['title'] }}</td>
                                <td class="width300 text-center">{{ $sticker['categoryName'] }}</td>
                                <td class="width500 text-center">
                                    <img src="{{ $sticker['url']}}" width="60" height='60'> 
                                </td>
                                <td class="width300 text-center">
                                    {{Carbon\Carbon::parse($sticker['importDatetime'])->format('jS M Y') }}
                                </td>
                                <td class="width200 text-center">
                                    <a class="btn btn-primary" href="{{ url('emojis/'.$sticker['emojiStickerId'].'/edit') }}">Edit</a>
                                    <a class="btn btn-danger" data-href="{{url('emojis/deleteemojistickers/'.$sticker['type'].'/'.$sticker['emojiStickerId'])}}" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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

        <div id="emojicategory" class="tab-pane fade">
            
            <div class="box box-info">
                <div class="box-header with-border">
                    <h4>Total Emoji categories : {{ (count($emojiCategories) > 0)? count($emojiCategories) :0 }}</h4>
                    <h2><a class="btn btn-success" href="{{ url('emojis/cats/create?type=emoji') }}"> + Add Emoji Category</a></h2>
                </div>

                <div class="box-body">
                    @if(!empty($emojiCategories))
                    <table id="listEmojiCategories" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="width30 text-center">No</th>
                                <th class="width500 text-center">Category</th>
                                <th class="width100 text-center">Created Date</th>
                                <th class="width100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $e = 0; ?>
                            @foreach($emojiCategories as $emojiCats)                             
                            <tr>
                                <td class="width30 text-center">{{ ++$e }}</td>
                                <td class="width300 text-center">{{ $emojiCats['categoryName'] }}</td>
                                <td class="width100 text-center">
                                    {{Carbon\Carbon::parse($emojiCats['createdDate'])->format('jS M Y') }}
                                </td>
                                <td class="width100 text-center">
                                    <a class="btn btn-primary" href="{{ url('emojis/cats/'.$emojiCats['categoryId'].'/edit') }}">Edit</a>
                                    <a class="btn btn-danger" data-href="{{url('emojis/cats/deletecategory/'.$emojiCats['type'].'/'.$emojiCats['categoryId'])}}" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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

        <div id="stickercategory" class="tab-pane fade">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h4>Total Sticker categories : {{ (count($stickerCategories) > 0)? count($stickerCategories) :0 }}</h4>
                    <h2><a class="btn btn-success" href="{{ url('emojis/cats/create?type=sticker') }}"> + Add Sticker Category</a></h2>
                </div>
                <div class="box-body">
                    @if(!empty($stickerCategories))

                    <table id="listStickerCategories" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="width30 text-center">No</th>
                                <th class="width500 text-center">Category</th>
                                <th class="width100 text-center">Created Date</th>
                                <th class="width100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $s = 0; ?>
                            @foreach($stickerCategories as $stickerCats)                             
                            <tr>
                                <td class="width30 text-center">{{ ++$s }}</td>
                                <td class="width300 text-center">{{ $stickerCats['categoryName'] }}</td>
                                <td class="width100 text-center">
                                    {{Carbon\Carbon::parse($stickerCats['createdDate'])->format('jS M Y') }}
                                </td>
                                <td class="width100 text-center">
                                    <a class="btn btn-primary" href="{{ url('emojis/cats/'.$stickerCats['categoryId'].'/edit') }}">Edit</a>
                                    <a class="btn btn-danger" data-href="{{url('emojis/cats/deletecategory/'.$stickerCats['type'].'/'.$stickerCats['categoryId'])}}" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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
           
        <!-- /.box -->

    </section>
    <!-- /.content -->
    <!-- /.content -->
</div>

<script>
    var hash = window.location.hash;
    hash && $('ul.nav a[href="' + hash + '"]').tab('show');

    $('.nav-pills a').click(function (e) {
        $(this).tab('show');
        var scrollmem = $('body').scrollTop();
        window.location.hash = this.hash;
        $('html,body').scrollTop(scrollmem);
    });

    function updateSearchTextBoxName(searchTextboxElementName) {
        var search_text_tab = '';
        var url = '{{ url("/emojis#:contentId") }}';
        url = url.replace(':contentId', searchTextboxElementName);

        if (searchTextboxElementName === 'emoji') {
            search_text_tab = '{{ $search_text_arr["search_in_emoji"] }}';
        } else if (searchTextboxElementName === 'sticker') {
            search_text_tab = '{{ $search_text_arr["search_in_sticker"] }}';
        } else if (searchTextboxElementName === 'emojicategory') {            
            search_text_tab = '{{ $search_text_arr["search_in_emojicategory"] }}';
        } else if (searchTextboxElementName === 'stickercategory') {            
            search_text_tab = '{{ $search_text_arr["search_in_stickercategory"] }}';
        }
        $('#query').attr("name", 'search_in_' + searchTextboxElementName);
        $('#search').attr("action", url);
        $('#query').val(search_text_tab);
    }

    $(document).ready(function () {
        $('#query').attr("name", 'search_in_emoji');
        $('#query').val('{{ $search_text }}');
        
        var hash = window.location.hash;
        if(hash) {
            var url = '{{ url("/emojis:contentId") }}';
            var search_text_box_name = 'search_in_' + hash;
            
            search_text_box_name = search_text_box_name.replace('#','');
            
            url = url.replace(':contentId', hash);
            $('#search').attr("action", url);
            $('#query').attr("name", search_text_box_name);
        }

    });
    
    $(document).ready(function() {
        $('#listEmojis').DataTable( {
            "bFilter": true,
            "lengthMenu": lengthMenu,
            "responsive": true,
            "order": [[0, 'asc']],
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [3,5]},
                {"bSearchable": false, "aTargets": [3,5]}
            ],
            "dom": 'lfrtipB',
            "oLanguage": {
                "sSearch": "Filter"
             },
            "buttons": [
                {"extend": 'csv', "exportOptions": {"columns": [ 0, 1, 2, 4]} },
                {"extend": 'excel', "exportOptions": {"columns": [  0, 1, 2, 4]} },
            ],
            "iDisplayLength": DefaultDisplayLength,
        } );
        $('#listStikers').DataTable( {
            "bFilter": true,
            "lengthMenu": lengthMenu,
            "responsive": true,
            "order": [[0, 'asc']],
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [3,5]},
                {"bSearchable": false, "aTargets": [3,5]}
            ],
            "dom": 'lfrtipB',
            "oLanguage": {
                "sSearch": "Filter"
             },
            "buttons": [
                {"extend": 'csv', "exportOptions": {"columns": [ 0, 1, 2, 4]} },
                {"extend": 'excel', "exportOptions": {"columns": [  0, 1, 2, 4]} },
            ],
            "iDisplayLength": DefaultDisplayLength,
        } );
        $('#listStickerCategories').DataTable( {
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
                {"extend": 'excel', "exportOptions": {"columns": [  0, 1, 2]} },
            ],
            "iDisplayLength": DefaultDisplayLength,
        } );
        $('#listEmojiCategories').DataTable( {
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
                {"extend": 'excel', "exportOptions": {"columns": [  0, 1, 2]} },
            ],
            "iDisplayLength": DefaultDisplayLength,
        } );
    } );   
</script>
@stop