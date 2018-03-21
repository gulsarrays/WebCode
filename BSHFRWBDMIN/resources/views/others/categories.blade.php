@extends('layouts.default')
@section('title')
Categories
@stop
@section('content')
<div class="content-wrapper" style="min-height: 440px;">

<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
	    <section class="content-header">
			<h1>Category List</h1>
			<!-- <ol class="breadcrumb">
				<li><a href="{{url('/other/users')}}"><i class="fa fa-dashboard"></i>
						Home</a></li>
				<li class="active">Categories</li>
			</ol> -->
		</section>
		<section class="content">
			<div class="box box-info">	
				<div class="box-header with-border">
					@include('includes.messages')
					<h3 class="box-title">Total Categories: {{count($categories)}}</h3>
					<!-- <h3 class="box-title">Category List</h3> -->
					<h3><a href="{{ url('others/createcategory') }}" class="btn btn-success"><i class="fa fa-plus"></i>Add Category</a></h3>
				</div>				
				
				<div class="box-body">
					<!-- <form id="search" class="right search_right ">
						<a class="fa fa-refresh text-green pull-right close_here" data-toggle="tooltip" title="Reset" href="http://bushfiresuperadmin.app/staff"></a>
						<div class=" col-md-4 padding-left has-feedback no-padding pull-right">
							<input id="query" placeholder="Search" class="form-control src_width text_box" name="q" type="text">
					     	<button type="submit" class="glyphicon glyphicon-search form-control-feedback"></button>
					    </div>     
						<input onclick="resetFormValues();" style="display:none;" type="submit" value="Submit">	  
					</form> -->
	    								
					<table id="example1" class="table table-bordered table-hover stuff_table">
						<thead>
	                        <tr>                                
	                            <th>No</th>
	                            <th>List Of Category</th>
	                            <th>Category image</th>
	                            <th class="text-center">Status</th>
	                            <th class="text-center">Action</th>
	                        </tr>
	                    </thead>
	                    <tbody>
                                <?php $i = 1?>
	                    	@foreach($categories as $category)
	                    		<tr>                        			
	                                <td>{{ $i++}}</td>
	                                <td>{{$category['categoryName']}}</td>
	                                <td>@if(!empty($category['categoryImage']))
	                                		<img src="{{ env('CHANNEL_API') }}channels/api/v1/channel/content/getContent/{{$category['categoryImage']}}"></td>
	                                	@endif	                                	
	                                <td class="text-center">
	                                	@if($category['isactive'] == 1)
										<span class="label label-success">Active</span>
										@else
										<span class="label label-error">Inactive</span>
										@endif
									</td>
									<td class="text-center">
										<a
										class="btn btn-box-tool fa fa-pencil text-aqua"
										data-toggle="tooltip" title="Edit"
										href="{{url('others/category/edit').'/'.$category['categoryId']}}"></a>
										<!-- <a
										class="btn btn-box-tool fa fa-trash text-yellow"
										data-toggle="modal" data-target="#confirm-delete" title="Delete"										
										data-href="{{url('others/category/delete').'/'.$category['categoryId']}}"></a> -->
									</td>
	                        	</tr>
	                    	@endforeach
	                    </tbody>
					</table>
					
					<div class="pagination clearfix">   
					    <input type="hidden" name="page" id="page" value="">
					</div>

					
					
	 			</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</section>
    </div>

</div>

</div>
<script>
    $(document).ready(function() {
        $('#example1').DataTable( {
            "bFilter": true,
            "lengthMenu": lengthMenu,
            "responsive": true,
            "order": [[0, 'asc']],
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [2,4]},
                {"bSearchable": false, "aTargets": [2,4]}
            ],
            "dom": 'lfrtipB',
            "oLanguage": {
                "sSearch": "Filter"
             },
            "buttons": [
                {"extend": 'csv', "stripHtml": false, "exportOptions": {"columns": [ 0, 1, 3]} },
                {"extend": 'excel', "stripHtml": false, "exportOptions": {"columns": [ 0, 1, 3]} },
            ],
            "iDisplayLength": DefaultDisplayLength,        
        } );
    } );
</script>
@stop