@if(isset($fromUrl))
<form id="search" class="right search_right " action="{{url($fromUrl)}}">
@else
<form id="search" class="right search_right ">
@endif
<a class="fa fa-refresh text-green pull-right close_here" data-toggle="tooltip" title="Reset" href="{{url($resetUrl)}}"></a>
		<div class=" col-md-4 padding-left has-feedback no-padding pull-right searchTextboxElementDiv">
		<?php 
		$url = Request::fullUrl();
	if(substr_count($url,'admin/country')>0){
		?>
		{!!Form::select('continent_id',[0=>'Select continent']+$continents->toArray(),
		\Request::get('continent_id'),['id'=>'search_continent_id'])!!}
	<?php	
		}
		if(substr_count($url,'admin/post')>0){
		?>
		 {!!Form::select('country_id',[0=>'Select country']+$countries->toArray(),
		 \Request::get('country_id'),['id'=>'search_country_id'])!!}
		  {!!Form::select('is_active',[NULL=>'Select staus',0=>'Unapprove',1=>'Approve'],
		 \Request::get('is_active'),['id'=>'search_country_id'])!!}
		<?php 
		}
	?>
		{!!Form::text('q',\Request::get('q'),['id'=>'query','placeholder'=>'Search','class'=>'form-control src_width text_box'])!!}
     <button type="submit" class="glyphicon glyphicon-search form-control-feedback"></button>
    </div>
     
		{!!Form::submit('Submit',array('onclick'=>'resetFormValues();','style'=>'display:none;'))!!}
	  
</form>

